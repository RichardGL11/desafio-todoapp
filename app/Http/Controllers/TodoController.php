<?php

namespace App\Http\Controllers;

use App\Actions\CreateTodoAction;
use App\DTO\TodoDTO;
use App\Enums\TodoStatusEnum;
use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class TodoController extends Controller
{
    public function create(): View
    {
        return view('CreateTodoView');
    }

    public function edit(Todo $todo): View
    {
        return view('EditTodoView', [
            'todo' => $todo,
            'status' => TodoStatusEnum::cases(),
        ]);
    }

    public function update(UpdateTodoRequest $request, Todo $todo): RedirectResponse
    {
        $this->authorize('update', $todo);
        $todo->title = $request->validated('title');
        $todo->description = $request->validated('description');
        $todo->status = $request->validated('status') ?? $todo->status;
        $todo->save();

        return redirect('/home');
    }

    public function store(TodoStoreRequest $request): RedirectResponse
    {
        $dto =  TodoDTO::make(...$request->validated());
        CreateTodoAction::execute($dto);
        return redirect('/home', 201);
    }

    public function delete(Todo $todo): RedirectResponse
    {
        $this->authorize('delete', $todo);
        $todo->delete();

        return redirect('/home');
    }
}
