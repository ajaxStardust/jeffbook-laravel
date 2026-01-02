<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    // Show a single post
    public function show(Category $category, $postslug)
    {
        // Ensure post is in this category
        $post = Post::where("slug", $postslug)
            ->where("category_id", $category->id)
            ->firstOrFail();

        return view("post", compact("post", "category"));
    }

    // Show form to edit existing post
    public function edit(Category $category, $postslug)
    {
        $post = Post::where("slug", $postslug)
            ->where("category_id", $category->id)
            ->firstOrFail();

        $categories = Category::all();

        return view("postform", compact("post", "categories", "category"));
    }

    // List all posts (optional)
    public function index()
    {
        $posts = Post::all();
        return view("posts.index", compact("posts"));
    }

    // Show form to create new post
    public function create(Category $category)
    {
        $categories = Category::all();
        return view("postform", compact("categories", "category"));
    }

    // Delete a post
    public function destroy(Category $category, $postslug)
    {
        $post = Post::where("slug", $postslug)
            ->where("category_id", $category->id)
            ->firstOrFail();
        $post->delete();

        return redirect()->route("home")->with("success", "Post deleted.");
    }

    // INSERT:
    //
    //
    public function store(Request $request, Category $category)
    {
        $data = $request->validate([
            "title" => "required|string",
            "slug" => "required|string|unique:posts,slug",
            "subtitle" => "nullable|string",
            "content" => "nullable|string",
            "category_id" => "nullable|exists:categories,id",
            "new_category_name" => "nullable|string",
        ]);

        // Handle new category creation
        if (empty($data["category_id"]) && !empty($data["new_category_name"])) {
            $newCategory = Category::create([
                "name" => $data["new_category_name"],
                "slug" => \Str::slug($data["new_category_name"]),
            ]);
            $data["category_id"] = $newCategory->id;
        }

        $post = new Post();
        $post->title = $data["title"];
        $post->slug = $data["slug"];
        $post->subtitle = $data["subtitle"] ?? "";
        $post->content = $data["content"] ?? "";
        $post->category_id = $data["category_id"] ?? $category->id;
        $post->save();

        return redirect()
            ->route("posts.show", [$post->category->slug, $post->slug])
            ->with("success", "Post created successfully!");
    }

    public function update(Request $request, Category $category, $postslug)
    {
        // Find the post by slug and original category
        $post = Post::where("slug", $postslug)
            ->where("category_id", $category->id)
            ->firstOrFail();

        // Validate incoming request
        $data = $request->validate([
            "title" => "required|string",
            "slug" => "required|string|unique:posts,slug," . $post->id,
            "subtitle" => "nullable|string",
            "content" => "nullable|string",
            "category_id" => "required|exists:categories,id",
        ]);

        // Update all fields, including category_id
        $post->update([
            "title" => $request->input("title"),
            "slug" => $request->input("slug"),
            "subtitle" => $request->input("subtitle", ""),
            "content" => $request->input("content", ""),
            "category_id" => $request->input("category_id"), // <--- this is key
        ]);

        return redirect()
            ->route("posts.show", [$post->category->slug, $post->slug])
            ->with("success", "Post updated successfully!");
    }
}
