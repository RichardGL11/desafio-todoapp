<?php

namespace App\Http\Controllers;

use App\Enums\TodoStatusEnum;
use App\Models\Todo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class MarkedAsCompletedController extends Controller
{
    public function __invoke(Todo $todo): Redirector|RedirectResponse
    {
        $this->authorize('update', $todo);
        $todo->status = TodoStatusEnum::COMPLETED->value;
        $todo->save();

        return redirect('/home');
    }
}
