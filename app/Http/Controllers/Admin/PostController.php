<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\PostImage;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\admin\UpdatePostRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Traits\HandlesGcsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use HandlesGcsImage;

    public function index(Request $request)
    {
        // 1. Fetch categories for the filter dropdown
        $categories = Category::all();

        // 2. Build the query
        $query = Post::with(['translations', 'author', 'categories']);

        // --- Filtering ---

        // A) Search by title (Translated)
        if ($request->filled('search')) {
            $query->whereTranslationLike('title', '%' . $request->search . '%');
        }

        // B) Filter by category (Many-to-Many relationship)
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // C) Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Sorting and Pagination
        $posts = $query->latest()->paginate(10);

        // 4. Handle AJAX requests (from filters)
        if ($request->ajax()) {
            // Return HTML only (table rows + pagination links)
            return response()->json([
                'html' => view('admin.posts.partials.table_rows', compact('posts'))->render(),
                'pagination' => (string) $posts->links() // Send updated pagination links
            ]);
        }

        // 5. Standard request (initial load)
        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        // 1. Fetch only active categories (status = 1 or true)
        // 2. Use with('translations') for better performance (Eager Loading)
        $categories = Category::with('translations')->where('status', true)->get();

        // 3. Ensure the view file exists at: resources/views/admin/posts/create.blade.php
        return view('admin.posts.create', compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except(['image', 'gallery', 'categories']);
            $data['user_id'] = Auth::id();

            if ($request->hasFile('image')) {
                $imageResult = $this->uploadImageToGcs($request->file('image'), 'posts/featured');
                if ($imageResult) {
                    $data['image'] = $imageResult['path'];
                }
            }

            $post = Post::create($data);

            if ($request->has('categories')) {
                $post->categories()->attach($request->categories);
            }

            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $imageResult = $this->uploadImageToGcs($file, 'posts/gallery');
                    if ($imageResult) {
                        PostImage::create([
                            'post_id' => $post->id,
                            'image_path' => $imageResult['path'],
                        ]);
                    }
                }
            }

            DB::commit();

            // Redirect with translated success message
            return redirect()->route('admin.posts.index')
                ->with('success', __('dashboard.messages.post_created'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit(Post $post)
    {
        $categories = Category::with('translations')->where('status', true)->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $locale = app()->getLocale();
        $postId = $post->id;

        // Manual validation for translated fields
        $request->validate([
            "$locale.title" => 'required|string|max:255',
            "$locale.slug" => "nullable|string|max:255|unique:post_translations,slug,{$postId},post_id",
            'status' => 'required|in:published,draft',
            'categories' => 'nullable|array',
            'image' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['image', 'gallery', 'categories']);

            if ($request->hasFile('image')) {
                $imageResult = $this->updateImageInGcs($post->image ?? '', $request->file('image'), 'posts/featured');
                if ($imageResult) {
                    $data['image'] = $imageResult['path'];
                }
            }

            $post->update($data);

            if ($request->has('categories')) {
                $post->categories()->sync($request->categories);
            } else {
                $post->categories()->detach();
            }

            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $imageResult = $this->uploadImageToGcs($file, 'posts/gallery');
                    if ($imageResult) {
                        PostImage::create([
                            'post_id' => $post->id,
                            'image_path' => $imageResult['path'],
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.posts.index')
                ->with('success', __('dashboard.messages.post_updated'));
        } catch (\Exception $e) {
            DB::rollBack();
            // Return detailed error response for debugging
            return response()->json(['error' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]);
        }
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            $this->deleteImageFromGcs($post->image);
        }
        foreach ($post->images as $img) {
            $this->deleteImageFromGcs($img->image_path);
        }
        $post->delete();

        return back()->with('success', __('dashboard.messages.post_deleted'));
    }

    public function deleteImage($id)
    {
        try {
            $image = PostImage::findOrFail($id);

            // 1. Delete image from Google Cloud Storage using the Trait
            if ($image->image_path) {
                $this->deleteImageFromGcs($image->image_path);
            }

            // 2. Delete the record from the database
            $image->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
