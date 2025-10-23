<?php

namespace App\Http\Controllers\Vendeur;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageNotification;
use App\Events\MessageStatutNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MessagerieController extends Controller
{
    /**
     * Afficher la page de messagerie
     */
    public function index(Request $request)
    {
        // Récupérer les conversations triées
        $conversations = Conversation::where('vendeur_id', Auth::id())
            ->with([
                'client' => function($query) {
                    $query->select('id', 'nom', 'prenom', 'email', 'telephone', 'photo_profil', 'derniere_activite');
                },
                'dernier_message',
                'commandes' => function($query) {
                    $query->latest()->take(5);
                }
            ])
            ->withCount(['messages_non_lus' => function($query) {
                $query->where('expediteur_id', '!=', Auth::id())
                    ->where('lu', false);
            }])
            ->latest('updated_at')
            ->get()
            ->map(function($conversation) {
                $conversation->client->is_online = $conversation->client->derniere_activite >= now()->subMinutes(5);
                return $conversation;
            });

        // Conversation active
        $conversation_active = null;
        if ($request->has('conversation')) {
            $conversation_active = Conversation::where('vendeur_id', Auth::id())
                ->with([
                    'client' => function($query) {
                        $query->select('id', 'nom', 'prenom', 'email', 'telephone', 'photo_profil', 'derniere_activite');
                    },
                    'messages' => function($query) {
                        $query->with(['expediteur:id,nom,prenom,photo_profil', 'produit:id,nom,prix,image'])
                            ->orderBy('created_at', 'asc')
                            ->take(100);
                    },
                    'commandes' => function($query) {
                        $query->latest()->take(5);
                    }
                ])
                ->findOrFail($request->conversation);

            // Marquer les messages comme lus
            $conversation_active->messages()
                ->where('expediteur_id', '!=', Auth::id())
                ->where('lu', false)
                ->update([
                    'lu' => true,
                    'lu_at' => now()
                ]);

            // Vérifier si le client est en ligne
            $conversation_active->client->is_online = $conversation_active->client->derniere_activite >= now()->subMinutes(5);

            // Émettre l'événement de statut de lecture
            broadcast(new MessageStatutNotification($conversation_active->id, Auth::id()))->toOthers();
        }

        return view('vendeur.messagerie', compact('conversations', 'conversation_active'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string|max:1000',
            'produit_id' => 'nullable|exists:produits,id'
        ]);

        $conversation = Conversation::where('vendeur_id', Auth::id())
            ->findOrFail($request->conversation_id);

        $message = new Message([
            'conversation_id' => $conversation->id,
            'expediteur_id' => Auth::id(),
            'contenu' => $request->message,
            'produit_id' => $request->produit_id
        ]);

        $message->save();
        $conversation->touch();

        // Créer une notification pour le client
        $notification = $conversation->client->notifications()->create([
            'type' => 'nouveau_message',
            'data' => [
                'message_id' => $message->id,
                'conversation_id' => $conversation->id,
                'vendeur_nom' => Auth::user()->nom . ' ' . Auth::user()->prenom
            ]
        ]);

        // Broadcaster l'événement
        broadcast(new MessageNotification($message, $notification))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $message->load(['expediteur:id,nom,prenom,photo_profil', 'produit:id,nom,prix,image'])
        ]);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'file' => 'required|file|max:10240|mimes:jpeg,png,pdf,doc,docx'
        ]);

        $conversation = Conversation::where('vendeur_id', Auth::id())
            ->findOrFail($request->conversation_id);

        $file = $request->file('file');
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('conversations/' . $conversation->id, $filename, 'public');

        $message = new Message([
            'conversation_id' => $conversation->id,
            'expediteur_id' => Auth::id(),
            'contenu' => 'Fichier: ' . $file->getClientOriginalName(),
            'piece_jointe' => $path
        ]);

        $message->save();
        $conversation->touch();

        // Créer une notification
        $notification = $conversation->client->notifications()->create([
            'type' => 'nouveau_fichier',
            'data' => [
                'message_id' => $message->id,
                'conversation_id' => $conversation->id,
                'vendeur_nom' => Auth::user()->nom . ' ' . Auth::user()->prenom,
                'nom_fichier' => $file->getClientOriginalName()
            ]
        ]);

        broadcast(new MessageNotification($message, $notification))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $message->load('expediteur:id,nom,prenom,photo_profil')
        ]);
    }

    public function markAsRead(Request $request)
    {
        $request->validate([
            'message_id' => 'required|exists:messages,id'
        ]);

        $message = Message::where('conversation_id', function($query) {
            $query->select('id')
                ->from('conversations')
                ->where('vendeur_id', Auth::id());
        })->findOrFail($request->message_id);

        $message->update([
            'lu' => true,
            'lu_at' => now()
        ]);

        broadcast(new MessageStatutNotification($message->conversation_id, Auth::id()))->toOthers();

        return response()->json(['success' => true]);
    }

    public function resolveConversation(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id'
        ]);

        $conversation = Conversation::where('vendeur_id', Auth::id())
            ->findOrFail($request->conversation_id);

        $conversation->update([
            'status' => 'resolved',
            'resolved_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function blockUser(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id'
        ]);

        $client = User::findOrFail($request->client_id);
        
        // Bloquer l'utilisateur
        $client->update([
            'blocked_by_vendor' => Auth::id(),
            'blocked_at' => now()
        ]);

        // Fermer toutes les conversations actives
        Conversation::where('vendeur_id', Auth::id())
            ->where('client_id', $client->id)
            ->update([
                'status' => 'closed',
                'closed_at' => now()
            ]);

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $count = Message::whereHas('conversation', function($query) {
            $query->where('vendeur_id', Auth::id());
        })
        ->where('expediteur_id', '!=', Auth::id())
        ->where('lu', false)
        ->count();

        return response()->json(['count' => $count]);
    }
}