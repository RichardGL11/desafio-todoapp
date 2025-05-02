@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm">
            <div class="container">
                <x:todofilter/>
                <x:todocomponent/>
            </div>
        </div>
    </div>
</div>
@endsection
