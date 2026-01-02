<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{
    // Show posts in a category (public)
    public function index(Category $category)
    {
        $category->load('posts'); // eager load posts

        return view('category', compact('category'));
    }

    // Show form to create a new category
    public function create()
    {
        return view('categoryform');
    }

    // Store a new category
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string',
            'slug'        => 'required|string|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        Category::create($data);

        return redirect('/')
            ->with('success', 'Category created.');
    }

    // Delete a category safely
    public function destroy(Request $request, Category $category)
    {
        $postsCount = $category->posts()->count();

        if ($postsCount > 0) {
            // Rule #1: Reassign posts if requested
            if ($request->filled('reassign_to')) {
                $newCategoryId = $request->input('reassign_to');
                $newCategory = Category::find($newCategoryId);

                if (!$newCategory) {
                    return back()->withErrors('Selected category for reassignment does not exist.');
                }

                // Reassign posts
                Post::where('category_id', $category->id)
                    ->update(['category_id' => $newCategory->id]);

                // Then delete
                $category->delete();

                return redirect('/')
                    ->with('success', "Category deleted and posts reassigned to '{$newCategory->name}'.");
            }

            // Rule #2: Prevent deletion if no reassignment
            return back()->withErrors("Category '{$category->name}' cannot be deleted while it contains posts. Reassign them first.");
        }

        // No posts, safe to delete
        $category->delete();

        return redirect('/')
            ->with('success', "Category '{$category->name}' deleted successfully.");
    }
}
