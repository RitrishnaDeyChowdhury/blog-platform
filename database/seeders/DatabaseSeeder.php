<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Blog, Category, User};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $users = User::all();           // fetch all existing users
        $categories = Category::all();  // fetch all existing categories

        Blog::factory(50)->create([
            'user_id' => function() use ($users) {
                return $users->random()->id;   // pick random user
            },
            'category_id' => function() use ($categories) {
                return $categories->random()->id; // pick random category
            },
        ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
