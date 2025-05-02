<?php

namespace Tests\Feature\Todo;

use App\Enums\TodoStatusEnum;
use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ListTodoTest extends TestCase
{
    #[Test]
    public function it_should_see_all_todos_that_is_mine():void
    {
       $user =  User::factory()->create();
       $todos = Todo::factory(10)->for($user)->create();
       $this->actingAs($user);

       $response = $this->get('/home');

       $todos->each(function ($todo) use ($response){
           $response->assertSee($todo->title);
           $response->assertSee($todo->description);
           $response->assertSee($todo->status);
       });
    }
    #[Test]
    public function it_should_see_nothing():void
    {
       $user =  User::factory()->create();
       $todos = Todo::factory(10)->create();
       $this->actingAs($user);

       $response = $this->get('/home');

       $todos->each(function ($todo) use ($response){
           $response->assertDontSee($todo->title);
           $response->assertDontSee($todo->description);
           $response->assertDontSee($todo->status);
       });

       $response->assertSee('There is no Todo');
    }
}
