<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = $this->search($request)->get()->paginate(15)->withQueryString();
        return view('admin.categories.index', ['categories' => $categories]);
    }

    public function categoryArticles(Categorie $category)
    {
        $articles = $category->articles->paginate(6);
        return view('category', ['category' => $category, 'articles' => $articles]);
    }

    public function search($request)
    {
        $keyword = Str::lower($request->keyword);
        $active = $request->has('active');
        $dateFrom = Str::lower($request->dateFrom);
        $dateTo = Str::lower($request->dateTo);

        $categories = Categorie::query();

        if (!empty($keyword)) {
            $categories = $categories->where('nom', "like", "%" . $keyword . "%");
        }

        if (!empty($dateFrom)) {
            $categories = $categories->whereDate('created_at', '>=', $dateFrom);
        }

        if (!empty($dateTo)) {
            $categories = $categories->whereDate('created_at', '<=', $dateTo);
        }

        if (!empty($active)) {
            $categories = $categories->where('active', $active);
        }

        return $categories;
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

        return redirect()->route("categories.index")->with([
            'message' => 'Category added successfully',
            'icon' => 'bx bx-check-circle',
            'type' => 'success'
        ]);
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

        return redirect()->route("categories.index")->with([
            'message' => 'Category updated successfully',
            'icon' => 'bx bx-check-circle',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $category)
    {
        $category->delete();

        return redirect()->back()->with([
            'message' => 'Category deleted successfully',
            'icon' => 'bx bx-check-circle',
            'type' => 'success'
        ]);
    }
}
