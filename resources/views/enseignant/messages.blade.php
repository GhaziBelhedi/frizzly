@extends('layouts.enseignant')
@section('title', 'Messages')
@section('page-title', 'Messages')
@section('page-sub', 'Discussion de groupe — tous les enseignants')

@section('content')

<div style="height:calc(100vh - 108px);display:flex;flex-direction:column;background:#fff;border-radius:18px;border:1px solid #f1f5f9;box-shadow:0 1px 3px rgba(0,0,0,0.04);overflow:hidden;">

    {{-- Chat header --}}
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:12px;flex-shrink:0;background:#fff;">
        <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#8E6CFF,#4DA3FF);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="bi bi-people-fill" style="color:#fff;font-size:1rem;"></i>
        </div>
        <div style="flex:1;">
            <p style="font-weight:700;color:#0f172a;font-size:0.9rem;line-height:1.2;">Groupe Enseignants</p>
            <p style="font-size:0.72rem;color:#94a3b8;margin:0;">Discussion ouverte à tous les enseignants</p>
        </div>
        <div style="width:8px;height:8px;border-radius:50%;background:#2ECC71;" title="En ligne"></div>
    </div>

    {{-- Messages area --}}
    <div id="chat-box" style="flex:1;overflow-y:auto;padding:20px;display:flex;flex-direction:column;gap:12px;background:#f8fafc;">

        @forelse($messages as $msg)
        @php $mine = $msg->user_id === Auth::id(); @endphp
        <div data-id="{{ $msg->id }}" style="display:flex;flex-direction:column;align-items:{{ $mine ? 'flex-end' : 'flex-start' }};">
            @if(!$mine)
            <span style="font-size:0.7rem;font-weight:600;color:#64748b;margin-bottom:3px;padding:0 4px;">{{ $msg->user->name }}</span>
            @endif
            <div style="max-width:68%;padding:10px 14px;border-radius:{{ $mine ? '16px 16px 4px 16px' : '16px 16px 16px 4px' }};font-size:0.855rem;line-height:1.55;word-break:break-word;
                {{ $mine
                    ? 'background:linear-gradient(135deg,#8E6CFF,#4DA3FF);color:#fff;'
                    : 'background:#fff;color:#1e293b;border:1px solid #f1f5f9;box-shadow:0 1px 3px rgba(0,0,0,0.04);' }}">
                {{ $msg->message }}
            </div>
            <span style="font-size:0.67rem;color:#94a3b8;margin-top:3px;padding:0 4px;">{{ $msg->created_at->format('H:i') }}</span>
        </div>

        @empty
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px;text-align:center;gap:10px;" data-empty>
            <div style="width:52px;height:52px;border-radius:14px;background:#ede9fe;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-chat-dots" style="font-size:1.4rem;color:#8E6CFF;"></i>
            </div>
            <p style="font-weight:600;color:#64748b;font-size:0.9rem;">Aucun message pour l'instant</p>
            <p style="font-size:0.8rem;color:#94a3b8;">Soyez le premier à écrire !</p>
        </div>
        @endforelse

    </div>

    {{-- Input bar --}}
    <div style="padding:12px 16px;border-top:1px solid #f1f5f9;background:#fff;flex-shrink:0;">
        <form id="chat-form" method="POST" action="{{ route('enseignant.messages.store') }}"
              style="display:flex;align-items:flex-end;gap:10px;">
            @csrf
            <textarea id="chat-input" name="message" rows="1" required
                      placeholder="Écrire un message… (Entrée pour envoyer)"
                      style="flex:1;border:1.5px solid #e2e8f0;border-radius:12px;padding:10px 14px;font-size:0.855rem;font-family:'Poppins',sans-serif;resize:none;outline:none;line-height:1.5;max-height:120px;overflow-y:auto;transition:border-color 0.18s;background:#f8fafc;"
                      onfocus="this.style.borderColor='#8E6CFF';this.style.background='#fff'"
                      onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'"></textarea>
            <button type="submit"
                    style="width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#8E6CFF,#4DA3FF);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff;transition:transform 0.15s,box-shadow 0.15s;box-shadow:0 2px 8px rgba(142,108,255,0.35);"
                    onmouseover="this.style.transform='scale(1.07)'"
                    onmouseout="this.style.transform='scale(1)'">
                <i class="bi bi-send-fill" style="font-size:0.85rem;"></i>
            </button>
        </form>
    </div>
</div>

<script>
var lastId  = {{ $messages->isNotEmpty() ? $messages->last()->id : 0 }};
var chatBox = document.getElementById('chat-box');

function scrollBottom() { chatBox.scrollTop = chatBox.scrollHeight; }
scrollBottom();

function esc(s) {
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function appendMsg(m) {
    var empty = chatBox.querySelector('[data-empty]');
    if (empty) empty.remove();

    var wrap = document.createElement('div');
    wrap.dataset.id = m.id;
    wrap.style.cssText = 'display:flex;flex-direction:column;align-items:' + (m.mine ? 'flex-end' : 'flex-start') + ';';

    var html = '';
    if (!m.mine) html += '<span style="font-size:0.7rem;font-weight:600;color:#64748b;margin-bottom:3px;padding:0 4px;">' + esc(m.name) + '</span>';

    html += '<div style="max-width:68%;padding:10px 14px;border-radius:' +
        (m.mine ? '16px 16px 4px 16px' : '16px 16px 16px 4px') + ';font-size:0.855rem;line-height:1.55;word-break:break-word;' +
        (m.mine
            ? 'background:linear-gradient(135deg,#8E6CFF,#4DA3FF);color:#fff;'
            : 'background:#fff;color:#1e293b;border:1px solid #f1f5f9;box-shadow:0 1px 3px rgba(0,0,0,0.04);') +
        '">' + esc(m.message) + '</div>';

    html += '<span style="font-size:0.67rem;color:#94a3b8;margin-top:3px;padding:0 4px;">' + m.time + '</span>';
    wrap.innerHTML = html;
    chatBox.appendChild(wrap);
}

function poll() {
    fetch('{{ route('enseignant.messages.poll') }}?after=' + lastId)
        .then(r => r.json())
        .then(msgs => {
            if (!msgs.length) return;
            var atBottom = chatBox.scrollHeight - chatBox.scrollTop - chatBox.clientHeight < 80;
            msgs.forEach(function(m) { appendMsg(m); lastId = m.id; });
            if (atBottom) scrollBottom();
        })
        .catch(() => {});
}
setInterval(poll, 3000);

// Auto-resize textarea
var ta = document.getElementById('chat-input');
ta.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

// Enter = send, Shift+Enter = newline
ta.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        document.getElementById('chat-form').requestSubmit();
    }
});
</script>
@endsection
