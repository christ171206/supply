<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagerieController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with([
                'vendeur' => function($query) {
                    $query->select('id', 'nom', 'prenom', 'photo_profil', 'derniere_activite', 'boutique_nom');
                },
                'lastMessage' => function($query) {
                    $query->with('expediteur:id,nom,prenom');
                }
            ])
            ->where('client_id', Auth::id())
            ->latest('updated_at')
            ->get()
            ->map(function($conversation) {
                $conversation->vendeur->is_online = $conversation->vendeur->derniere_activite >= now()->subMinutes(5);
                return $conversation;
            });

        $activeConversation = null;
        if (request()->has('conversation')) {
            $activeConversation = Conversation::with([
                'vendeur' => function($query) {
                    $query->select('id', 'nom', 'prenom', 'photo_profil', 'derniere_activite', 'boutique_nom');
                },
                'messages' => function($query) {
                    $query->with('expediteur:id,nom,prenom,photo_profil')
                          ->latest()
                          ->limit(50);
                }
            ])
            ->where('client_id', Auth::id())
            ->findOrFail(request()->conversation);

            // Marquer tous les messages non lus comme lus
            $activeConversation->messages()
                ->where('expediteur_id', '!=', Auth::id())
                ->where('lu', false)
                ->update(['lu' => true]);

            // Vérifier si le vendeur est en ligne
            $activeConversation->vendeur->is_online = $activeConversation->vendeur->derniere_activite >= now()->subMinutes(5);
        }

        // Obtenir la liste des vendeurs pour nouvelle conversation
        $vendeurs = User::where('role', 'vendeur')
                       ->select('id', 'nom', 'prenom', 'photo_profil', 'boutique_nom')
                       ->get();

        return view('client.messagerie.index', compact('conversations', 'activeConversation', 'vendeurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'contenu' => 'required|string|max:1000',
        ]);

        $conversation = Conversation::where('client_id', Auth::id())
            ->findOrFail($request->conversation_id);

        $message = new Message([
            'contenu' => $request->contenu,
            'expediteur_id' => Auth::id(),
            'conversation_id' => $conversation->id,
        ]);

        $message->save();

        $conversation->touch();

        // Broadcaster l'événement en temps réel
        broadcast(new \App\Events\NouveauMessage($message))->toOthers();

        return response()->json([
            'message' => $message->load('expediteur'),
            'timestamp' => $message->created_at->format('H:i'),
        ]);
    }

    public function marquerCommeLu(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
        ]);

        $conversation = Conversation::where('client_id', Auth::id())
            ->findOrFail($request->conversation_id);

        Message::where('conversation_id', $conversation->id)
            ->where('expediteur_id', '!=', Auth::id())
            ->update(['lu' => true]);

        return response()->json(['success' => true]);
    }

    public function nouvelleConversation(Request $request)
    {
        $request->validate([
            'vendeur_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $vendeur = User::findOrFail($request->vendeur_id);

        $conversation = Conversation::firstOrCreate([
            'client_id' => Auth::id(),
            'vendeur_id' => $vendeur->id,
        ]);

        $message = new Message([
            'contenu' => $request->message,
            'expediteur_id' => Auth::id(),
            'conversation_id' => $conversation->id,
        ]);

        $message->save();

        return redirect()->route('client.messages', ['conversation' => $conversation->id])
            ->with('success', 'Message envoyé avec succès');
    }
}