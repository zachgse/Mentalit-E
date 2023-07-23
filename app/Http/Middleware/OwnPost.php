<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Forum;

class OwnPost
{

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        $forum = $request->forum;

        if ($forum == null) {
            abort (401); 
        }

        if ($user->id != $forum->user_id) {
            abort (401); 
        } 
        
        return $next($request);
    }
}
