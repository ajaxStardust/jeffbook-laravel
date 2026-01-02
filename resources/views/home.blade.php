@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ config('app.name', 'JeffBook') }}</h1>

    {{-- Categories --}}
    <h2>Categories</h2>

    @if($categories && $categories->count())
        @foreach($categories as $category)
            <div class="category mb-4 p-3 border rounded">
                <h3>{{ $category->name }}
                    <small class="text-muted">({{ $category->posts ? $category->posts->count() : 0 }} posts)</small>
                </h3>

                <p>{{ $category->description ?? '' }}</p>

                @if($category->posts && $category->posts->count())
                    <ul class="list-group">
                        @foreach($category->posts as $post)
                            <li class="list-group-item">
                                <a href="{{ url('/posts/' . $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                                @if($post->subtitle)
                                    - <em>{{ $post->subtitle }}</em>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No posts in this category yet.</p>
                @endif
            </div>
        @endforeach
    @else
        <p>No categories found.</p>
    @endif
</div>
@endsection
