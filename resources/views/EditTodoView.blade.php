@extends('layouts.app')
@section('content')
<div>
    <h3 class="p-2 text-center fw-bold">Edit Todo: {{$todo->id}}</h3>
    <form action="{{route('todos.update',$todo)}}" method="POST" class="p-4">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$todo->title}}">
            @error('title')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$todo->description}}">
            @error('description')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" id="status">
                @foreach($status as $statusEnum)
                    <option value="{{ $statusEnum->value }}"
                        {{ old('status', $todo->status) == $statusEnum->value ? 'selected' : '' }}>
                        {{ $statusEnum->name }} <!-- Exibe o nome do case -->
                    </option>
                @endforeach
            </select>
            @error('status')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
