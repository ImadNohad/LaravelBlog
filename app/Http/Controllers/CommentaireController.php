<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Commentaire;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Article $article)
    {
        $comments = $article->comments()->paginate(10);
        return view("admin.comments", ['article' => $article, 'comments' => $comments]);
    }

    public function destroy(Commentaire $comment)
    {
        $comment->delete();

        return redirect()->route("comments", $comment->article);
    }
}
