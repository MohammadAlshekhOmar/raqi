<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Editor;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arabic_faker = Faker::create('ar_JO');
        return [
            'editor_id' => Editor::inRandomOrder()->first()->id,
            'ar' => [
                'title' => $arabic_faker->name(),
                'text' => $arabic_faker->name(),
            ],
            'en' => [
                'title' => $this->faker->name(),
                'text' => $this->faker->name(),
            ],
        ];
    }
}
