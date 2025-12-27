<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendeurMessagerieController extends Controller
{
    public function index(Request $request)
    {
        $vendeur = Auth::user();
        
        $conversations = Conversation::where('vendeur_id', $vendeur->id)
            ->with(['client', 'messages' => function($query) {
                $query->latest()->first();
            }])
            ->withCount(['messages_non_lus'])
            ->latest()
            ->get();

        // Si une conversation est spécifiée dans l'URL
        $conversation_active = null;
        if ($request->has('conversation')) {
            $conversation_active = Conversation::where('id', $request->conversation)
                ->where('vendeur_id', $vendeur->id)
                ->with(['client', 'messages.expediteur'])
                ->first();
        }
        // Sinon, prendre la plus récente
        elseif ($conversations->isNotEmpty()) {
            $conversation_active = $conversations->first();
            $conversation_active->load(['client', 'messages.expediteur']);
        }

        return view('vendeur.messagerie', compact('conversations', 'conversation_active'));
    }

    public function envoyer(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string'
        ]);

        $message = new Message([
            'conversation_id' => $request->conversation_id,
            'expediteur_id' => Auth::id(),
            'contenu' => $request->message
        ]);

        $message->save();

        return response()->json([
            'success' => true,
            'message' => $message->load('expediteur')
        ]);
    }

    public function marquerCommeLu(Request $request)
    {
        $request->validate([
            'message_id' => 'required|exists:messages,id'
        ]);

        $message = Message::find($request->message_id);
        $message->lu = true;
        $message->lu_at = now();
        $message->save();

        return response()->json(['success' => true]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'conversation_id' => 'required|exists:conversations,id'
        ]);

        $path = $request->file('file')->store('pieces-jointes', 'public');

        $message = new Message([
            'conversation_id' => $request->conversation_id,
            'expediteur_id' => Auth::id(),
            'piece_jointe' => $path
        ]);

        $message->save();

        return response()->json([
            'success' => true,
            'message' => $message->load('expediteur')
        ]);
    }
}