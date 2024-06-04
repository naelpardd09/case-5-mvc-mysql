<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
        ]);

        // Save the message in the database
        $message = new Message();
        $message->sender_id = Auth::id();
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;
        $message->created_at = now();
        $message->save();

        // Get sender and receiver details
        $sender = Auth::user();
        $receiver = User::find($request->receiver_id);

        // Prepare the log content
        $logContent = "WAKTU    : " . now() . "\n" .
            "PENGIRIM : " . $sender->first_name . " " . $sender->last_name . "\n" .
            "PENERIMA : " . $receiver->first_name . " " . $receiver->last_name . "\n" .
            "PESAN    : " . $request->message . "\n\n";

        // Save the log content to chat.txt
        Storage::append('chat.txt', $logContent);

        return response()->json(['status' => 'Message sent successfully']);
    }

    public function getMessages(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        $user = Auth::user();
        $receiver = User::find($request->receiver_id);

        $messages = Message::where(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $receiver->id);
        })->orWhere(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $receiver->id)
                ->where('receiver_id', $user->id);
        })->orderBy('created_at', 'asc')->get();

        return view('partials.messages', ['messages' => $messages]);
    }
}
