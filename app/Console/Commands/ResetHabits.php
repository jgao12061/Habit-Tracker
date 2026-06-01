<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Habit;

class ResetHabits extends Command
{
    protected $signature   = 'habits:reset';
    protected $description = 'Reset all habits at midnight';

    public function handle()
    {
        Habit::query()->update(['is_active' => true]);
        $this->info('Habits reset!');
    }
}