<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Article $article)
    {
        $like = new Like();
        $like->user()->associate(auth()->user());
        $article->likes()->save($like);
        return $article->likes()->count();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $like = $article->likes()->where('user_id', auth()->user()->id)->where('article_id', $article->id);
        $like->delete();
        return $article->likes()->count();
    }
}
