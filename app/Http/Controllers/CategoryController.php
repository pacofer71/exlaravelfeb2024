<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use LVR\Colour\Hex;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Category::orderBy('nombre')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>['required', 'string', 'min:3', 'unique:categories,nombre'],
            'color'=>['required', new Hex],
        ]);
        Category::create($request->all());
        return redirect()->route('categories.index')->with('mensaje', 'Categoria creada!!');
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        
        $request->validate([
            'nombre'=>['required', 'string', 'min:3', 'unique:categories,nombre,'.$category->id],
            'color'=>['required', new Hex],
        ]);
        $category->update($request->all());
        return redirect()->route('categories.index')->with('mensaje', 'Categoria actualizada!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();return redirect()->route('categories.index')->with('mensaje', 'Categoria borrada!!');

    }
}
