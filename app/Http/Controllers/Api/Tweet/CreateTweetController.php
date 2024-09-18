<?php

namespace App\Http\Controllers\Api\Tweet;

use App\Http\Controllers\Controller;
use App\Http\Resources\TweetResource;
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
            'content' => 'required|string',
        ]);

        $file = null;

        if($request->hasFile('photo')) {
            $file = $request->file('photo')->store('tweets', 'public');
        }

        $tweet = Tweet::create([
            'user_id' => Auth::id(),
            'content' => $validatedData['content'],
            'photo' => $file,
        ]);

        return TweetResource::make($tweet);
    }
}
