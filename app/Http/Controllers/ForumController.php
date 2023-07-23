<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Forum;
use App\Models\ForumComment;
use App\Models\Warning;
use App\Models\Log;
use App\Models\Notification;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $forums = Forum::orderBy('dateTime', 'desc')->paginate(6);
        return view('forum.index', ['forums'=>$forums]);
    }

    public function search(Request $request) {
        $query = $request->input('query');
        $searched_items = Forum::where('forumSubject', 'like', "%$query%")->
        orWhere('forumComment', 'like', "%$query%")->get();
        return view('/forum/search', ['searched_items'=>$searched_items]);
    }

    public function searchCategory(Request $request) {
        $query = $request->input('query');
        $searched_items = Forum::where('forumCategory', 'like', "%$query%")->get();
        return view('/forum/search', ['searched_items'=>$searched_items]);
    }

    public function create() {
        return view('forum.create');
    }

    public function store(Request $request) {
        $user = auth()->user();

        request()->validate([
            'forumSubject' => ['required', 'string', 'min:5', 'max:50'],
            'forumCategory' => 'required',
            'forumComment' => ['required', 'string', 'min:10', 'max:255'],
        ]);

        Forum::create([
            'forumSubject' => request('forumSubject'),
            'forumCategory' => request('forumCategory'),
            'forumComment' => request('forumComment'),
            'dateTime' => now(),
            'user_id' => $user->id,
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'User', 
            'description' => $user->email . ' has posted a discussion in the forum ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'You posted a discussion in the forum',
            'notifDateTime' => now(),
        ]);

        return redirect('/forum')->with('message', 'Your post has been added');

    }


    public function show(Forum $forum){
        $user = auth()->user();
        $comments = ForumComment::where('forum_id', $forum->id)->orderBy('dateTime', 'desc')->get();
        return view ('forum.show', ['forum'=>$forum, 'user'=>$user, 'comments'=>$comments]);
    }

    public function edit(Forum $forum) {
        return view('forum.edit', ['forum' => $forum]);
    }

    public function update(Request $request, Forum $forum){
        $user = auth()->user();

        request()->validate([
            'forumSubject' => ['required', 'string', 'min:5', 'max:50'],
            'forumComment' => ['required', 'string', 'min:10', 'max:255'],
        ]);

        $forum->update([
            'forumSubject' => request('forumSubject'),
            'forumComment' => request('forumComment'),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'User', 
            'description' => $user->email . ' has updated a discussion in the forum ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'You updated a discussion in the forum',
            'notifDateTime' => now(),
        ]);

        return redirect('/forum')->with('message', 'Your post has been updated');
    }

    public function destroy(Forum $forum) {

        $user = User::where('id', $forum->user_id)->get()->first();

        Log::create([
            'user_id' => $forum->user_id,
            'type' => 'User', 
            'description' => $user->email . ' has deleted a discussion in the forum ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $forum->user_id,
            'notifDescription' => 'You deleted a discussion in the forum',
            'notifDateTime' => now(),
        ]);

        $forum->delete();

        return redirect('/forum')->with('message', 'Your post has been deleted');
    }

    public function store_comment(Request $request, $forum) {
        $user = auth()->user();
        $var = Forum::find($forum);
        
        request()->validate([
            'forumCommentContent' => ['required', 'string', 'min:5', 'max:255'],
        ]);

        ForumComment::create([
            'forumCommentContent' => request('forumCommentContent'),
            'user_id' => $user->id,
            'forum_id' => $forum,
            'dateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'User', 
            'description' => $user->email . ' has posted a comment in the forum ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'You commented on a discussion in the forum',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $var->user_id,
            'notifDescription' => 'Someone commented on your post',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'Your comment has been posted');
    }

    public function create_forum_warning(Forum $forum) {
        return view ('/forum/warningForum', ['forum'=>$forum]);
    }

    public function forum_warning(Request $request, $forum) {
        $user = auth()->user();

        $var = Forum::find($forum);

        request()->validate([
            'description' => 'required',
        ]);

        Warning::create([
            'user_id' => $user->id,
            'forum_id' => $var->id,
            'category' => 'Forum Post',
            'description' => request('description'),
            'dateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'User', 
            'description' => $user->email . ' has reported a discussion in the forum ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'You report a discussion on the forum',
            'notifDateTime' => now(),
        ]);


        return redirect('/forum')->with('message', 'Your report has been submitted');
    }

    public function create_forumComment_warning(ForumComment $comment) {
        return view ('/forum/warningForumComment', ['comment'=>$comment]);
    }

    public function forumComment_warning(Request $request, $comment) {
        $user = auth()->user();

        $var = ForumComment::find($comment);

        request()->validate([
            'description' => 'required',
        ]);

        Warning::create([
            'user_id' => $user->id,
            'forum_comment_id' => $var->id,
            'category' => 'Forum Comment',
            'description' => request('description'),
            'dateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'User', 
            'description' => $user->email . ' has reported a comment in the forum ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'You report a comment in the forum',
            'notifDateTime' => now(),
        ]);

        return redirect('/forum')->with('message', 'Your report has been submitted');
    }

 
}
