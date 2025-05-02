<div class="card-group small">
    @forelse($todos as $todo)
        <div class="card m-3 border-0 flex-row" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title fw-bold text-uppercase">{{$todo->title}}</h5>
                <h6 @class([
                'card-subtitle',
                 'mb-2',
                 'text-success' => $todo->status == \App\Enums\TodoStatusEnum::COMPLETED,
                 'text-warning' => $todo->status == \App\Enums\TodoStatusEnum::PENDING,
                 ])>
                    {{$todo->status}}</h6>
                <p class="card-text">{{$todo->description}}</p>
                <a href="#" class="card-link">Edit</a>
                <a href="#" class="card-link">Mark as Completed</a>
            </div>
        </div>
        @empty
        <p>There is no Todo</p>
    @endforelse
</div>
