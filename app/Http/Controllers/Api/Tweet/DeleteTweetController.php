<?php

namespace App\Http\Controllers\Api\Tweet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tweet;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DeleteTweetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Tweet $tweet): JsonResponse
    {
        // $user = $request->user();
        // $tweet = Tweet::findOrFail($id);

        // if (!$this->isTweetOwner($user, $tweet)) {
        //     return response()->json(['error' => 'Forbidden'], 403);
        // }

        Gate::authorize('delete', $tweet);

        $tweet->delete();

        return response()->json(['message' => 'Tweet deleted successfully'], 200);
    }

    /**
     * Check if the authenticated user is the owner of the tweet.
     */
    // private function isTweetOwner($user, $tweet): bool
    // {
    //     return $tweet->user_id === $user->id;
    // }
}
