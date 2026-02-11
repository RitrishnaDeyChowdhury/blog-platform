<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache, Gate, Log};
use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Cache::remember('categories.all', 180, function () { 
            Log::info('🔥 Categories fetched from DATABASE');
            return Category::latest()->get();
        });
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Gate::denies("category-create")){
            return redirect()->back()->with('error', 'You have no create access');
        }
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully');
    
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
        if(Gate::denies("category-create")){
            return redirect()->back()->with('error', 'You have no edit access');
        }

        $category = Cache::remember("category:{$id}", 180, function() use ($id){
            Log::info("🔥 Category:{$id} fetched from DATABASE");
            return Category::findOrFail($id);
        }); 

        //dd($category);
        return view('admin.categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);


        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

        /**
     * Delete the specified resource in storage.
     */
    public function destroy(Category $category)
    {
        if(Gate::denies("category-create")){
            return redirect()->back()->with('error', 'You have no delete access');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
