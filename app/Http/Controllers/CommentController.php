<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        $comments = $post->comments->load('user', 'post', 'comments', 'reactedByLoggedUser')->loadCount([
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
        $scripts = [];
        foreach ($comments as $reply)
        {
            $script = view('partials.load_replies_script', ['comment' => $reply])->render();
            $scripts[] = $script;
        }
        $view = view('partials.comments', ['post' => $post, 'comments' => $comments])->render();
        return response()->json([
            'view' => $view,
            'scripts' => $scripts
        ]);
    }

    public function replies(Comment $comment)
    {
        $replies = $comment->comments->load('user', 'post', 'comments', 'reactedByLoggedUser')->loadCount([
            'comments',
            'reactions as favors_count' => function (Builder $query)
            {
                $query->where('type', 'favor');
            },
            'reactions as opposes_count' => function (Builder $query)
            {
                // $query->where('type', 'oppose');
            }
        ]);
        $scripts = [];
        foreach ($replies as $reply)
        {
            $script = view('partials.load_replies_script', ['comment' => $reply])->render();
            $scripts[] = $script;
        }
        $view = view('partials.comments', ['comments' => $replies])->render();
        return response()->json([
            'view' => $view,
            'scripts' => $scripts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = auth()->id();

        $request->validate([
            'content' => 'required|string'
        ]);

        $comment = Comment::create([
            'content' => $request->input('content'),
            'user_id' => $userId,
            'post_id' => $request->input('post_id'),
            'parent_id' => $request->input('parent_id')
        ]);
        $view = view('partials.comment', ['comment' => $comment])->render();
        return response()->json(['comment' => $comment, 'view' => $view]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
