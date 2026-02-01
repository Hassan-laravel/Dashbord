<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
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
        dd($request->all(), $request->file('image'));
        // التحقق (للغة الحالية فقط)
        $locale = app()->getLocale();
        $request->validate([
            "$locale.title" => 'required|string|max:255',
            "$locale.slug" => "nullable|string|max:255|unique:page_translations,slug",
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'status' => 'required|in:published,draft',
        ]);

        DB::beginTransaction();
// داخل PageController.php في دالة store

try {
    $data = $request->except(['image']);
    $data['user_id'] = Auth::id();

    if ($request->hasFile('image')) {
        // إذا فشل الرفع هنا، سينتقل الكود فوراً للـ catch ويظهر لك الخطأ الحقيقي
        $imageResult = $this->uploadImageToGcs($request->file('image'), 'pages');
        if ($imageResult) {
            $data['image'] = $imageResult['path'];
        }
    }

    Page::create($data);
    DB::commit();
    // ...
} catch (\Exception $e) {
    DB::rollBack();
    // هنا سيظهر لك الخطأ الحقيقي في أعلى الصفحة
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
        // ID الصفحة الحالية للاستثناء من فحص الرابط المكرر
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
