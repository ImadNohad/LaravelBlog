<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Commentaire;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $isAdmin = auth()->user()->type === User::ROLE_VISITEUR;
        $view = $isAdmin ? 'articles.index' : 'home';
        $count = $isAdmin ? 15 : 9;
        $articles = Article::paginate($count);
        return to_route($view, ['articles' => $articles]);
    }

    public function show(Article $article)
    {
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
            'content' => 'required',
            // 'image' => 'required|mimes:jpeg,jpg,png,gif',
            'user' => 'required'
        ]);

        $article = new Article();

        $path = $request->image->store('public/images');

        $article->image = $path;
        $article->title = $validated["title"];
        $article->content = $validated["content"];
        $article->user_id = $validated["user"];
        $article->save();

        return redirect()->route("articles.index");
    }

    public function edit(Article $article)
    {
        return view("admin.edit", ['article' => $article]);
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            // 'image' => 'required|mimes:jpeg,jpg,png,gif',
            'user' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->image->store('public');
            $article->image = $path;
        }

        $article->title = $validated["title"];
        $article->content = $validated["content"];
        $article->user_id = $validated["user"];

        $article->update();

        return redirect()->route("articles.index");
    }

    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();

        return redirect()->route("articles.index");
    }

    public function storeComment(Request $request, Article $article)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'comment' => 'required',
        ]);

        $newComment = new Commentaire();
        $newComment->name = $validated["name"];
        $newComment->email = $validated["email"];
        $newComment->comment = $validated["comment"];

        $article->comments()->save($newComment);

        return view("post", ['article' => $article]);
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