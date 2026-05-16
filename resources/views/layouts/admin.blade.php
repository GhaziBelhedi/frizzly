<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Dashboard') · Frizzly</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
                --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
            }
        </style>
    @endif

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        ::selection { background: rgba(233,78,60,0.12); }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* ── Sidebar ── */
        .sidebar { transition: width 0.25s cubic-bezier(.4,0,.2,1); overflow: hidden; }
        .sidebar-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 10px;
            font-size: 0.8125rem; font-weight: 500;
            color: #94a3b8; transition: all 0.18s; text-decoration: none;
            white-space: nowrap; overflow: hidden;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.07); color: #e2e8f0; }
        .sidebar-link.active {
            background: linear-gradient(135deg,#E94E3C,#ff6b5b);
            color: #fff;
            box-shadow: 0 4px 12px rgba(233,78,60,0.3);
        }
        .sidebar-icon { font-size: 1rem; width: 18px; text-align: center; flex-shrink: 0; }
        .sidebar-label { min-width: 0; overflow: hidden; white-space: nowrap; transition: opacity 0.18s, max-width 0.18s; }
        .sidebar-collapsed .sidebar-label { opacity: 0; max-width: 0; pointer-events: none; }
        .sidebar-collapsed .sidebar-badge { display: none; }
        .sidebar-logout:hover { background: rgba(239,68,68,0.1); color: #f87171; }
        .sidebar-link.active-purple {
            background: linear-gradient(135deg,#8E6CFF,#4DA3FF);
            color: #fff;
            box-shadow: 0 4px 12px rgba(142,108,255,0.3);
        }

        /* ── Cards ── */
        .card { background: #fff; border-radius: 16px; border: 1px solid #f1f5f9; }
        .stat-card {
            background: #fff; border-radius: 16px; padding: 20px;
            border: 1px solid #f1f5f9; transition: box-shadow 0.2s, transform 0.2s;
            display: block; text-decoration: none; color: inherit;
        }
        .stat-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.07); transform: translateY(-1px); }

        /* ── Badges ── */
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 10px; border-radius: 20px;
            font-size: 0.7rem; font-weight: 600; white-space: nowrap;
        }

        /* ── Tables ── */
        .data-table { width: 100%; font-size: 0.875rem; border-collapse: collapse; }
        .data-table th {
            text-align: left; padding: 11px 20px;
            font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.05em; color: #94a3b8;
            background: #f8fafc; border-bottom: 1px solid #f1f5f9;
        }
        .data-table td { padding: 14px 20px; border-bottom: 1px solid #f8fafc; color: #374151; }
        .data-table tbody tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover td { background: #fafbfc; }

        /* ── Forms ── */
        .field {
            width: 100%; padding: 10px 14px; border-radius: 10px;
            border: 1.5px solid #e5e7eb; font-size: 0.875rem;
            font-family: 'Inter', sans-serif; color: #111827;
            background: #fff; outline: none; transition: border-color 0.15s, box-shadow 0.15s;
        }
        .field:focus { border-color: #4DA3FF; box-shadow: 0 0 0 3px rgba(77,163,255,0.12); }
        .field-purple:focus { border-color: #8E6CFF; box-shadow: 0 0 0 3px rgba(142,108,255,0.12); }
        .field-red:focus { border-color: #E94E3C; box-shadow: 0 0 0 3px rgba(233,78,60,0.12); }
        .field-search { padding-left: 36px; }
        label.field-label { display: block; font-size: 0.75rem; font-weight: 600; color: #6b7280; margin-bottom: 6px; }

        /* ── Buttons ── */
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px;
               padding: 9px 18px; border-radius: 10px; font-size: 0.8125rem; font-weight: 600;
               cursor: pointer; border: none; transition: all 0.18s; text-decoration: none; }
        .btn:active { transform: scale(0.97); }
        .btn-primary { background: linear-gradient(135deg,#4DA3FF,#8E6CFF); color: #fff; }
        .btn-primary:hover { opacity: 0.9; box-shadow: 0 4px 14px rgba(77,163,255,0.35); }
        .btn-red { background: linear-gradient(135deg,#E94E3C,#F97316); color: #fff; }
        .btn-red:hover { opacity: 0.9; box-shadow: 0 4px 14px rgba(233,78,60,0.35); }
        .btn-green { background: linear-gradient(135deg,#2ECC71,#4DA3FF); color: #fff; }
        .btn-green:hover { opacity: 0.9; }
        .btn-orange { background: linear-gradient(135deg,#F97316,#FFC857); color: #fff; }
        .btn-orange:hover { opacity: 0.9; }
        .btn-purple { background: linear-gradient(135deg,#8E6CFF,#4DA3FF); color: #fff; }
        .btn-purple:hover { opacity: 0.9; }
        .btn-ghost { background: #f1f5f9; color: #64748b; }
        .btn-ghost:hover { background: #e2e8f0; }
        .btn-sm { padding: 6px 14px; font-size: 0.75rem; border-radius: 8px; }
        .btn-icon { width: 32px; height: 32px; padding: 0; border-radius: 8px; }

        /* ── Modals ── */
        .modal-backdrop { position: absolute; inset: 0; background: rgba(15,23,42,0.55); backdrop-filter: blur(4px); }
        .modal-box {
            position: relative; background: #fff; border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.18); overflow: hidden;
            max-height: calc(100vh - 2rem); display: flex; flex-direction: column;
        }
        .modal-header { padding: 20px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
        .modal-body { padding: 24px; overflow-y: auto; flex: 1; }
        .modal-footer { padding: 16px 24px; border-top: 1px solid #f1f5f9; flex-shrink: 0; }

        /* ── Line clamp ── */
        .clamp-1 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; }
        .clamp-2 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
        .clamp-3 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; }

        /* ── Progress bar ── */
        .progress-track { height: 6px; background: #f1f5f9; border-radius: 99px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 99px; transition: width 0.5s ease; }

        /* ── Flash ── */
        .flash { padding: 12px 16px; border-radius: 12px; font-size: 0.875rem; font-weight: 500; display: flex; align-items: center; gap: 8px; }
        .flash-ok  { background: #E8FAF0; color: #166534; border-left: 3px solid #2ECC71; }
        .flash-err { background: #FEF2F2; color: #991b1b; border-left: 3px solid #EF4444; }

        /* ── Section header ── */
        .section-header { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .section-title { font-size: 0.875rem; font-weight: 700; color: #111827; display: flex; align-items: center; gap: 8px; }

        /* ── Page sub-header accent ── */
        .page-accent { width: 4px; height: 20px; border-radius: 99px; display: inline-block; flex-shrink: 0; }

        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('head')
</head>
<body style="background:#f8fafc;">

<div style="display:flex;height:100vh;overflow:hidden;" x-data="{ open: true }" :class="open ? '' : 'sidebar-collapsed'">

    {{-- ────────── SIDEBAR ────────── --}}
    <aside class="sidebar flex-shrink-0 flex flex-col"
           :style="open ? 'width:256px' : 'width:66px'"
           style="background:#0f172a;border-right:1px solid rgba(255,255,255,0.06);z-index:30;">

        {{-- Logo --}}
        <div style="padding:18px 14px 16px;border-bottom:1px solid rgba(255,255,255,0.06);display:flex;align-items:center;gap:12px;flex-shrink:0;">
            <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#E94E3C,#FFC857);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.9rem;color:#fff;flex-shrink:0;">F</div>
            <div class="sidebar-label">
                <p style="font-weight:800;color:#fff;font-size:0.9375rem;line-height:1.2;">Frizzly</p>
                <p style="font-size:0.6875rem;font-weight:600;color:#E94E3C;">Administration</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav style="flex:1;overflow-y:auto;padding:12px 10px;display:flex;flex-direction:column;gap:2px;">

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill sidebar-icon"></i>
                <span class="sidebar-label">Dashboard</span>
            </a>

            <a href="{{ route('admin.tests.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.tests.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard2-check-fill sidebar-icon"></i>
                <span class="sidebar-label">Tests Reçus</span>
            </a>

            {{-- QCM (expandable) --}}
            <div x-data="{ qcmOpen: {{ request()->routeIs('admin.quiz.*') ? 'true' : 'false' }} }">

                {{-- Parent toggle button --}}
                <button @click="qcmOpen = !qcmOpen"
                        class="sidebar-link {{ request()->routeIs('admin.quiz.*') ? 'active-purple' : '' }}"
                        style="width:100%;border:none;cursor:pointer;">
                    <i class="bi bi-patch-question-fill sidebar-icon"></i>
                    <span class="sidebar-label" style="flex:1;text-align:left;">QCM</span>
                    <i class="bi sidebar-label sidebar-icon"
                       :class="qcmOpen ? 'bi-chevron-up' : 'bi-chevron-down'"
                       style="font-size:0.625rem;opacity:0.5;flex-shrink:0;"></i>
                </button>

                {{-- Sub-items --}}
                <div x-show="qcmOpen"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="sidebar-label"
                     style="padding-left:10px;margin-top:2px;display:flex;flex-direction:column;gap:2px;overflow:visible;max-width:none;">

                    <a href="{{ route('admin.quiz.index') }}"
                       class="sidebar-link {{ request()->routeIs('admin.quiz.index') ? 'active-purple' : '' }}">
                        <i class="bi bi-list-task sidebar-icon" style="font-size:0.875rem;width:16px;"></i>
                        <span>Tous les QCM</span>
                    </a>

                    <a href="{{ route('admin.quiz.create') }}"
                       class="sidebar-link {{ request()->routeIs('admin.quiz.create') ? 'active-purple' : '' }}">
                        <i class="bi bi-plus-circle-fill sidebar-icon" style="font-size:0.875rem;width:16px;"></i>
                        <span>Créer un QCM</span>
                    </a>

                </div>
            </div>

            <a href="{{ route('admin.users.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill sidebar-icon"></i>
                <span class="sidebar-label">Utilisateurs</span>
            </a>

            <a href="{{ route('admin.library.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.library.*') ? 'active' : '' }}">
                <i class="bi bi-book-fill sidebar-icon"></i>
                <span class="sidebar-label">Bibliothèque PDF</span>
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="bi bi-bag-fill sidebar-icon"></i>
                <span class="sidebar-label">Produits & Commandes</span>
            </a>

            <a href="{{ route('admin.messages.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                <i class="bi bi-envelope-fill sidebar-icon"></i>
                <span class="sidebar-label">Messages</span>
                @if(isset($unreadMessages) && $unreadMessages > 0)
                <span class="sidebar-badge ml-auto" style="background:#E94E3C;color:#fff;font-size:0.6rem;font-weight:700;padding:1px 6px;border-radius:99px;flex-shrink:0;">{{ $unreadMessages }}</span>
                @endif
            </a>
        </nav>

        {{-- User + logout --}}
        <div style="padding:10px;border-top:1px solid rgba(255,255,255,0.06);flex-shrink:0;">
            <div style="display:flex;align-items:center;gap:10px;padding:8px 10px;margin-bottom:2px;">
                <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#E94E3C,#FFC857);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.875rem;flex-shrink:0;">M</div>
                <div class="sidebar-label" style="min-width:0;">
                    <p style="color:#f1f5f9;font-size:0.8125rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Maram</p>
                    <p style="color:#64748b;font-size:0.6875rem;white-space:nowrap;">Administratrice</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link sidebar-logout" style="width:100%;border:none;background:none;cursor:pointer;">
                    <i class="bi bi-box-arrow-right sidebar-icon"></i>
                    <span class="sidebar-label">Déconnexion</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ────────── MAIN ────────── --}}
    <div style="flex:1;display:flex;flex-direction:column;min-width:0;overflow:hidden;">

        {{-- Header --}}
        <header style="background:#fff;border-bottom:1px solid #f1f5f9;padding:0 24px;height:60px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
            <div style="display:flex;align-items:center;gap:16px;">
                <button @click="open = !open"
                        style="width:36px;height:36px;border-radius:10px;background:#f8fafc;border:1px solid #f1f5f9;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background 0.15s;"
                        onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                    <i class="bi bi-list" style="color:#64748b;font-size:1.125rem;"></i>
                </button>
                <div>
                    <h1 style="font-weight:700;color:#0f172a;font-size:1rem;line-height:1.25;">@yield('page-title','Dashboard')</h1>
                    <p style="font-size:0.75rem;color:#94a3b8;margin-top:1px;">@yield('page-sub','Espace administrateur')</p>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:0.75rem;color:#cbd5e1;">{{ now()->format('d M Y') }}</span>
                <div style="width:1px;height:18px;background:#f1f5f9;"></div>
                <a href="{{ route('admin.messages.index') }}" style="position:relative;width:36px;height:36px;border-radius:10px;background:#f8fafc;border:1px solid #f1f5f9;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:background 0.15s;">
                    <i class="bi bi-bell" style="color:#64748b;font-size:0.9375rem;"></i>
                    @if(isset($unreadMessages) && $unreadMessages > 0)
                    <span style="position:absolute;top:7px;right:7px;width:7px;height:7px;background:#E94E3C;border-radius:50%;border:1.5px solid #fff;"></span>
                    @endif
                </a>
                <a href="{{ route('home') }}" target="_blank" title="Voir le site" style="width:36px;height:36px;border-radius:10px;background:#f8fafc;border:1px solid #f1f5f9;display:flex;align-items:center;justify-content:center;text-decoration:none;">
                    <i class="bi bi-box-arrow-up-right" style="color:#64748b;font-size:0.8125rem;"></i>
                </a>
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="flash flash-ok mx-6 mt-4" x-data="{v:true}" x-show="v" x-init="setTimeout(()=>v=false,4000)" x-transition:leave="transition-opacity duration-300" x-transition:leave-end="opacity-0">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="flash flash-err mx-6 mt-4" x-data="{v:true}" x-show="v" x-init="setTimeout(()=>v=false,4000)" x-transition:leave="transition-opacity duration-300" x-transition:leave-end="opacity-0">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
        </div>
        @endif

        {{-- Page content --}}
        <main style="flex:1;overflow-y:auto;padding:24px;" id="main-content">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
@stack('scripts')
</body>
</html>
