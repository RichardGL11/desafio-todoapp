<?php

namespace App\Http\Controllers;

use App\Enums\TodoStatusEnum;
use App\Http\Requests\TodoStoreRequest;
use App\Models\Todo;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class TodoController extends Controller
{
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
