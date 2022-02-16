<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, TodoList, Todo};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        TodoList::factory(20)->create();
        Todo::factory(10)->create();
    }
}
