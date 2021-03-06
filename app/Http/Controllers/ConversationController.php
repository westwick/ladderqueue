<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Events\ConversationsUpdated;
use App\Message;
use App\Participant;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $conversations = Auth::user()->conversations()->orderBy('updated_at', 'desc')->get();
        return view('messages.index')->with(compact('conversations'));
    }

    public function sendMessage()
    {
        $sender = Auth::user();
        $recipient = User::find(Input::get('to_user_id'));
        $message = Input::get('message');
        
        $newMsg = Message::send($sender, $recipient, $message);
        
        return response()->json(['success' => true, 'message' => $newMsg]);
    }

    public function sendMessageForm()
    {
        $sender = Auth::user();
        $recipient = User::find(Input::get('to_user_id'));
        $message = Input::get('message');

        $newMsg = Message::send($sender, $recipient, $message);
        flash('Message sent!', 'success');

        return redirect('/messages');
    }
    
    public function viewConversation($withUser)
    {
        $user = Auth::user();
        $user2 = User::where('name', $withUser)->firstOrFail();

        if($user->id === $user2->id) {
            return redirect('/messages');
        }

        $conversation = Conversation::findOrFail($user, $user2);

        // update last_read
        $p = Participant::where('conversation_id', $conversation->id)->where('user_id', $user->id)->first();
        $p->last_read = Carbon::now();
        $p->save();

        return view('messages.conversation')
            ->with('messages', $conversation->messages)
            ->with('convoid', $conversation->id)
            ->with('recipient', $user2);
    }
    
    public function getMessages()
    {
        $user = Auth::user();
        
        return response()->json(['messages' => $user->getMessages()]);
    }

    public function convoRead()
    {
        $user = Auth::user();
        $id = Input::get('id');
        $convo = Conversation::findByIdOrFail($id);
        foreach($convo->participants as $p) {
            if($p->user_id === $user->id) {
                $p->last_read = Carbon::now();
                $p->save();
            }
        }

        return response()->json(['success' => true]);
    }
}
