<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Http\Request;

use function Laravel\Prompts\alert;

class ReactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        $reactableId = $request->input('reactable_id');
        $reactableType = $request->input('reactable_type');
        $type = $request->input('type');

        $reactable = $reactableType == 'App\Models\Post' ? Post::find($reactableId) : Comment::find($reactableId);
        $existingReaction = $reactable->reactions->where('user_id', $userId)->where('reactable_type', $reactableType)->first();

        if ($existingReaction)
        {
            if ($existingReaction->type == $type)
            {
                $existingReaction->delete();
                $type = 'other';
            }
            else
            {
                $existingReaction->type = $type;
                $existingReaction->save();
            }
        }
        else
        {
            Reaction::create([
                'user_id' => $userId,
                'reactable_id' => $reactableId,
                'reactable_type' => $reactableType,
                'type' => $type
            ]);
        }

        if ($reactable)
        {
            $favorCount = Reaction::where('reactable_id', $reactableId)
                ->where('reactable_type', $reactableType)
                ->where('type', 'favor')
                ->count();

            $opposeCount = Reaction::where('reactable_id', $reactableId)
                ->where('reactable_type', $reactableType)
                ->where('type', 'oppose')
                ->count();
            return response()->json([
                'reactionCount' => ($favorCount - $opposeCount),
                'type' => $type
            ]);
        }
        else
        {
            return response()->json([
                'reactionCount' => 0
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Reaction $reaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reaction $reaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reaction $reaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reaction $reaction)
    {
        //
    }
}
