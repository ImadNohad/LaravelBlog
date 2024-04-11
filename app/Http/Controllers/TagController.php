<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tags = $this->search($request)->get()->paginate(15)->withQueryString();
        return view('admin.tags.index', ['tags' => $tags]);
    }

    public function search($request)
    {
        $keyword = Str::lower($request->keyword);
        $active = $request->has('active');
        $dateFrom = Str::lower($request->dateFrom);
        $dateTo = Str::lower($request->dateTo);

        $tags = Tag::query();

        if (!empty($keyword)) {
            $tags = $tags->where('nom', "like", "%" . $keyword . "%");
        }

        if (!empty($dateFrom)) {
            $tags = $tags->whereDate('created_at', '>=', $dateFrom);
        }

        if (!empty($dateTo)) {
            $tags = $tags->whereDate('created_at', '<=', $dateTo);
        }

        if (!empty($active)) {
            $tags = $tags->where('active', $active);
        }

        return $tags;
    }

    public function tagArticles(Tag $tag) {
        $articles = $tag->articles->paginate(6);
        return view('tag', ['tag' => $tag, 'articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required'
        ]);

        $tag = new Tag();
        $tag->nom = $validated['nom'];
        $tag->active = $request->boolean('active');
        $tag->save();

        return redirect()->route("tags.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return view('tag', ['tag' => $tag]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', ['tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'nom' => 'required'
        ]);

        $tag->nom = $validated['nom'];
        $tag->active = $request->boolean('active');
        $tag->update();

        return redirect()->route("tags.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->back();
    }
}
