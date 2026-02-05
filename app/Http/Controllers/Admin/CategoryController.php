<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Traits\HandlesGcsImage;

class CategoryController extends Controller
{
    use HandlesGcsImage;

    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        // The package handles saving translated data automatically as long as the array structure is correct
        Category::create($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', __('dashboard.messages.category_created'));
    }

    public function edit($id)
    {
        // Fetch the category with its translations
        $category = Category::with('translations')->findOrFail($id);

        // Prepare the basic data
        $response = [
            'id' => $category->id,
            'status' => $category->status,
        ];

        // Restructure translations so that keys are language codes (ar, en, nl)
        // This ensures compatibility with the frontend JavaScript logic
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
