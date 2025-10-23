<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Vendeur;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagerieController extends Controller
{
    /**
     * Afficher la page de messagerie du client
     */
    public function index()
    {
        $client = Auth::user();
        
        // Récupérer les conversations (groupées par vendeur)
        $conversations = Message::where('expediteur_id', $client->id)
            ->orWhere('destinataire_id', $client->id)
            ->orderBy('dateEnvoi', 'desc')
            ->get()
            ->groupBy(function($message) use ($client) {
                return $message->expediteur_id === $client->id 
                    ? $message->destinataire_id 
                    : $message->expediteur_id;
            });

        // Récupérer les notifications non lues
        $notifications = Notification::where('idUtilisateur', $client->id)
            ->where('lue', false)
            ->orderBy('dateNotif', 'desc')
            ->get();

        return view('client.messagerie.index', compact('conversations', 'notifications'));
    }

    /**
     * Afficher une conversation avec un vendeur
     */
    public function showConversation($vendeurId)
    {
        $client = Auth::user();
        $vendeur = Vendeur::findOrFail($vendeurId);

        // Récupérer tous les messages entre le client et le vendeur
        $messages = Message::where(function($query) use ($client, $vendeurId) {
            $query->where('expediteur_id', $client->id)
                  ->where('destinataire_id', $vendeurId);
        })->orWhere(function($query) use ($client, $vendeurId) {
            $query->where('expediteur_id', $vendeurId)
                  ->where('destinataire_id', $client->id);
        })->orderBy('dateEnvoi', 'asc')
          ->get();

        // Marquer les messages comme lus
        Message::where('destinataire_id', $client->id)
              ->where('expediteur_id', $vendeurId)
              ->where('lu', false)
              ->update(['lu' => true]);

        // Marquer la conversation comme active
        $activeConversation = $messages;

        return view('client.messagerie.index', compact('activeConversation', 'vendeur', 'conversations', 'notifications'));
    }

    /**
     * Envoyer un message à un vendeur
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'destinataire_id' => 'required|exists:vendeurs,id',
            'contenu' => 'required|string|max:1000'
        ]);

        $message = new Message();
        $message->expediteur_id = Auth::id();
        $message->destinataire_id = $request->destinataire_id;
        $message->contenu = $request->contenu;
        $message->lu = false;
        $message->save();

        // Créer une notification pour le vendeur
        $notification = new Notification();
        $notification->idUtilisateur = $request->destinataire_id;
        $notification->titre = "Nouveau message";
        $notification->contenu = "Vous avez reçu un nouveau message de " . Auth::user()->nom;
        $notification->lue = false;
        $notification->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => view('client.messagerie.partials.message', compact('message'))->render()
            ]);
        }

        return redirect()->back()->with('success', 'Message envoyé avec succès');
    }

    /**
     * Rechercher des vendeurs
     */
    public function searchVendeurs(Request $request)
    {
        $query = $request->input('q');
        
        $vendeurs = Vendeur::where('nom', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json($vendeurs);
    }

    /**
     * Vérifier le statut en ligne des vendeurs
     */
    public function checkOnlineStatus()
    {
        $client = Auth::user();
        
        // Récupérer les ID des vendeurs avec qui le client a des conversations
        $vendeurIds = Message::where('expediteur_id', $client->id)
            ->orWhere('destinataire_id', $client->id)
            ->get()
            ->map(function($message) use ($client) {
                return $message->expediteur_id === $client->id 
                    ? $message->destinataire_id 
                    : $message->expediteur_id;
            })
            ->unique();

        // Récupérer les vendeurs et leur statut en ligne
        $vendeurs = Vendeur::whereIn('id', $vendeurIds)
            ->select('id', 'derniereActivite')
            ->get()
            ->map(function($vendeur) {
                return [
                    'id' => $vendeur->id,
                    'online' => $vendeur->derniereActivite 
                        ? now()->diffInMinutes($vendeur->derniereActivite) < 5 
                        : false
                ];
            });

        return response()->json(['users' => $vendeurs]);
    }
}