<?php

namespace App\Http\Controllers\Api\Tweet;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateTweetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        
        $validatedData = $request->validate([
            'content' => 'string',
        ]);

        $tweet = Tweet::create([
            'user_id' => Auth::id(),
            'content' => $validatedData['content'],
        ]);

        return response()->json($tweet, 200);
    }
}
