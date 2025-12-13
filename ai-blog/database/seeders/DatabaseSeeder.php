<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = $this->seedCategories();
        $users = $this->seedUsers();
        $posts = $this->seedPosts($users, $categories);
        $this->seedComments($users, $posts);
    }

    /**
     * @return Collection<int, Category>
     */
    protected function seedCategories(): Collection
    {
        $categoryNames = [
            'Technology',
            'Lifestyle',
            'Travel',
            'Food',
            'Productivity',
        ];

        return collect($categoryNames)->map(fn (string $name) => Category::create([
            'name' => $name,
        ]));
    }

    /**
     * @return Collection<int, User>
     */
    protected function seedUsers(): Collection
    {
        $users = [
            [
                'name' => 'Alice Writer',
                'email' => 'alice@example.com',
            ],
            [
                'name' => 'Bob Editor',
                'email' => 'bob@example.com',
            ],
        ];

        return collect($users)->map(fn (array $user) => User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => Hash::make('password'),
        ]));
    }

    /**
     * @param Collection<int, User> $users
     * @param Collection<int, Category> $categories
     * @return Collection<int, Post>
     */
    protected function seedPosts(Collection $users, Collection $categories): Collection
    {
        return collect(range(1, 20))->map(function () use ($users, $categories) {
            return Post::factory()
                ->for($users->random(), 'author')
                ->for($categories->random())
                ->create();
        });
    }

    /**
     * @param Collection<int, User> $users
     * @param Collection<int, Post> $posts
     */
    protected function seedComments(Collection $users, Collection $posts): void
    {
        foreach (range(1, 40) as $_) {
            Comment::factory()
                ->for($posts->random())
                ->for($users->random(), 'author')
                ->create();
        }
    }
}
