<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Commentaire;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $comments = $this->search($request);
        $articles = Article::whereHas('commentaires')->with('commentaires')->with('user')->get();
        $authors = User::whereHas('commentaires')->with('commentaires.article.user')->get();

        $user = auth()->user();
        if ($user->type === User::ROLE_AUTHOR) {
            $comments = $comments->whereHas('article.user', function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })->get();

            $articles = $articles->where('user_id', auth()->user()->id);
            $authors = $articles->pluck('commentaires')->flatten()->pluck('user')->flatten();
        }

        if (!empty($request->article)) {
            $authors = $authors->pluck('commentaires')->flatten()
                ->where('article_id', $request->article)
                ->flatten()->pluck('user')->flatten();
        }

        return view("admin.articles.comments.index", [
            'comments' => $comments->paginate(10)->withQueryString(),
            'articles' => $articles,
            'authors' => $authors
        ]);
    }

    public function search($request)
    {
        $keyword = Str::lower($request->keyword);
        $article = $request->article;
        $author = $request->author;
        $dateFrom = Str::lower($request->dateFrom);
        $dateTo = Str::lower($request->dateTo);

        $comments = Commentaire::query()->with('user')->with('article');

        if (!empty($keyword)) {
            $comments = $comments->where('contenu', "like", "%" . $keyword . "%");
        }

        if (!empty($article)) {
            $comments = $comments->where('article_id', $article);
        }

        if (!empty($author)) {
            $comments = $comments->where('user_id', $author);
        }

        if (!empty($dateFrom)) {
            $comments = $comments->whereDate('created_at', '>=', $dateFrom);
        }

        if (!empty($dateTo)) {
            $comments = $comments->whereDate('created_at', '<=', $dateTo);
        }

        return $comments;
    }

    public function articleComments(Article $article)
    {
        $comments = $article->commentaires()->with('user')->paginate(10);
        return view("admin.articles.comments.index", ['article' => $article, 'comments' => $comments]);
    }

    public function acceptComment(Commentaire $comment)
    {
        $comment->active = !$comment->active;
        $comment->update();
        return redirect()->back()->with([
            'message' => $comment->active ? 'Comment Approved.' : 'Comment Disapproved.',
            'icon' => 'bx bx-check-circle',
            'type' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commentaire $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commentaire $comment)
    {
        //
    }

    public function destroy(Commentaire $comment)
    {
        $comment->delete();

        return redirect()->back()->with([
            'message' => 'Comment deleted successfully',
            'icon' => 'bx bx-check-circle',
            'type' => 'success'
        ]);
    }
}
