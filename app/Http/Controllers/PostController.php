<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->with(['user', 'drawer', 'reactedByLoggedUser'])->withCount(
            [
                'comments',
                'reactions as favors_count' => function (Builder $query)
                {
                    $query->where('type', 'favor');
                }, 'reactions as opposes_count' => function (Builder $query)
                {
                    $query->where('type', 'oppose');
                }
            ]
        )->get();
        return view('pages.posts.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd('hello');
        return view('pages.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load('user', 'drawer', 'reactedByLoggedUser')->loadCount([
            'comments',
            'reactions as favors_count' => function (Builder $query)
            {
                $query->where('type', 'favor');
            },
            'reactions as opposes_count' => function (Builder $query)
            {
                $query->where('type', 'oppose');
            }
        ]);
        return view('pages.posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
