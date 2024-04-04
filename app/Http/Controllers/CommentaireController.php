<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Commentaire;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Commentaire::with('user')->with('article')->paginate(10);
        return view("admin.articles.comments.index", ['comments' => $comments]);
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
        return redirect()->back();
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

        return redirect()->route("comments", $comment->article);
    }
}
