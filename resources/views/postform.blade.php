@extends('layouts.app')

@section('beforecss')
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">
        {{ isset($post) ? 'Edit Post' : 'Create New Post' }}
    </h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-200 text-red-800 p-2 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($post)
        ? route('posts.update', [$post->category->slug, $post->slug])
        : route('posts.store', $category->slug) }}" method="POST">
        @csrf
        @if(isset($post))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="title" class="block font-semibold mb-1">Title</label>
            <input type="text" name="title" id="title"
                   class="border p-2 w-full"
                   value="{{ old('title', $post->title ?? '') }}" required>
        </div>

        <div class="mb-4">
            <label for="slug" class="block font-semibold mb-1">Slug</label>
            <input type="text" name="slug" id="slug"
                   class="border p-2 w-full"
                   value="{{ old('slug', $post->slug ?? '') }}" required>
        </div>

        <div class="mb-4">
            <label for="subtitle" class="block font-semibold mb-1">Subtitle</label>
            <input type="text" name="subtitle" id="subtitle"
                   class="border p-2 w-full"
                   value="{{ old('subtitle', $post->subtitle ?? '') }}">
        </div>

        <div class="mb-4">
            <label for="category_id" class="block font-semibold mb-1">Category</label>
            <select name="category_id" id="category_id" class="border p-2 w-full">
                <option value="">Select category</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}"
                        {{ old('category_id', $post->category_id ?? $category->id) == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
            <input type="text" name="new_category_name" placeholder="Or type new category"
                   class="border p-2 w-full mt-2"
                   value="{{ old('new_category_name') }}">
        </div>

        <div class="mb-4">
            <label for="content" class="block font-semibold mb-1">Content</label>
            <textarea name="content" id="content" rows="10"
                      class="border p-2 w-full summernote">{{ old('content', $post->content ?? '') }}</textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            {{ isset($post) ? 'Update Post' : 'Create Post' }}
        </button>
    </form>
</div>
@endsection

@section('afterjs')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300
        });
    });
</script>
@endsection
