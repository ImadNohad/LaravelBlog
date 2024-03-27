<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        fake()->addProvider(new FakerPicsumImagesProvider(fake()));
        $paragraphs = fake()->paragraphs(rand(10, 30));
        $title = fake()->realText(50);
        $post = "";
        foreach ($paragraphs as $para) {
            $para = fake()->paragraph(rand(3, 20), true);
            $post .= "<p>{$para}</p>";
        }

        return [
            'title' => $title,
            'contenu' => $post,
            'imageURL' => fake()->imageUrl(768, 1152),
            'user_id' => User::factory(),
        ];
    }
}