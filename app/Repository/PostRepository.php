<?php

namespace App\Repository;

use App\Models\Post;
use App\Models\Category;

class PostRepository
{
    /**
     * @var Post[]
     */
    private $posts = [];

    public function addPost(Post $post)
    {
        $this->posts[] = $post;
    }

    public function getAllPosts()
    {
        return $this->posts;
    }

    public function getPostsByCategory(Category $category)
    {
        return array_filter($this->posts, function (Post $post) use ($category) {
            // Use property access instead of getter
            return $post->category === $category->id;
        });
    }

    public function findPostBySlug(string $slug): ?Post
    {
        foreach ($this->posts as $post) {
            if ($post->slug === $slug) {
                return $post;
            }
        }
        return null;
    }
}
