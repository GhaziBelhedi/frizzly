@extends('layouts.enseignant')
@section('title', 'Assistant IA')
@section('page-title', 'Assistant IA')
@section('page-sub', 'Posez vos questions pédagogiques')

@section('content')

<div style="height:calc(100vh - 108px);display:flex;flex-direction:column;background:#fff;border-radius:18px;border:1px solid #f1f5f9;box-shadow:0 1px 3px rgba(0,0,0,0.04);overflow:hidden;">

    {{-- Header --}}
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:12px;flex-shrink:0;">
        <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#8E6CFF,#E94E3C);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 2px 8px rgba(142,108,255,0.3);">
            <i class="bi bi-robot" style="color:#fff;font-size:1.1rem;"></i>
        </div>
        <div style="flex:1;">
            <p style="font-weight:700;color:#0f172a;font-size:0.9rem;line-height:1.2;">Assistant Pédagogique IA</p>
            <p style="font-size:0.72rem;color:#94a3b8;margin:0;">Propulsé par Gemini · Spécialisé en enseignement</p>
        </div>
        <button onclick="clearChat()"
                style="padding:6px 12px;border-radius:8px;background:#f8fafc;border:1px solid #e2e8f0;font-size:0.75rem;font-weight:600;color:#64748b;cursor:pointer;transition:all 0.15s;"
                onmouseover="this.style.background='#fee2e2';this.style.color='#E94E3C';this.style.borderColor='#fca5a5'"
                onmouseout="this.style.background='#f8fafc';this.style.color='#64748b';this.style.borderColor='#e2e8f0'">
            <i class="bi bi-trash3"></i> Effacer
        </button>
    </div>

    {{-- Messages --}}
    <div id="chat-box" style="flex:1;overflow-y:auto;padding:20px;display:flex;flex-direction:column;gap:16px;background:#f8fafc;">

        {{-- Welcome message --}}
        <div id="welcome" style="display:flex;flex-direction:column;align-items:flex-start;gap:3px;">
            <span style="font-size:0.7rem;font-weight:600;color:#8E6CFF;padding:0 4px;">Assistant IA</span>
            <div style="max-width:75%;padding:12px 16px;border-radius:16px 16px 16px 4px;background:#fff;border:1px solid #f1f5f9;box-shadow:0 1px 3px rgba(0,0,0,0.04);font-size:0.855rem;line-height:1.6;color:#1e293b;">
                👋 Bonjour ! Je suis votre assistant pédagogique. Je peux vous aider sur :<br><br>
                <span style="display:flex;flex-direction:column;gap:4px;">
                    <span>📚 Méthodes et stratégies d'enseignement</span>
                    <span>🎯 Gestion de classe et motivation des élèves</span>
                    <span>📊 Évaluation et suivi des apprentissages</span>
                    <span>🤝 Relation enseignant-élève et parents</span>
                    <span>💡 Activités pédagogiques innovantes</span>
                </span><br>
                Comment puis-je vous aider aujourd'hui ?
            </div>
        </div>

    </div>

    {{-- Suggestions --}}
    <div id="suggestions" style="padding:10px 20px;border-top:1px solid #f1f5f9;display:flex;gap:8px;flex-wrap:wrap;background:#fff;flex-shrink:0;">
        @foreach([
            'C\'est quoi le Frizzly Kit ?',
            'Comment commander un kit ?',
            'Comment motiver des élèves démotivés ?',
            'Gérer une classe difficile',
        ] as $q)
        <button onclick="sendSuggestion(this.textContent)"
                style="padding:6px 12px;border-radius:20px;border:1.5px solid #ede9fe;background:#faf8ff;font-size:0.75rem;font-weight:500;color:#8E6CFF;cursor:pointer;transition:all 0.15s;white-space:nowrap;"
                onmouseover="this.style.background='#ede9fe';this.style.borderColor='#8E6CFF'"
                onmouseout="this.style.background='#faf8ff';this.style.borderColor='#ede9fe'">
            {{ $q }}
        </button>
        @endforeach
    </div>

    {{-- Input --}}
    <div style="padding:12px 16px;border-top:1px solid #f1f5f9;background:#fff;flex-shrink:0;">
        <div style="display:flex;align-items:flex-end;gap:10px;">
            <textarea id="user-input" rows="1"
                      placeholder="Posez votre question pédagogique… (Entrée pour envoyer)"
                      style="flex:1;border:1.5px solid #e2e8f0;border-radius:12px;padding:10px 14px;font-size:0.855rem;font-family:'Poppins',sans-serif;resize:none;outline:none;line-height:1.5;max-height:120px;overflow-y:auto;transition:border-color 0.18s;background:#f8fafc;"
                      onfocus="this.style.borderColor='#8E6CFF';this.style.background='#fff'"
                      onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'"></textarea>
            <button id="send-btn" onclick="sendMessage()"
                    style="width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#8E6CFF,#E94E3C);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff;transition:transform 0.15s,box-shadow 0.15s;box-shadow:0 2px 8px rgba(142,108,255,0.35);"
                    onmouseover="this.style.transform='scale(1.07)'"
                    onmouseout="this.style.transform='scale(1)'">
                <i class="bi bi-send-fill" style="font-size:0.85rem;"></i>
            </button>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
