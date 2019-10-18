<?php

namespace App\Http\Controllers;

use App\Events\NewChat;
use App\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function viewChats(Request $request)
    {
        $userId = (int)$request->get('user_id', 0);

        if (!$userId) return redirect()->route('join');

        $user = User::select('id', 'name', 'email', 'avatar')
            ->where('id', $userId)
            ->firstOrFail();

        $browserIdentity = $user->id . '-' . str_random(9);

        return view('chats', compact('user', 'browserIdentity'));
    }

    public function joinChat()
    {
        return view('join');
    }

    public function sendChat(Request $request)
    {
        $workspaceId = 1;

        $userId = (int)$request->get('author_id', 0);
        $authUser = User::select('id', 'name', 'email', 'avatar')
            ->where('id', $userId)
            ->firstOrFail();

        $browserIdentity = $request->get('browser_identity', '');
        $message = $request->get('message', '');
        $chatId = $request->get('chat_id', 'general');

        $msg = [
            'id' => $authUser->id . '-chat-' . time(),
            'message' => $message,
            'author' => $authUser
        ];

        $data = [
            'browser_identity' => $browserIdentity,
            'message' => $msg,
            'chat_id' => $chatId,
        ];

        $userIds = User::limit(200)->get()->pluck('id');

        broadcast(new NewChat([
            'workspace_id' => $workspaceId,
            'user_ids' => $userIds,
            'data' => $data
        ]));

        return response()->json($data);

    }
}
