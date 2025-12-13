<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index(): View
    {
        $posts = Post::query()
            ->with(['author', 'category'])
            ->latest()
            ->paginate(9);

        return view('posts.index', compact('posts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        $post->load(['author', 'category', 'comments.author', 'comments.post']);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create(): View
    {
        $this->authorize('create', Post::class);

        $categories = Category::orderBy('name')->get();

        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['user_id'] = $request->user()->id;
        $data['feature_image'] = $data['feature_image']
            ?? sprintf('https://picsum.photos/seed/%s/800/400', Str::uuid());

        $post = Post::create($data);

        return redirect()
            ->route('posts.show', $post)
            ->with('status', 'Post created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('status', 'Post deleted.');
    }
}

