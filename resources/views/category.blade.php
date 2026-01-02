@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ $category->name }}</h1>

    @if($category->description)
        <p class="mb-4">{{ $category->description }}</p>
    @endif

    <p class="text-sm text-gray-500 mb-2">
        {{ $category->posts->count() }} {{ Str::plural('post', $category->posts->count()) }}
    </p>

    @if($category->posts && $category->posts->count())
        <ul class="list-group mb-4">
            @foreach($category->posts as $post)
                <li class="list-group-item flex justify-between items-center">
                    <a href="{{ route('posts.show', [$category->slug, $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    @auth
                        <span class="flex space-x-2">
                            <a href="{{ route('posts.edit', [$category->slug, $post->slug]) }}"
                               class="bg-yellow-500 text-white px-2 py-1 rounded text-sm">
                               Edit
                            </a>
                            <a href="{{ route('posts.delete', [$category->slug, $post->slug]) }}"
                               class="bg-red-500 text-white px-2 py-1 rounded text-sm"
                               onclick="return confirm('Are you sure you want to delete this post?');">
                               Delete
                            </a>
                        </span>
                    @endauth
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">No posts in this category yet.</p>
    @endif

    @auth
        <a href="{{ route('posts.create', $category->slug) }}"
           class="bg-blue-500 text-white px-4 py-2 rounded">
           Create New Post
        </a>
    @endauth
</div>
@endsection
