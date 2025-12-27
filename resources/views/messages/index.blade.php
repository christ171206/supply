@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Liste des utilisateurs -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Utilisateurs</div>
                <div class="card-body">
                    <ul class="list-group" id="users-list">
                        @foreach($users as $user)
                            <li class="list-group-item user-item" data-user-id="{{ $user->id }}">
                                {{ $user->name }}
                                <span class="badge bg-primary float-end d-none message-counter">0</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Zone de chat -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Chat avec <span id="selected-user">...</span></div>
                <div class="card-body">
                    <div id="messages" class="messages-container mb-4" style="height: 400px; overflow-y: auto;">
                        <!-- Les messages seront chargés ici dynamiquement -->
                    </div>
                    <form id="message-form" class="d-none">
                        <div class="input-group">
                            <input type="text" id="message-input" class="form-control" placeholder="Écrivez votre message...">
                            <button class="btn btn-primary" type="submit">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let selectedUserId = null;
    
    // Écouter les nouveaux messages
    window.Echo.private(`chat.${authUserId}`)
        .listen('MessageSent', (e) => {
            if (selectedUserId === e.message.from_user) {
                appendMessage(e.message);
            } else {
                incrementMessageCounter(e.message.from_user);
            }
        });

    // Charger les messages lors du clic sur un utilisateur
    $('.user-item').click(function() {
        selectedUserId = $(this).data('user-id');
        $('#selected-user').text($(this).text().trim());
        $('#message-form').removeClass('d-none');
        $(this).find('.message-counter').text('0').addClass('d-none');
        loadMessages(selectedUserId);
    });

    // Envoyer un message
    $('#message-form').submit(function(e) {
        e.preventDefault();
        let content = $('#message-input').val();
        if (content.trim() === '') return;

        $.ajax({
            url: '/messages/send',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                to_user: selectedUserId,
                content: content
            },
            success: function(response) {
                appendMessage(response.message);
                $('#message-input').val('');
            }
        });
    });

    function loadMessages(userId) {
        $('#messages').empty();
        $.get(`/messages/${userId}`, function(response) {
            response.messages.forEach(appendMessage);
            scrollToBottom();
        });
    }

    function appendMessage(message) {
        let isOwn = message.from_user === authUserId;
        let html = `
            <div class="message ${isOwn ? 'own-message text-end' : 'other-message'}">
                <div class="message-bubble ${isOwn ? 'bg-primary text-white' : 'bg-light'} d-inline-block p-2 rounded mb-2">
                    ${message.content}
                </div>
            </div>
        `;
        $('#messages').append(html);
        scrollToBottom();
    }

    function scrollToBottom() {
        let container = $('#messages');
        container.scrollTop(container[0].scrollHeight);
    }

    function incrementMessageCounter(fromUserId) {
        let counter = $(`.user-item[data-user-id="${fromUserId}"] .message-counter`);
        let count = parseInt(counter.text() || '0');
        counter.text(count + 1).removeClass('d-none');
    }
</script>
@endpush

@push('styles')
<style>
    .messages-container {
        padding: 1rem;
    }
    .message {
        margin-bottom: 1rem;
    }
    .message-bubble {
        max-width: 70%;
        word-wrap: break-word;
    }
    .own-message .message-bubble {
        margin-left: auto;
    }
    .user-item {
        cursor: pointer;
    }
    .user-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush
@endsection