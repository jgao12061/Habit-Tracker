<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habit;
use App\Models\User;

class HabitSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first(); // grabs the first user in your DB

        $habits = [
            ['title' => 'Drink 8 glasses of water', 'category' => 'Health'],
            ['title' => 'Read for 30 minutes',       'category' => 'Study'],
            ['title' => 'Morning workout',            'category' => 'Fitness'],
            ['title' => 'Meditate 10 minutes',        'category' => 'Mindfulness'],
            ['title' => 'Sketch daily',               'category' => 'Creative'],
            ['title' => 'Call a friend',              'category' => 'Social'],
        ];

        foreach ($habits as $habit) {
            Habit::create([
                'title'     => $habit['title'],
                'category'  => $habit['category'],
                'user_id'   => $user->id,
                'streak'    => rand(0, 10),
                'is_active' => true,
            ]);
        }
    }
}