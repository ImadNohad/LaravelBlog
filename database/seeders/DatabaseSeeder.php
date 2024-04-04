<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Categorie;
use App\Models\Commentaire;
use App\Models\Like;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(5)->has(
            Article::factory(5)
                ->has(Categorie::factory(5))
                ->has(Commentaire::factory(15))
                ->has(Like::factory(5))
                ->has(Tag::factory(5))
        )->create();
    }
}
