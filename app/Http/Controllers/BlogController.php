<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Gate, Storage};
use App\Models\{Blog, Category, Tag};

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     
    public function index()
    {
        
        $blogs = Blog::latest()
            ->when(auth()->user()->role !== 'admin', function($query){
                $query->where('user_id', auth()->id());
            })
            ->when(auth()->user()->role == 'admin', function($query){
                $query->where('status', 'published');
            })
            ->simplePaginate(20);

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        if (Gate::denies('blog-create')) {
            return redirect()->back()
                ->with('error', 'You have no create access');
        }
        
        $categories = Category::all();
        $tags = Tag::orderBy('name')->get();

        return view('admin.blogs.create', compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tag' => 'nullable|array',
            'tags.*' => 'required|exists:tags,id',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        $blog = Blog::create([
            'user_id'        => auth()->id(),
            'title'          => $request->title,
            'slug'           => Str::slug($request->title),
            'content'        => $request->content,
            'featured_image' => $imagePath,
            'category_id'    => $request->category_id,
            'status'         => 'draft',
        ]);

        if ($request->filled('tags')) {
            $blog->tags()->sync($request->tags);
        }

        return redirect()
            ->route('blogs.index')
            ->with('success', 'Blog saved as draft');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::orderBy('name')->get();

        // Id of already attached tags
        $attachedTags = $blog->tags->pluck('id')->toArray();

        return view('admin.blogs.edit', compact('blog', 'categories','tags','attachedTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tag' => 'nullable|array',
            'tags.*' => 'required|exists:tags,id',
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }
        $blog = Blog::findOrFail($id);
        $blog->update([
            'user_id'        => auth()->id(),
            'title'          => $request->title,
            'slug'           => Str::slug($request->title),
            'content'        => $request->content,
            'featured_image' => $imagePath,
            'category_id'    => $request->category_id,
        ]);
        if ($request->filled('tags')) {
            $blog->tags()->sync($request->tags);
        }

        return redirect()
            ->route('blogs.index')
            ->with('success', 'Blog updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully');
    }
}
