<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\PostResource;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
public function index()
    {
        $categories = Category::where('status', true)->get();
        return CategoryResource::collection($categories);
    }
public function show($slug)
    {
        $category = Category::whereTranslation('slug', $slug)
                            ->where('status', true)
                            ->firstOrFail();

        // هنا نستخدم العلاقة posts() التي أصلحناها في الخطوة 1
        $posts = $category->posts()
                          ->with(['translations', 'images', 'categories'])
                          ->where('status', 'published')
                          ->latest()
                          ->paginate(10);

        return response()->json([
            'category' => new CategoryResource($category),
            'posts' => PostResource::collection($posts)->response()->getData(true)
        ]);
    }

}