var chatHistory = [];
var chatBox = document.getElementById('chat-box');
var input = document.getElementById('user-input');
var sendBtn = document.getElementById('send-btn');
var csrfToken = '{{ csrf_token() }}';

function scrollBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}

function renderMarkdown(text) {

    if (!text) return '';

    return marked.parse(text, {
        breaks: true,
        gfm: true
    });
}

function appendBubble(role, text, animate = true) {

    var mine = (role === 'user');

    var wrap = document.createElement('div');

    wrap.style.cssText = `
        display:flex;
        flex-direction:column;
        align-items:${mine ? 'flex-end' : 'flex-start'};
        gap:3px;
        width:100%;
    `;

    if (animate) {
        wrap.style.opacity = '0';
        wrap.style.transform = 'translateY(8px)';
    }

    // Label assistant
    if (!mine) {

        var lbl = document.createElement('span');

        lbl.textContent = 'Assistant IA';

        lbl.style.cssText = `
            font-size:0.7rem;
            font-weight:600;
            color:#8E6CFF;
            padding:0 4px;
        `;

        wrap.appendChild(lbl);
    }

    // Bubble
    var bubble = document.createElement('div');

    bubble.style.cssText = `
        max-width:75%;
        padding:12px 16px;
        border-radius:${mine ? '16px 16px 4px 16px' : '16px 16px 16px 4px'};
        font-size:0.855rem;
        line-height:1.7;
        word-break:break-word;
        overflow-wrap:anywhere;
        white-space:normal;
        ${mine
            ? `
                background:linear-gradient(135deg,#8E6CFF,#E94E3C);
                color:#fff;
            `
            : `
                background:#fff;
                color:#1e293b;
                border:1px solid #f1f5f9;
                box-shadow:0 1px 3px rgba(0,0,0,0.05);
            `
        }
    `;

    if (mine) {
        bubble.innerHTML = text.replace(/\n/g, '<br>');
    } else {
        bubble.innerHTML = renderMarkdown(text);
    }

    wrap.appendChild(bubble);

    chatBox.appendChild(wrap);

    scrollBottom();

    if (animate) {

        requestAnimationFrame(() => {

            wrap.style.transition = 'all 0.25s ease';

            wrap.style.opacity = '1';

            wrap.style.transform = 'translateY(0)';
        });
    }

    return bubble;
}

function appendTyping() {

    var wrap = document.createElement('div');

    wrap.id = 'typing-indicator';

    wrap.style.cssText = `
        display:flex;
        flex-direction:column;
        align-items:flex-start;
        gap:3px;
    `;

    var lbl = document.createElement('span');

    lbl.textContent = 'Assistant IA';

    lbl.style.cssText = `
        font-size:0.7rem;
        font-weight:600;
        color:#8E6CFF;
        padding:0 4px;
    `;

    wrap.appendChild(lbl);

    var bubble = document.createElement('div');

    bubble.style.cssText = `
        padding:12px 16px;
        border-radius:16px 16px 16px 4px;
        background:#fff;
        border:1px solid #f1f5f9;
        display:flex;
        gap:5px;
        align-items:center;
    `;

    bubble.innerHTML = `
        <span class="typing-dot"></span>
        <span class="typing-dot"></span>
        <span class="typing-dot"></span>
    `;

    wrap.appendChild(bubble);

    chatBox.appendChild(wrap);

    scrollBottom();
}

function removeTyping() {

    var t = document.getElementById('typing-indicator');

    if (t) t.remove();
}

function hideSuggestions() {

    var s = document.getElementById('suggestions');

    if (s) s.style.display = 'none';
}

function setLoading(on) {

    sendBtn.disabled = on;

    input.disabled = on;

    sendBtn.style.opacity = on ? '0.6' : '1';
}

function sendSuggestion(text) {

    input.value = text;

    sendMessage();
}

async function sendMessage() {

    var text = input.value.trim();

    if (!text) return;

    hideSuggestions();

    input.value = '';

    input.style.height = 'auto';

    appendBubble('user', text);

    chatHistory.push({
        role: 'user',
        text: text
    });

    appendTyping();

    setLoading(true);

    try {

        const response = await fetch('{{ route('enseignant.chatbot.chat') }}', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },

            body: JSON.stringify({
                messages: chatHistory
            }),
        });

        const data = await response.json();

        removeTyping();

        var reply =
            data.reply ||
            data.error ||
            'Erreur inattendue.';

        appendBubble('model', reply);

        chatHistory.push({
            role: 'model',
            text: reply
        });

    } catch (e) {

        removeTyping();

        appendBubble(
            'model',
            '⚠️ Impossible de contacter l’assistant IA.'
        );

    } finally {

        setLoading(false);

        scrollBottom();
    }
}

