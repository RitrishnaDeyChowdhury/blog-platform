<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\{Blog, Category};
use App\Http\Controllers\Controller;

class CategoryBlogController extends Controller
{
    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $blogs = $category->blogs()
            ->where('status', 'published')
            ->latest()
            ->paginate(6);
        // dd($blogs);
        
        return view('frontend.blogs.category', compact('category', 'blogs'));
    }

    public function index(){
        $blogs = Blog::with('tags')
            ->where('status', 'published')
            ->latest()
            ->paginate(6);
        // dd($blogs);

        $categories = Category::all();

        return view('frontend.blogs.index', compact('blogs','categories'));
    }

    public function show(string $slug)
    {
        $blog = Blog::with('tags')
            ->where('slug', $slug)->firstOrFail();

        $categories = Category::all();

        // Get related blogs with same category excluding the current one
        $relatedBlogs = Blog::where('category_id', $blog->category_id)
                        ->where('id', '!=', $blog->id)
                        ->latest()
                        ->take(5)
                        ->get();

        return view('frontend.blogs.show', compact('blog','categories','relatedBlogs'));
    }

    public function search(Request $request)
    {
        $query = $request->input('search');

        $blogs = Blog::with('tags')
            ->where('status', 'published')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('title', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%")
                        ->orWhereHas('tags', function ($tagQuery) use ($query) {
                            $tagQuery->where('name', 'like', "%{$query}%");
                        });
                });
            })
            ->distinct()
            ->latest()
            ->paginate(10)
            ->withQueryString();
        //dd($blogs);

        return view('frontend.blogs.search', compact('blogs', 'query'));
    }


}
