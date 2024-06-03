<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('back.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('back.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        Category::create($request->post());
        return redirect()->route('categories.index')->with('message', 'Category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit(Category $category)
    {
        return view('back.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     */
    public function update(Request $request, Category $category)
    {
        $category->update($request->post());
        return back()->with(['ok' => 'The category has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}
