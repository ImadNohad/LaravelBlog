<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\Commentaire;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::paginate(9);
        return view('index', ['articles' => $articles]);
    }

    public function search($request)
    {
        $keyword = Str::lower($request->keyword);
        $category = $request->category;
        $author = $request->author;
        $dateFrom = Str::lower($request->dateFrom);
        $dateTo = Str::lower($request->dateTo);

        $articles = Article::query();

        if (!empty($keyword)) {
            $articles = $articles->where('title', "like", "%" . $keyword . "%")
                ->orWhere('contenu', "like", "%" . $keyword . "%");
        }

        if (!empty($category)) {
            $articles->whereHas('categories', function ($query) use ($category) {
                return $query->where('categorie_id', $category);
            });
        }

        if (!empty($author)) {
            $articles = $articles->where('user_id', $author);
        }

        if (!empty($dateFrom)) {
            $articles = $articles->whereDate('created_at', '>=', $dateFrom);
        }

        if (!empty($dateTo)) {
            $articles = $articles->whereDate('created_at', '<=', $dateTo);
        }

        return collect($articles->get());
    }

    public function indexAdmin(Request $request)
    {
        $articles = $this->search($request);
        $categories = Categorie::where('active', true)->get();
        $authors = User::whereHas('articles')->get();

        $user = auth()->user();
        if ($user->type === User::ROLE_AUTHOR) {
            $articles = $articles->where('user_id', auth()->user()->id);
            $categories = Categorie::whereHas('articles.user', function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })->where('active', true)->get();
        }

        return view('admin.articles.index', [
            'articles' => $articles->paginate(10)->withQueryString(),
            'categories' => $categories,
            'authors' => $authors
        ]);
    }

    public function show(Article $article)
    {
        $commentaires = $article->commentaires->where('active', 1);
        $article->commentaires = $commentaires;
        $userLike = false;
        if (auth()->check()) {
            $userLike = $article->likes()->where('user_id', auth()->user()->id)->count() > 0;
        }
        return view("article", ['article' => $article, 'userLike' => $userLike]);
    }

    public function create()
    {
        $categories = Categorie::where('active', true)->get();
        return view("admin.articles.create", ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'contenu' => 'required',
            'category' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif',
            'user' => 'required'
        ]);

        $article = new Article();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $request->image->store('public/images');
            $article->imageURL = $file->hashName();
        }

        $article->title = $validated["title"];
        $article->contenu = $validated["contenu"];
        $article->user_id = $validated["user"];

        $article->save();

        $article->categories()->attach($validated["category"]);

        $tagIds = [];
        $tags = Str::of($request["tags"])->explode(',');
        foreach ($tags as $t) {
            $tag = Tag::where('nom', $t)->first();
            if (empty($tag)) {
                $tag = new Tag();
                $tag->nom = $t;
                $tag->save();
            }
            array_push($tagIds, $tag->id);
        }

        $article->tags()->attach($tagIds);

        return redirect()->route("articles.index");
    }

    public function edit(Article $article)
    {
        $categories = Categorie::where('active', true)->get();
        $tags = Tag::where('active', true)->get();
        return view("admin.articles.edit", [
            'article' => $article,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required',
            'contenu' => 'required',
            'category' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif',
            'user' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $request->image->store('public/images');
            $article->imageURL = $file->hashName();
        }

        $article->title = $validated["title"];
        $article->contenu = $validated["contenu"];
        $article->user_id = $validated["user"];
        $article->categories()->sync($validated["category"]);

        //$article->tags()->sync($request->tags);

        $tagIds = [];
        $tags = Str::of($request["tags"])->explode(',');
        foreach ($tags as $t) {
            $tag = Tag::where('nom', $t)->first();
            if (empty($tag)) {
                $tag = new Tag();
                $tag->nom = $t;
                $tag->save();
            }
            array_push($tagIds, $tag->id);
        }
        $article->tags()->sync($tagIds);

        $article->update();

        return redirect()->route("articles.index");
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route("articles.index");
    }

    public function storeComment(Request $request, Article $article)
    {
        $validated = $request->validate([
            'comment' => 'required',
        ]);

        $newComment = new Commentaire();
        $newComment->contenu = $validated["comment"];
        $newComment->user()->associate(auth()->user());
        $newComment->active = false;

        $article->commentaires()->save($newComment);

        return view("article", ['article' => $article]);
    }

    public function searchArticles()
    {
        $keyword = Str::lower(request("keyword"));
        $articles = Article::paginate(5);

        if (!empty($keyword)) {
            $articles = Article::where('title', "like", "%" . $keyword . "%")
                ->orWhere('contenu', "like", "%" . $keyword . "%")
                ->paginate(5)
                ->withQueryString();
        }

        return view("search", ['articles' => $articles]);
    }
}
