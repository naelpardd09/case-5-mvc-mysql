<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class HomeController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $users = User::where('id', '!=', $user->id)->get();

        return view('home', ['user' => $user, 'users' => $users]);
    }

    public function chat($id)
    {
        $user = Auth::user();
        $receiver = User::find($id);
        $messages = Message::where(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $receiver->id);
        })->orWhere(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $receiver->id)
                ->where('receiver_id', $user->id);
        })->orderBy('created_at', 'asc')->get();

        return view('chat', ['user' => $user, 'receiver' => $receiver, 'messages' => $messages]);
    }

    public function searchUsers(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $users = User::where('first_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
            ->where('id', '!=', Auth::id())
            ->get();

        return view('partials.user-list', ['users' => $users]);
    }

    public function getUsers()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('partials.user-list', ['users' => $users]);
    }
}
