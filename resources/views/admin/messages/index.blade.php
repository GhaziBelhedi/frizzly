@extends('layouts.admin')
@section('title', 'Messages')
@section('page-title', 'Messages')
@section('page-sub', 'Boite de reception et gestion des messages')

@section('content')
@php
$dummy = collect([
    (object)['id'=>1,'sender_name'=>'Amira Bensalem', 'email'=>'amira@ecole.tn',   'phone'=>'+216 71 234 567','subject'=>'Demande de demonstration','message'=>'Bonjour, je suis directrice dans une ecole primaire a Tunis. Je souhaiterais organiser une demonstration du Frizzly Kit pour mon equipe pedagogique. Pouvez-vous me contacter pour convenir d un rendez-vous ?','status'=>'unread','reply'=>null,'created_at'=>\Carbon\Carbon::now()->subHours(2)],
    (object)['id'=>2,'sender_name'=>'Karim Trabelsi', 'email'=>'karim@gmail.com',  'phone'=>'+216 20 345 678','subject'=>'Question sur le programme','message'=>'Bonjour, j ai decouvert Frizzly sur les reseaux sociaux. J aimerais savoir si le programme certifiant est reconnu par le ministere de l education. Merci de m eclairer sur ce point.','status'=>'unread','reply'=>null,'created_at'=>\Carbon\Carbon::now()->subHours(5)],
    (object)['id'=>3,'sender_name'=>'Nadia Sfar',     'email'=>'nsfar@moe.tn',     'phone'=>'+216 71 890 123','subject'=>'Partenariat etablissement','message'=>'Bonjour, je represente un etablissement scolaire regional. Nous souhaitons integrer le Frizzly Kit dans notre formation continue d enseignants. Seriez-vous interesses par un partenariat institutionnel ?','status'=>'unread','reply'=>null,'created_at'=>\Carbon\Carbon::now()->subDay()],
    (object)['id'=>4,'sender_name'=>'Sami Gharbi',    'email'=>'sami@gmail.com',   'phone'=>'+216 55 456 789','subject'=>'Probleme de commande #047','message'=>'Bonjour, j ai passe commande il y a 5 jours (reference #047) mais je n ai pas encore recu de confirmation. Pourriez-vous verifier ?','status'=>'read','reply'=>'Bonjour Sami, votre commande a bien ete enregistree et sera livree dans 48h. Merci pour votre patience.','created_at'=>\Carbon\Carbon::now()->subDays(2)],
    (object)['id'=>5,'sender_name'=>'Leila Jouini',   'email'=>'leila@gmail.com',  'phone'=>'+216 22 567 890','subject'=>'Retour positif utilisateur','message'=>'Bonjour, j utilise le Frizzly Kit depuis deux mois. Je voulais vous faire part de mon retour tres positif. Mes eleves sont beaucoup plus engages depuis que j utilise les cartes Socita.','status'=>'read','reply'=>null,'created_at'=>\Carbon\Carbon::now()->subDays(3)],
]);
$messages = $messages ?? $dummy;
$unread   = $unread   ?? $messages->where('status','unread')->count();
$avatarColors = ['#4DA3FF','#8E6CFF','#E94E3C','#2ECC71','#F97316'];
@endphp

