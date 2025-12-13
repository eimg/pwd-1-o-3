<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraphs(5, true),
            'feature_image' => sprintf('https://picsum.photos/seed/%s/800/400', $this->faker->uuid()),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }
}

