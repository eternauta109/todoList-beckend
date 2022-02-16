<?php

namespace Database\Factories;
use App\Models\{TodoList,User};

use Illuminate\Database\Eloquent\Factories\Factory;

class TodoListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = TodoList::class;
     
    public function definition()
    {
        $user=User::inRandomOrder()->first();
        return [
            
            'name'=>$this->faker->text(32),
            'user_id'=>$user->id

        ];
    }
}
