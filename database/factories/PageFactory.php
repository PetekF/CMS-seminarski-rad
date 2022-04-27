<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
// use \Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->words(4, true);

        return [
            'id' => Str::uuid(),
            'title' => $title,
            'slug' => Str::slug($title),
            'author_id' => null,
            'image_path' => '/test/image',
            'body' => $this->faker->text(1000),
            'is_published' => 0,
            'first_published_at' => null
        ];
    }
}
