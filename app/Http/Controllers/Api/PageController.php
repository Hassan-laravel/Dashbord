<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Http\Resources\PageResource;

class PageController extends Controller
{
    // قائمة الصفحات (مفيد للقوائم وروابط الفوتر)
    public function index()
    {
        $pages = Page::where('status', 'published')->get();

        // هنا نرجع فقط العناوين والروابط لتخفيف الحمل (اختياري)
        // أو نرجع الريسورس كاملاً
        return PageResource::collection($pages);
    }

    // عرض صفحة واحدة حسب الرابط (slug)
    public function show($slug)
    {
        $page = Page::whereTranslation('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();

        return new PageResource($page);
    }
}
