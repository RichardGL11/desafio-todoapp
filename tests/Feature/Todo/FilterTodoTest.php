<?php

namespace Tests\Feature\Todo;

use App\Enums\TodoStatusEnum;
use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FilterTodoTest extends TestCase
{
    #[Test]
    public function it_should_filter_the_todo_by_the_status():void
    {
       $user =  User::factory()->create();
       $completedTodo = Todo::factory(10)->for($user)->completed()->create();
       $pendingTodo = Todo::factory(10)->for($user)->create();
       $this->actingAs($user);
       $response = $this->from('/home')->get('/home?status=PENDING');

       $pendingTodo->each(function($todo) use ($response){
           $response->assertSeeText($todo->title);
           $response->assertSeeText($todo->status);
           $response->assertSeeText($todo->decription);
       });
       $response->assertDontSeeText('COMPLETED');

        $response = $this->from('/home')->get('/home?status=COMPLETED');

        $completedTodo->each(function($todo) use ($response){
            $response->assertSeeText($todo->title);
            $response->assertSeeText($todo->status);
            $response->assertSeeText($todo->decription);
        });
        $response->assertDontSeeText('PENDING');
    }

    #[Test]
    public function test_pagination():void
    {
       $user =  User::factory()->create();
       Todo::factory(20)->for($user)->completed()->create();
       $this->actingAs($user);
       $response = $this->get('/home');
       $response->assertSeeText('Previous');
       $response->assertSeeText('Next');
    }


}
