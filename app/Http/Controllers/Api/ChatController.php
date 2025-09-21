<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;

class ChatController extends Controller
{
    public function listChats() {
        return Chat::orderBy('updated_at', 'desc')->get();
    }

    public function getMessages($id) {
        return Message::where('chat_id', $id)->orderBy('created_at')->get();
    }

    public function sendMessage(Request $request, $id) {
        $message = Message::create([
            'chat_id' => $id,
            'sender_type' => 'agent',
            'sender_id' => $request->user()->id,
            'message' => $request->message
        ]);
        return $message;
    }
}
