<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function categories(){
        return $this->belongsToMany(Categorie::class)->withTimestamps();;
    }

    public function commentaires(){
        return $this->hasMany(Commentaire::class)->where('comment_parent', null);;
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class)->withTimestamps();;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
