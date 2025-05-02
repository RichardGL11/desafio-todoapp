<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TodoComponent extends Component
{
    public function __construct()
    {}
    public function render(): View|Closure|string
    {
        return view('components.todo-component',[
            'todos' => auth()->user()->todos
        ]);
    }
}
