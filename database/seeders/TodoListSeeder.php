<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TodoList;

class TodoListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TodoList::factory(20)->create();
    }
}