function clearChat() {

    chatHistory = [];

    chatBox.innerHTML = '';

    document.getElementById('suggestions').style.display = 'flex';

    var welcome = document.createElement('div');

    welcome.style.cssText = `
        display:flex;
        flex-direction:column;
        align-items:flex-start;
        gap:3px;
    `;

    welcome.innerHTML = `
        <span style="
            font-size:0.7rem;
            font-weight:600;
            color:#8E6CFF;
            padding:0 4px;
        ">
            Assistant IA
        </span>

        <div style="
            max-width:75%;
            padding:12px 16px;
            border-radius:16px 16px 16px 4px;
            background:#fff;
            border:1px solid #f1f5f9;
            box-shadow:0 1px 3px rgba(0,0,0,0.04);
            font-size:0.855rem;
            line-height:1.6;
            color:#1e293b;
        ">
            👋 Conversation réinitialisée.
            Comment puis-je vous aider ?
        </div>
    `;

    chatBox.appendChild(welcome);

    scrollBottom();
}

input.addEventListener('input', function () {

    this.style.height = 'auto';

    this.style.height =
        Math.min(this.scrollHeight, 120) + 'px';
});

input.addEventListener('keydown', function (e) {

    if (e.key === 'Enter' && !e.shiftKey) {

        e.preventDefault();

        sendMessage();
    }
});

scrollBottom();
</script>

<style>

.typing-dot {
    width:7px;
    height:7px;
    border-radius:50%;
    background:#8E6CFF;
    opacity:0.5;
    animation:dot 1.2s infinite;
}

.typing-dot:nth-child(2) {
    animation-delay:0.2s;
}

.typing-dot:nth-child(3) {
    animation-delay:0.4s;
}

@keyframes dot {

    0%,80%,100% {
        opacity:0.2;
        transform:scale(0.8);
    }

    40% {
        opacity:1;
        transform:scale(1.1);
    }
}

#chat-box {
    overflow-y:auto;
    scroll-behavior:smooth;
}

#chat-box p {
    margin:8px 0;
}

#chat-box ul,
#chat-box ol {
    margin:8px 0 8px 18px;
}

#chat-box li {
    margin-bottom:4px;
}

#chat-box pre {
    background:#0f172a;
    color:#fff;
    padding:12px;
    border-radius:10px;
    overflow:auto;
    margin:10px 0;
}

#chat-box code {
    font-family:monospace;
}

#chat-box strong {
    font-weight:700;
}

#chat-box table {
    border-collapse:collapse;
    width:100%;
    margin:10px 0;
}

#chat-box table th,
#chat-box table td {
    border:1px solid #e2e8f0;
    padding:8px;
}

</style>
@endsection
