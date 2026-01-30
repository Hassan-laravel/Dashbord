<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // 1. نبدأ الاستعلام الأساسي (المقالات المنشورة مع علاقاتها)
        $query = Post::with(['translations', 'images', 'categories', 'author'])
            ->where('status', 'published');

        // 2. التحقق من وجود كلمة بحث في الرابط (?search=...)
        if ($request->has('search') && $request->search != null) {
            $searchTerm = $request->search;

            // استخدام دالة whereTranslationLike التي توفرها الحزمة
            // هذه الدالة تبحث داخل جدول الترجمات عن العنوان الذي يشبه كلمة البحث
            // وتراعي اللغة الحالية التي تم تحديدها في الميدل وير
            // $query->whereTranslationLike('title', "%{$searchTerm}%");
            // البحث في جدول الترجمات بدون تحديد locale
            $query->whereHas('translations', function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%");
            });
            // البديل باستخدام علاقات لارافل الأصلية
            // $query->whereHas('translations', function ($q) use ($searchTerm) {
            //     $q->where('title', 'LIKE', "%{$searchTerm}%")
            //       ->where('locale', app()->getLocale()); // البحث في اللغة الحالية فقط
            // });

            // ملاحظة: إذا لم تعمل الدالة أعلاه في إصدارك، استخدم الكود البديل في الأسفل
        }
        // 3. الفلترة حسب التصنيف (Category) <-- هذا هو الجزء المفقود غالباً
    if ($request->filled('category_id')) {
        $query->whereHas('categories', function ($q) use ($request) {
            // نبحث في الجدول الوسيط عن المقالات التي تنتمي لهذا التصنيف
            $q->where('categories.id', $request->category_id);
        });
    }

        // 3. تنفيذ الاستعلام مع الترتيب والتقسيم
        $posts = $query->latest()->paginate(10);

        return PostResource::collection($posts);
    }


    public function show($slug)
    {
        // 1. البحث عن المقال الذي يمتلك هذا الـ slug (في أي لغة)
        // 2. تحميل العلاقات (الصور، التصنيفات، الترجمات) لضمان السرعة
        $post = Post::with(['translations', 'images', 'categories', 'author'])
            ->whereTranslation('slug', $slug)
            ->firstOrFail(); // يعيد 404 إذا لم يتم العثور عليه

        // 3. إرجاع المقال باستخدام نفس الـ Resource السابق
        // (سيتم تنسيق البيانات وترجمتها تلقائياً حسب اللغة المطلوبة)
        return new PostResource($post);
    }
}
