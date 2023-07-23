<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ForumComment;

class Report2
{

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        $comment = $request->comment;

        if ($comment == null) {
            abort (401); 
        }

        if ($user->id == $comment->user_id) {
            abort (401); 
        } 
        
        return $next($request);
    }
}
