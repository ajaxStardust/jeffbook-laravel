@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">{{ config('app.name', 'JeffBook') }}</h1>

    <h2 class="text-2xl mb-4">Categories</h2>

    @if($categories && $categories->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($categories as $category)
                <div class="border p-4 rounded shadow">
                    <h3 class="text-xl font-semibold mb-2">
                        <a href="{{ route('category.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                        <span class="text-gray-500 text-sm">({{ $category->posts->count() }} posts)</span>
                    </h3>

                    @if($category->description)
                        <p class="text-gray-600 mb-2">{{ $category->description }}</p>
                    @endif

                    @if($category->posts && $category->posts->count())
                        <ul class="list-disc list-inside text-gray-700 mb-2">
                            @foreach($category->posts as $post)
                                <li>
                                    <a href="{{ route('posts.show', [$category->slug, $post->slug]) }}">
                                        {{ $post->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 mb-2">No posts in this category yet.</p>
                    @endif

                    @auth
                        <a href="{{ route('posts.create', $category->slug) }}"
                           class="bg-blue-500 text-white px-2 py-1 rounded text-sm">
                           Create New Post
                        </a>
                    @endauth
                </div>
            @endforeach
        </div>
    @else
        <p>No categories found.</p>
    @endif
</div>
@endsection
