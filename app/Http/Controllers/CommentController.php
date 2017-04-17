<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Auth;
use App\User;
use Illuminate\Support\Facades\Input;

class CommentController extends Controller
{
    public function test()
    {
        $user = Auth::user();
        $parent = Comment::find(4);
        $comment = $parent->children()->create(['content' => 'childcomment', 'user_id' => 2]);
    }
    
    public function reply()
    {
        
    }

    public function showForum()
    {
        $comments = Comment::with('author')->where('parent_id', NULL)->get();
        return view('community.forum')->with(compact('comments'));
    }

    public function showPost($id)
    {
        $parent = Comment::findOrFail($id);
        $comments = $parent->children()->get();
        return view('community.post')->with(compact('parent', 'comments'));
    }

    public function postComment()
    {
        $user = Auth::user();
        $parent = Comment::findOrFail(Input::get('parent_id'));
        $comment = $parent->children()->create(['content' => Input::get('content'), 'user_id' => $user->id]);
        $root = $parent->getRoot();

        return redirect('/forum/post/' . $root->id);
    }
}
