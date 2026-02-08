<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class PageController extends Controller
{
    public function index()
    {
        $posts = Post::where('featured', false)
            ->with('user', 'categories')
            ->get();
        $categories = Category::take(10)->get();
        $featured = Post::where('featured', true)->take(3)->get();

        // dd($featured);
        return view('front.index', [
            'posts' => $posts,
            'featured' => $featured,
            'categories' => $categories,
        ]);
    }

    public function posts()
    {
        $posts = Post::paginate(20);
        $categories = Category::take(10)->get();
        $featured = Post::where('featured', true)->take(3)->get();

        return view('front.index',[
            'posts' => $posts,
            'featured' => $featured,
            'categories' => $categories,
        ]);
    }

    public function showPost(Post $post)
    {
        $post = $post->load('user', 'categories');
        $categories = Category::all();

        return view('front.posts.show', compact('post', 'categories'));
    }

    public function showCategory(Category $category)
    {
        $posts = $category->posts()->get();
        $categories = Category::paginate(20)->get();

        return view('front.categories.show', compact('category', 'posts', 'categories'));
    }
}
