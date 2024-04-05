<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use App\Models\Commentaire;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use function PHPUnit\Framework\isNull;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::paginate(9);
        return view('index', ['articles' => $articles]);
    }

    public function indexAdmin()
    {
        $articles = Article::paginate(15);
        if(auth()->user()->type === User::ROLE_AUTHOR){
            $articles = Article::where('user_id', auth()->user()->id)->paginate(15);
        }
        return view('admin.articles.index', ['articles' => $articles]);
    }

    public function show(Article $article)
    {
        $commentaires = $article->commentaires->where('active', 1);
        $article->commentaires = $commentaires;
        return view("article", ['article' => $article]);
    }

    public function create()
    {
        return view("admin.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'contenu' => 'required',
            'category' => 'required',
            // 'image' => 'required|mimes:jpeg,jpg,png,gif',
            'user' => 'required'
        ]);

        $article = new Article();

        $path = $request->image->store('public/images');

        $article->image = $path;
        $article->title = $validated["title"];
        $article->contenu = $validated["contenu"];
        $article->user_id = $validated["user"];
        $article->categories()->sync($validated["category"]);
        $article->tags()->sync($validated["tags"]->explode(','));
        $article->save();

        return redirect()->route("articles.index");
    }

    public function edit(Article $article)
    {
        $categories = Categorie::where('active', true)->get();
        return view("admin.articles.edit", ['article' => $article, 'categories' => $categories]);
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required',
            'contenu' => 'required',
            'category' => 'required',
            // 'image' => 'required|mimes:jpeg,jpg,png,gif',
            'user' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->image->store('public');
            $article->image = $path;
        }

        $article->title = $validated["title"];
        $article->contenu = $validated["contenu"];
        $article->user_id = $validated["user"];
        $article->categories()->sync($validated["category"]);
        $tagIds = [];
        $tags = Str::of($request["tags"])->explode(',');
        foreach ($tags as $t) {
            $tag = Tag::where('nom', $t)->first();
            if(isNull($tag)){
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
            $articles = Article::where('title', "like", "%" . $keyword . "%")->orWhere('content', "like", "%" . $keyword . "%")->paginate(5)->withQueryString();
        }

        return view("search", ['articles' => $articles]);
    }
}
