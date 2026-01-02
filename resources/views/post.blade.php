@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>
    @if($post->subtitle)
        <h2 class="text-xl text-gray-600 mb-4">{{ $post->subtitle }}</h2>
    @endif

    <p class="text-sm text-gray-500 mb-4">
        Category:
        <a href="{{ route('category.show', $post->category->slug) }}">
            {{ $post->category->name }}
        </a>
    </p>

    <div class="prose mb-4">
        {!! $post->content !!}
    </div>

    @auth
        <div class="flex space-x-2">
            <a href="{{ route('posts.edit', [$post->category->slug, $post->slug]) }}"
               class="bg-yellow-500 text-white px-4 py-2 rounded">
               Edit Post
            </a>
            <a href="{{ route('posts.delete', [$post->category->slug, $post->slug]) }}"
               class="bg-red-500 text-white px-4 py-2 rounded"
               onclick="return confirm('Are you sure you want to delete this post?');">
               Delete Post
            </a>
        </div>
    @endauth
</div>
@endsection
