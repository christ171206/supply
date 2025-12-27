@php
    $currentUser = Auth::user();
@endphp

<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <img src="{{ $otherUser->photoProfil ?? asset('images/default-avatar.png') }}" 
                     class="rounded-circle" 
                     width="40" 
                     height="40" 
                     alt="{{ $otherUser->nom }}">
            </div>
            <div class="flex-grow-1 ms-3">
                <h5 class="card-title mb-0">{{ $otherUser->nom }}</h5>
                <small class="text-muted">
                    {{ $otherUser->role === 'vendeur' ? 'Vendeur' : 'Client' }}
                </small>
            </div>
        </div>
    </div>
    <div class="card-body conversation-messages p-4" style="height: 500px; overflow-y: auto;">
        @foreach($messages as $message)
            <div class="message rounded p-3 {{ $message->expediteur_id === $currentUser->id ? 'sent' : 'received' }}">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted">
                        {{ $message->expediteur_id === $currentUser->id ? 'Vous' : $message->expediteur->nom }}
                    </small>
                    <small class="text-muted">
                        {{ $message->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
                <div class="message-content">
                    {{ $message->contenu }}
                </div>
                @if($message->expediteur_id === $currentUser->id)
                    <div class="text-end mt-1">
                        <small class="text-muted">
                            @if($message->lu)
                                <i class="fas fa-check-double"></i> Lu
                            @else
                                <i class="fas fa-check"></i> Envoyé
                            @endif
                        </small>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    <div class="card-footer">
        <form action="{{ route('vendeur.messagerie.send') }}" method="POST" class="message-form">
            @csrf
            <input type="hidden" name="destinataire_id" value="{{ $otherUser->id }}">
            <div class="input-group">
                <input type="text" 
                       class="form-control" 
                       name="contenu" 
                       placeholder="Écrivez votre message..." 
                       required
                       autofocus>
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const conversationDiv = document.querySelector('.conversation-messages');
    conversationDiv.scrollTop = conversationDiv.scrollHeight;

    const messageForm = document.querySelector('.message-form');
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                const messagesDiv = document.querySelector('.conversation-messages');
                messagesDiv.insertAdjacentHTML('beforeend', data.message);
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
                this.reset();
            }
        });
    });
});
</script>
@endpush