<?php

namespace App\Http\Controllers\Api\Tweet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\Comment;
use App\Models\Comments;
use Illuminate\Support\Facades\Auth;

class CreateCommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $tweetId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $tweet = Tweet::findOrFail($tweetId);

        $comment = new Comments();
        $comment->user_id = Auth::id();
        $comment->tweet_id = $tweet->id;
        $comment->content = $request->input('content');
        $comment->save();

        return response()->json(['message' => 'Comment created successfully', 'comment' => $comment], 201);
    }
}
