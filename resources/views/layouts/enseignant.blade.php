<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mon Espace') · Frizzly</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <style type="text/tailwindcss">
            @theme {
                --color-primary:      #E94E3C;
                --color-primary-dark: #C73D2D;
                --color-secondary:    #FFC857;
                --color-blue:         #4DA3FF;
                --color-green:        #2ECC71;
                --color-purple:       #8E6CFF;
                --color-orange:       #F97316;
                --font-sans: 'Poppins', ui-sans-serif, system-ui, sans-serif;
            }
        </style>
    @endif

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        [x-cloak] { display: none !important; }

        /* ── Sidebar links ── */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #64748b;
            text-decoration: none;
            transition: background 0.18s, color 0.18s;
            white-space: nowrap;
            overflow: hidden;
        }
        .nav-link .nav-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            background: #f1f5f9;
            color: #64748b;
            transition: background 0.18s, color 0.18s;
        }
        .nav-link:hover { background: #f8fafc; color: #1e293b; }
        .nav-link:hover .nav-icon { background: #e2e8f0; color: #1e293b; }
        .nav-link.active { background: #fff0ee; color: #E94E3C; font-weight: 700; }
        .nav-link.active .nav-icon { background: #E94E3C; color: #fff; }

        /* ── Cards ── */
        .e-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid #f1f5f9;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        /* ── Misc ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }
    </style>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('head')
</head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:'Poppins',sans-serif;">

@php
    $authUser     = Auth::user();
    $userInitial  = strtoupper(substr($authUser->name, 0, 1));
    $totalQuizzes = \App\Models\Quiz::where('status','active')->count();
    $doneQuizzes  = $totalQuizzes > 0
        ? \App\Models\QuizResult::where('user_id', $authUser->id)->distinct('quiz_id')->count('quiz_id')
        : 0;
    $progress = $totalQuizzes > 0 ? round(($doneQuizzes / $totalQuizzes) * 100) : 0;
@endphp

<div style="display:flex;height:100vh;overflow:hidden;" x-data="{ open: true }">

    {{-- ══════════════════════════════════════════
         SIDEBAR
    ══════════════════════════════════════════ --}}
    <aside style="display:flex;flex-direction:column;background:#fff;border-right:1px solid #f1f5f9;flex-shrink:0;transition:width 0.25s ease;overflow:hidden;"
           :style="open ? 'width:248px' : 'width:68px'">

        {{-- Top colour bar --}}
        <div style="height:3px;background:linear-gradient(90deg,#E94E3C,#FFC857,#4DA3FF,#8E6CFF);flex-shrink:0;"></div>

        {{-- Brand --}}
        <div style="display:flex;align-items:center;gap:10px;padding:18px 16px 14px;flex-shrink:0;overflow:hidden;">
            <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#E94E3C,#FFC857);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:0.9rem;flex-shrink:0;">F</div>
            <div style="overflow:hidden;transition:opacity 0.2s,width 0.25s;" :style="open ? 'opacity:1;width:auto' : 'opacity:0;width:0'">
                <p style="font-weight:800;color:#0f172a;font-size:0.95rem;line-height:1.1;white-space:nowrap;">Frizzly</p>
                <p style="font-size:0.7rem;font-weight:600;color:#E94E3C;white-space:nowrap;">Mon Espace</p>
            </div>
        </div>

        {{-- Mini profile --}}
        <div style="margin:0 10px 12px;padding:12px;border-radius:14px;background:linear-gradient(135deg,#FFF8E7,#FDECEA);flex-shrink:0;overflow:hidden;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,#E94E3C,#F97316);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:0.9rem;flex-shrink:0;">{{ $userInitial }}</div>
                <div style="overflow:hidden;transition:opacity 0.2s,width 0.25s;min-width:0;" :style="open ? 'opacity:1;flex:1' : 'opacity:0;width:0;flex:0'">
                    <p style="font-weight:700;color:#0f172a;font-size:0.8rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $authUser->name }}</p>
                    <p style="font-size:0.7rem;color:#94a3b8;white-space:nowrap;">Enseignant</p>
                </div>
            </div>
            <div style="transition:opacity 0.2s,max-height 0.25s;overflow:hidden;" :style="open ? 'opacity:1;max-height:60px;margin-top:10px' : 'opacity:0;max-height:0;margin-top:0'">
                <div style="display:flex;justify-content:space-between;font-size:0.7rem;margin-bottom:5px;">
                    <span style="color:#94a3b8;">Progression</span>
                    <span style="font-weight:700;color:#E94E3C;">{{ $progress }}%</span>
                </div>
                <div style="height:5px;background:#fff;border-radius:99px;overflow:hidden;">
                    <div style="height:100%;width:{{ $progress }}%;background:linear-gradient(90deg,#E94E3C,#FFC857);border-radius:99px;"></div>
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav style="flex:1;overflow-y:auto;padding:0 8px;" id="sidebar-nav">
            @php
                $navLinks = [
                    ['route' => 'enseignant.dashboard', 'icon' => 'bi-book-fill',           'label' => 'Bibliothèque',  'active' => request()->routeIs('enseignant.dashboard')],
                    ['route' => 'enseignant.quiz',      'icon' => 'bi-clipboard2-check-fill','label' => 'Tests',         'active' => request()->routeIs('enseignant.quiz') || request()->routeIs('quiz.*')],
                    ['route' => 'enseignant.messages',  'icon' => 'bi-chat-dots-fill',       'label' => 'Messages',      'active' => request()->routeIs('enseignant.messages')],
                    ['route' => 'enseignant.chatbot',   'icon' => 'bi-robot',                'label' => 'Assistant IA',  'active' => request()->routeIs('enseignant.chatbot')],
                ];
            @endphp

            @foreach($navLinks as $link)
            <a href="{{ route($link['route']) }}"
               class="nav-link {{ $link['active'] ? 'active' : '' }}"
               style="margin-bottom:3px;">
                <span class="nav-icon"
                    @if($link['active'] && $link['icon'] === 'bi-robot')
                    style="background:linear-gradient(135deg,#8E6CFF,#E94E3C);color:#fff;"
                    @endif>
                    <i class="bi {{ $link['icon'] }}"></i>
                </span>
                <span style="transition:opacity 0.2s;" :style="open ? 'opacity:1' : 'opacity:0'">{{ $link['label'] }}</span>
            </a>
            @endforeach
        </nav>

        {{-- Bottom / logout --}}
        <div style="border-top:1px solid #f1f5f9;padding:12px 8px;flex-shrink:0;">
            <form method="POST" action="{{ route('logout') }}"
                  style="display:flex;align-items:center;gap:10px;padding:8px;border-radius:12px;cursor:pointer;overflow:hidden;"
                  onmouseover="this.style.background='#fff0ee'" onmouseout="this.style.background='transparent'">
                @csrf
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#E94E3C,#F97316);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:0.85rem;flex-shrink:0;">{{ $userInitial }}</div>
                <div style="flex:1;min-width:0;overflow:hidden;transition:opacity 0.2s,width 0.25s;" :style="open ? 'opacity:1' : 'opacity:0;width:0'">
                    <p style="font-size:0.78rem;font-weight:600;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $authUser->name }}</p>
                    <p style="font-size:0.68rem;color:#94a3b8;white-space:nowrap;">Se déconnecter</p>
                </div>
                <button type="submit" style="background:none;border:none;cursor:pointer;color:#94a3b8;font-size:1rem;flex-shrink:0;padding:0;transition:color 0.15s;display:flex;align-items:center;"
                        :style="open ? 'opacity:1' : 'opacity:0;width:0;overflow:hidden'"
                        onmouseover="this.style.color='#E94E3C'" onmouseout="this.style.color='#94a3b8'">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>

    </aside>

    {{-- ══════════════════════════════════════════
         MAIN
    ══════════════════════════════════════════ --}}
    <div style="flex:1;display:flex;flex-direction:column;overflow:hidden;min-width:0;">

        {{-- Topbar --}}
        <header style="background:#fff;border-bottom:1px solid #f1f5f9;padding:0 24px;height:60px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
            <div style="display:flex;align-items:center;gap:14px;">
                <button @click="open = !open"
                        style="width:36px;height:36px;border-radius:10px;background:#f8fafc;border:1px solid #f1f5f9;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background 0.15s;"
                        onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                    <i class="bi bi-list" style="font-size:1.2rem;color:#64748b;"></i>
                </button>
                <div>
                    <h1 style="font-weight:700;color:#0f172a;font-size:0.95rem;line-height:1.2;">@yield('page-title','Mon Espace')</h1>
                    <p style="font-size:0.72rem;color:#94a3b8;margin:0;">@yield('page-sub','')</p>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="display:flex;align-items:center;gap:8px;padding:6px 12px;background:#f8fafc;border-radius:10px;border:1px solid #f1f5f9;">
                    <div style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#E94E3C,#F97316);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.75rem;">{{ $userInitial }}</div>
                    <span style="font-size:0.78rem;font-weight:600;color:#374151;">{{ $authUser->name }}</span>
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main style="flex:1;overflow-y:auto;padding:24px;">
            @yield('content')
        </main>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('#sidebar-nav .nav-link').forEach(function(link) {
        link.addEventListener('click', function() {
            document.querySelectorAll('#sidebar-nav .nav-link').forEach(function(l) {
                l.classList.remove('active');
            });
            link.classList.add('active');
        });
    });
});
</script>

@stack('scripts')
</body>
</html>
