<div>
    <div class="chat-area" id="chatArea">
        <div class="chat-messages" id="chatMessages">
            @foreach($messages as $message)
                <div class="message-item {{ $message['from'] }}">
                    <div class="message-content">
                        <p class="mb-0">
                            {!! nl2br($message['content']) !!}
                        </p>
                    </div>
                </div>
            @endforeach

            <div id="typingIndicator" style="display: none;" class="typing-indicator">
                <span class="dot">.</span>
                <span class="dot">.</span>
                <span class="dot">.</span>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="sendMessage" class="chat-form">
        <div class="chat-input-area">
            <div class="input-group">
                <textarea
                    wire:model="message"
                    class="form-control message-input"
                    placeholder="Conte sobre o seu caso"
                    required
                ></textarea>

                <button type="submit"
                        class="btn send-btn ms-2"
                        title="Enviar mensagem"
                >
                    <i class="fas fa-paper-plane text-white"></i>
                </button>
            </div>
        </div>
    </form>

    @if (count($messages))
        <div class="chat-footer small mt-2">
            <a href="javascript:void(0)"
               title="Limpar a conversa"
               wire:click.prevent="resetChat"
               class="text-muted mb-0 text-decoration-none"
            >
                <small>
                    <i class="fas fa-history"></i>
                    Limpar a conversa
                </small>
            </a>
        </div>
    @endif
</div>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let chatMessages = document.querySelector('.chat-messages');

            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let chatMessages = document.querySelector('.chat-messages');

            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            const form = document.querySelector('.chat-form');
            if (form) {
                form.addEventListener('submit', function (e) {
                    const textarea = form.querySelector('.message-input');
                    const userMessage = textarea.value.trim();

                    if (userMessage) {
                        const messageItem = document.createElement('div');

                        messageItem.className = 'message-item user';
                        messageItem.innerHTML = `<div class="message-content"><p class="mb-0">${userMessage.replace(/\n/g, '<br>')}</p></div>`;
                        chatMessages.appendChild(messageItem);
                        chatMessages.scrollTop = chatMessages.scrollHeight;

                        textarea.value = '';
                        textarea.focus();
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();

                let form = document.querySelector('.chat-form');
                if (form) {
                    document.getElementById('typingIndicator').style.display = 'flex';

                    form.dispatchEvent(new Event('submit', { bubbles: true }));
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Livewire.on('newMessage', () => {
                const chatMessages = document.getElementById('chatMessages');

                if (chatMessages) {
                    document.getElementById('typingIndicator').style.display = 'none';

                    setTimeout(() => {
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }, 600);
                }
            });
        });
    </script>
@endsection
