@extends('admin.layouts.app')

@section('title', __('dashboard.general.dashboard'))
@section('header_title', __('dashboard.general.dashboard'))

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-body py-5 text-center">
        <div class="mb-4">
            <i class="bi bi-speedometer2 display-1 text-secondary opacity-25"></i>
        </div>
        <h2 class="fw-bold text-secondary">{{ __('dashboard.general.dashboard') }}</h2>
        {{-- استبدال النص الثابت بنص مترجم مع تمرير اسم المستخدم --}}
        <p class="text-muted fs-5">
            {{-- {{ __('dashboard.general.welcome_msg', ['name' => auth()->user()->name]) }} --}}
            {!! __('dashboard.general.welcome_msg', ['name' => auth()->user()->name]) !!}
        </p>
    </div>
</div>

@endsection
