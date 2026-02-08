<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('authResource:post')->except('index', 'create', 'store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View|\Illuminate\View\View
     */
    public function index()
    {
        //
        $posts = auth()->user()->posts ?: [];

        return view('back.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View|\Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all();
        return view('back.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        // dd($request);
        if ($request->has('image')) {
            $this->uploadImage($request);
        }
        $request->user()->posts()->create($request->post());
        $request->user()->categories()->attach($request->category_id);

        return redirect()->route('posts.index')->with('message', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return Factory|\Illuminate\View\View|View
     */
    public function show(Post $post)
    {
        //
        return view('back.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return Factory|View|\Illuminate\View\View
     */
    public function edit(Post $post)
    {
        if (Gate::denies('update', $post)) {
            abort(403);
        }
        return view('back.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function update(Request $request, Post $post)
    {
        // the update method, only fire its events when the update happens directly on the model,
        // so we will use save directly on modal instead of mass assignment
        if ($request->has('image')) {
            $oldImage = $post->image;
            $this->uploadImage($request);
            if (file_exists(public_path('images/'.$oldImage))) {
                unlink(public_path('images/'.$oldImage));
            }
            $post->image = $request->post()['image'];
        }
        $post->title = $request->title;
        $post->excerpt = $request->excerpt;
        $post->body = $request->body;
        $post->save();

        return back()->with('message', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return back();
    }

    public function uploadImage($request)
    {
        $image = $request->file('image');
        $imageName = time().$image->getClientOriginalName();
        // add the new file
        $image->move(public_path('images'), $imageName);
        $request->merge(['image' => $imageName]);
        // dd($request);
    }
}
