<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache, Gate, Log};
use App\Models\Tag;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Cache::remember('tags.all', 120, function () {
            Log::info('🔥 Tags fetched from DATABASE');
            return Tag::latest()->get();
        });
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Gate::denies("tag-create")){
            return redirect()->back()->with('error', 'You have no create access');
        } 
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);
        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag created successfully');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
