<div class="container">
    <div class="row justify-content-center">
        @forelse($todos as $todo)
            <div class="col-sm-4 col-md-3 mb-4">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-uppercase">{{$todo->title}}</h5>
                        <h6 @class([
                            'card-subtitle',
                            'mb-2',
                            'text-success' => $todo->status == \App\Enums\TodoStatusEnum::COMPLETED,
                            'text-warning' => $todo->status == \App\Enums\TodoStatusEnum::PENDING,
                        ])>
                            {{$todo->status}}
                        </h6>
                        <p class="card-text">{{$todo->description}}</p>
                        <a href="{{route('todos.edit',$todo)}}" class="card-link">Edit</a>
                        <a href="{{route('todos.mark.completed',$todo)}}" class="card-link">Mark as Completed</a>
                    </div>
                </div>
            </div>
        @empty
            <p>There is no Todo</p>
        @endforelse
        {{$todos->links()}}
    </div>
</div>

