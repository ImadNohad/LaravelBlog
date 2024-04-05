<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::paginate(15);
        return view('admin.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required'
        ]);

        $categorie = new Categorie();
        $categorie->nom = $validated['nom'];
        $categorie->active = $request->boolean('active');
        $categorie->save();

        return redirect()->route("categories.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $category)
    {
        return view('categorie', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorie $category)
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $category)
    {
        $validated = $request->validate([
            'nom' => 'required'
        ]);

        $category->nom = $validated['nom'];
        $category->active = $request->boolean('active');
        $category->update();

        return redirect()->route("categories.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $category)
    {
        $category->delete();

        return redirect()->back();
    }
}
