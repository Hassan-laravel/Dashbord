<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PostImage;
use App\Traits\HandlesGcsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    use HandlesGcsImage;

    public function index()
    {
        $pages = Page::with('translations', 'author')->latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        // Validation (for the current locale only)
        $locale = app()->getLocale();
        $request->validate([
            "$locale.title" => 'required|string|max:255',
            "$locale.slug" => "nullable|string|max:255|unique:page_translations,slug",
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'status' => 'required|in:published,draft',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->except(['image']);
            $data['user_id'] = Auth::id();

            if ($request->hasFile('image')) {
                // If upload fails here, it will jump to the catch block and display the actual error
                $imageResult = $this->uploadImageToGcs($request->file('image'), 'pages');
                if ($imageResult) {
                    $data['image'] = $imageResult['path'];
                }
            }

            Page::create($data);

            DB::commit();

            return redirect()->route('admin.pages.index')->with('success', __('dashboard.messages.success'));

        } catch (\Exception $e) {
            DB::rollBack();
            // The actual error message will be displayed at the top of the page
            return back()->with('error', "GCS Error: " . $e->getMessage())->withInput();
        }
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $locale = app()->getLocale();
        // Current page ID to exclude from the unique slug check
        $pageId = $page->id;

        $request->validate([
            "$locale.title" => 'required|string|max:255',
            "$locale.slug" => "nullable|string|max:255|unique:page_translations,slug,{$pageId},page_id",
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'status' => 'required|in:published,draft',
        ]);

        try {
            $data = $request->except(['image']);

            if ($request->hasFile('image')) {
                $imageResult = $this->updateImageInGcs($page->image ?? '', $request->file('image'), 'pages');
                if ($imageResult) {
                    $data['image'] = $imageResult['path'];
                }
            }

            $page->update($data);

            return redirect()->route('admin.pages.index')->with('success', __('dashboard.messages.success'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy(Page $page)
    {
        if ($page->image) {
            $this->deleteImageFromGcs($page->image);
        }
        $page->delete();
        return back()->with('success', __('dashboard.messages.success'));
    }
}
