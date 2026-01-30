<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        // الحزمة تتكفل بحفظ البيانات المترجمة تلقائياً طالما المصفوفة صحيحة
        Category::create($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', __('dashboard.messages.category_created'));
    }

public function edit($id)
    {
        // جلب التصنيف مع الترجمات
        $category = Category::with('translations')->findOrFail($id);

        // تجهيز البيانات الأساسية
        $response = [
            'id' => $category->id,
            'status' => $category->status,
        ];

        // إعادة تشكيل الترجمات لتكون المفاتيح هي أكواد اللغة (ar, en)
        // هذا ما يجعله متوافقاً مع كود الجافاسكربت
        foreach ($category->translations as $translation) {
            $response[$translation->locale] = [
                'name' => $translation->name,
                'slug' => $translation->slug,
                'meta_title' => $translation->meta_title,
                'meta_description' => $translation->meta_description,
            ];
        }

        return response()->json($response);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', __('dashboard.messages.category_updated'));
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', __('dashboard.messages.category_deleted'));
    }
}
