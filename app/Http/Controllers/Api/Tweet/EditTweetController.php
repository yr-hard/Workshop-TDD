<?php

namespace App\Http\Controllers\Api\Tweet;

use App\Http\Controllers\Controller;
use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EditTweetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Tweet $tweet)
    {
        // $validatedData = $request->validate([
        //     'content' => 'required|string|max:280',
        // ]);

        // $tweet = Tweet::findOrFail($id);

        // if ($tweet->user_id !== $request->user()->id) {
        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }

        // $tweet->update($validatedData);

        // return response()->json($tweet, 200);

        Gate::authorize('update', $tweet);

        $tweet->update(['content' => $request->content]);

        return new TweetResource($tweet);
    }
}
