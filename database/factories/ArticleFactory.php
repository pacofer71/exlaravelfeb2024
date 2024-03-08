<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        fake()->addProvider(new \Mmo\Faker\PicsumProvider(fake()));
        return [
            'titulo' => fake()->unique()->sentence(nbWords: 4),
            'contenido' => fake()->text(),
            'category_id' => Category::all()->random()->id,
            'user_id'=>User::all()->random()->id,
            'imagen' => 'imagenes/' . fake()->picsum('public/storage/imagenes', 640, 480, false),
            'estado' => fake()->randomElement(["PUBLICADO", "BORRADOR"]),
        ];
    }
}
