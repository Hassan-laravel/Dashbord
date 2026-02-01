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
        // 1. جلب التصنيفات لاستخدامها في القائمة المنسدلة
        $categories = Category::all();

        // 2. بناء الاستعلام
        $query = Post::with(['translations', 'author', 'categories']);

        // --- الفلترة ---

        // أ) البحث بالعنوان (مترجم)
        if ($request->filled('search')) {
            $query->whereTranslationLike('title', '%' . $request->search . '%');
        }

        // ب) الفلترة بالتصنيف (Many-to-Many)
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // ج) الفلترة بالحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. الترتيب والتقسيم
        $posts = $query->latest()->paginate(10);

        // 4. إذا كان الطلب AJAX (جاء من الفلتر)
        if ($request->ajax()) {
            // نرجع HTML فقط (الجدول + الترقيم)
            return response()->json([
                'html' => view('admin.posts.partials.table_rows', compact('posts'))->render(),
                'pagination' => (string) $posts->links() // نرسل الترقيم الجديد أيضاً
            ]);
        }

        // 5. الطلب العادي (أول مرة)
        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        // 1. جلب التصنيفات المفعلة فقط (status = 1 او true)
        // 2. استخدام with('translations') لتحسين الأداء
        $categories = Category::with('translations')->where('status', true)->get();

        // 3. التأكد من أن ملف العرض موجود في المسار الصحيح
        // المسار: resources/views/admin/posts/create.blade.php
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
            // التعديل هنا: استخدام الترجمة للرسالة
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

    public function update(UpdatePostRequest $request, Post $post)
    {
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

            // if ($request->has('categories')) {
            //     $post->categories()->sync($request->categories);
            // } else {
            //     $post->categories()->detach();
            // }

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
            // التعديل هنا
            return redirect()->route('admin.posts.index')
                ->with('success', __('dashboard.messages.post_updated'));
        } catch (\Exception $e) {
            DB::rollBack();
            // هذا السطر سيطبع لك الخطأ الحقيقي بدلاً من 500
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
        // التعديل هنا
        return back()->with('success', __('dashboard.messages.post_deleted'));
    }
}