{{-- Use JS to set height so the panel fills the content area --}}
<div id="msg-container" style="display:flex;gap:20px;height:calc(100vh - 9rem);min-height:500px;">

    {{-- ─── LEFT PANEL: LIST ─── --}}
    <div style="width:320px;flex-shrink:0;background:#fff;border-radius:16px;border:1px solid #f1f5f9;display:flex;flex-direction:column;overflow:hidden;">

        {{-- Header --}}
        <div style="padding:16px;border-bottom:1px solid #f1f5f9;flex-shrink:0;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                <h2 style="font-weight:700;color:#0f172a;font-size:0.9375rem;">Inbox</h2>
                @if($unread>0)
                <span class="badge" style="color:#991b1b;background:#fee2e2;">{{ $unread }} non lus</span>
                @endif
            </div>
            <form method="GET">
                <div style="position:relative;">
                    <i class="bi bi-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:0.8125rem;"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..." class="field field-search" style="font-size:0.8rem;padding:8px 12px 8px 32px;">
                </div>
            </form>
            <div style="display:flex;gap:4px;margin-top:10px;">
                @foreach([['','Tous'],['unread','Non lus'],['read','Lus']] as $f)
                @php $active = (request('status','') === $f[0]) || ($f[0]==='' && !request('status')); @endphp
                <a href="{{ request()->fullUrlWithQuery(['status'=>$f[0]]) }}"
                   style="flex:1;padding:5px 8px;border-radius:8px;font-size:0.75rem;font-weight:600;text-align:center;text-decoration:none;transition:all 0.15s;{{ $active ? 'background:linear-gradient(135deg,#E94E3C,#F97316);color:#fff;' : 'color:#64748b;background:transparent;' }}"
                   onmouseover="{{ $active ? '' : "this.style.background='#f1f5f9'" }}" onmouseout="{{ $active ? '' : "this.style.background='transparent'" }}">
                    {{ $f[1] }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Message list --}}
        <div style="flex:1;overflow-y:auto;" id="msg-list">
            @foreach($messages as $idx => $m)
            @php $ac = $avatarColors[$idx % 5]; @endphp
            <a href="#msg-{{ $m->id }}" onclick="showMsg({{ $m->id }}); return false;"
               id="list-item-{{ $m->id }}"
               style="display:flex;align-items:flex-start;gap:10px;padding:13px 16px;border-bottom:1px solid #f8fafc;text-decoration:none;transition:background 0.15s;cursor:pointer;{{ $idx===0 ? 'background:rgba(233,78,60,0.04);border-left:3px solid #E94E3C;' : '' }}"
               onmouseover="this.style.background='#fafbfc'" onmouseout="if(currentMsg !== {{ $m->id }}) this.style.background=''; else this.style.background='rgba(233,78,60,0.04)'">
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,{{ $ac }},#8E6CFF);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.875rem;flex-shrink:0;margin-top:1px;">{{ strtoupper(substr($m->sender_name,0,1)) }}</div>
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:4px;margin-bottom:2px;">
                        <p style="font-weight:{{ $m->status==='unread'?'700':'600' }};font-size:0.8125rem;color:#0f172a;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;flex:1;">{{ $m->sender_name }}</p>
                        <span style="font-size:0.6875rem;color:#94a3b8;white-space:nowrap;flex-shrink:0;">{{ $m->created_at->diffForHumans(null,true) }}</span>
                    </div>
                    <p style="font-size:0.75rem;font-weight:{{ $m->status==='unread'?'600':'400' }};color:{{ $m->status==='unread'?'#374151':'#64748b' }};overflow:hidden;text-overflow:ellipsis;white-space:nowrap;margin-bottom:2px;">{{ $m->subject }}</p>
                    <p style="font-size:0.7rem;color:#94a3b8;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Str::limit($m->message,55) }}</p>
                </div>
                @if($m->status==='unread')
                <span style="width:7px;height:7px;border-radius:50%;background:#E94E3C;flex-shrink:0;margin-top:5px;display:inline-block;"></span>
                @endif
            </a>
            @endforeach
        </div>
    </div>

    {{-- ─── RIGHT PANEL: CONTENT ─── --}}
    <div style="flex:1;min-width:0;position:relative;">
        @foreach($messages as $idx => $m)
        @php $ac = $avatarColors[$idx % 5]; @endphp
        <div id="msg-{{ $m->id }}" class="msg-panel" style="{{ $idx===0 ? '' : 'display:none;' }}background:#fff;border-radius:16px;border:1px solid #f1f5f9;height:100%;display:flex;flex-direction:column;overflow:hidden;">

            {{-- Message header --}}
            <div style="padding:18px 24px;border-bottom:1px solid #f1f5f9;flex-shrink:0;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">
                    <div style="flex:1;min-width:0;">
                        <h2 style="font-weight:700;color:#0f172a;font-size:1rem;margin-bottom:6px;">{{ $m->subject }}</h2>
                        <div style="display:flex;flex-wrap:wrap;gap:12px;font-size:0.75rem;color:#64748b;">
                            <span style="display:flex;align-items:center;gap:5px;"><i class="bi bi-person-fill" style="color:#94a3b8;"></i>{{ $m->sender_name }}</span>
                            <span style="display:flex;align-items:center;gap:5px;"><i class="bi bi-envelope" style="color:#94a3b8;"></i>{{ $m->email }}</span>
                            @if($m->phone)<span style="display:flex;align-items:center;gap:5px;"><i class="bi bi-telephone" style="color:#94a3b8;"></i>{{ $m->phone }}</span>@endif
                            <span style="display:flex;align-items:center;gap:5px;"><i class="bi bi-clock" style="color:#94a3b8;"></i>{{ $m->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                    <div style="display:flex;gap:8px;flex-shrink:0;">
                        @if($m->status==='unread')
                        <form method="POST" action="{{ route('admin.messages.read', $m->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-green"><i class="bi bi-check2-all"></i> Lu</button>
                        </form>
                        @else
                        <span class="badge" style="color:#166534;background:#dcfce7;padding:6px 12px;font-size:0.75rem;"><i class="bi bi-check2-all"></i> Lu</span>
                        @endif
                        <form method="POST" action="{{ route('admin.messages.destroy', $m->id) }}" onsubmit="return confirm('Supprimer ce message ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-icon" style="background:rgba(239,68,68,0.1);color:#EF4444;"><i class="bi bi-trash-fill"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Message body --}}
            <div style="flex:1;overflow-y:auto;padding:20px 24px;">
                <div style="background:#f8fafc;border-radius:14px;padding:18px;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                        <div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,{{ $ac }},#8E6CFF);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.75rem;flex-shrink:0;">{{ strtoupper(substr($m->sender_name,0,1)) }}</div>
                        <span style="font-weight:600;font-size:0.875rem;color:#0f172a;">{{ $m->sender_name }}</span>
                        <span style="font-size:0.75rem;color:#94a3b8;">{{ $m->email }}</span>
                    </div>
                    <p style="font-size:0.875rem;color:#374151;line-height:1.7;">{{ $m->message }}</p>
                </div>
            </div>
        </div>
        @endforeach

        @if($messages->isEmpty())
        <div style="background:#fff;border-radius:16px;border:1px solid #f1f5f9;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px 24px;text-align:center;">
            <i class="bi bi-inbox" style="font-size:3rem;color:#e2e8f0;display:block;margin-bottom:12px;"></i>
            <p style="font-weight:600;color:#94a3b8;font-size:0.9375rem;">Aucun message</p>
            <p style="font-size:0.875rem;color:#cbd5e1;margin-top:4px;">Votre boite de reception est vide</p>
        </div>
        @endif
    </div>
</div>

<script>
var currentMsg = {{ $messages->isNotEmpty() ? $messages->first()->id : 'null' }};

function showMsg(id) {
    // Hide all panels
    document.querySelectorAll('.msg-panel').forEach(p => p.style.display = 'none');
    // Show selected
    var panel = document.getElementById('msg-' + id);
    if (panel) panel.style.display = 'flex';

    // Update list active state
    document.querySelectorAll('#msg-list a').forEach(a => {
        a.style.background = '';
        a.style.borderLeft = '';
    });
    var listItem = document.getElementById('list-item-' + id);
    if (listItem) {
        listItem.style.background = 'rgba(233,78,60,0.04)';
        listItem.style.borderLeft = '3px solid #E94E3C';
    }
    currentMsg = id;
}
</script>
@endsection
