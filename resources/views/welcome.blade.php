@extends('layouts.app')

@section('content')
<div class="p-5 mb-4 bg-light rounded-3 shadow-sm border">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">{{ __('messages.welcome_title') }}</h1>
        <p class="col-md-8 fs-4">
            {{ __('messages.welcome_text') }}
        </p>
        <button class="btn btn-primary btn-lg" type="button">{{ __('messages.read_more') }}</button>
    </div>
</div>

<div class="row align-items-md-stretch">
    <div class="col-md-6">
        <div class="h-100 p-5 text-bg-dark rounded-3">
            <h2>{{ __('messages.box_one_title') }}</h2>
            <p>{{ __('messages.box_one_text') }}</p>
            <button class="btn btn-outline-light" type="button">Example button</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="h-100 p-5 bg-body-tertiary border rounded-3">
            <h2>{{ __('messages.box_two_title') }}</h2>
            <p>{{ __('messages.box_two_text') }}</p>
            <button class="btn btn-outline-secondary" type="button">Example button</button>
        </div>
    </div>
</div>
@endsection
