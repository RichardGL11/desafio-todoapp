<?php

namespace App\Http\Controllers;

use App\Enums\TodoStatusEnum;
use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    public function create(): View
    {
        return view('CreateTodoView');
    }


    public function update(UpdateTodoRequest $request,Todo $todo):void
    {
        $this->authorize('update',$todo);
        $todo->title = $request->validated('title');
        $todo->description = $request->validated('description');
        $todo->status = $request->validated('status');
        $todo->save();
    }
    public function store(TodoStoreRequest $request): Application|Redirector|RedirectResponse
    {
        Todo::query()->create([
           'title' => $request->validated('title'),
           'description' => $request->validated('description'),
           'status' => TodoStatusEnum::PENDING->value,
           'user_id' => auth()->user()->id
        ]);
        return redirect('/home',201);
    }
}
