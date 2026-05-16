<nav x-data="{ open: false, scrolled: false }"
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     class="sticky top-0 z-50 border-b border-gray-100 transition-all duration-500 bg-white"
     :class="scrolled ? 'shadow-md' : 'shadow-sm'">
    <div class="max-w-7xl mx-auto px-6">
        {{-- Desktop height container --}}
        <div class="flex items-center justify-between transition-all duration-500"
             :class="scrolled ? 'h-20' : 'h-28'">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 group shrink-0">
                <img src="{{ asset('logo.png') }}"
                     alt="Frizzly"
                     :class="scrolled ? 'h-14' : 'h-20'"
                     class="w-auto transition-all duration-500 group-hover:scale-105 drop-shadow-sm">
            </a>

            <!-- Desktop Nav Links -->
            <div class="hidden md:flex items-center gap-7">
                @php
                $links = [
                    ['route' => 'about',      'label' => 'Nous connaître', 'icon' => 'bi-people',        'color' => 'text-primary'],
                    ['route' => 'programme',  'label' => 'Programme',      'icon' => 'bi-book',          'color' => 'text-purple'],
                    ['route' => 'produits',   'label' => 'Produits',       'icon' => 'bi-grid-3x3-gap',  'color' => 'text-green'],
                    
                    ['route' => 'contact',    'label' => 'Contact',        'icon' => 'bi-envelope',      'color' => 'text-blue'],
                ];
                @endphp
                @foreach($links as $link)
                <a href="{{ route($link['route']) }}"
                   class="relative flex items-center gap-2 text-gray-600 hover:text-primary font-medium text-sm transition-all duration-200 group/link
                          after:absolute after:bottom-[-4px] after:left-0 after:h-0.5 after:w-0
                          after:bg-primary after:rounded-full after:transition-all after:duration-300
                          hover:after:w-full
                          {{ request()->routeIs($link['route']) ? 'text-primary after:w-full' : '' }}">
                    <i class="bi {{ $link['icon'] }} {{ $link['color'] }} opacity-80 group-hover/link:opacity-100 group-hover/link:scale-110 transition-all"></i>
                    <span>{{ $link['label'] }}</span>
                </a>
                @endforeach
            </div>

            <!-- Desktop CTAs -->
            <div class="hidden md:flex items-center gap-3">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="text-gray-600 hover:text-primary font-semibold text-sm transition-colors duration-200 px-2">
                            Admin
                        </a>
                    @elseif(Auth::user()->role === 'enseignant')
                        <a href="{{ route('enseignant.dashboard') }}"
                           class="text-gray-600 hover:text-primary font-semibold text-sm transition-colors duration-200 px-2">
                            Mon Espace
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-5 py-2.5 rounded-full font-bold text-sm transition-all duration-200 flex items-center gap-1.5">
                            <i class="bi bi-box-arrow-right text-xs"></i>
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-gray-600 hover:text-primary font-semibold text-sm transition-colors duration-200 px-2">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}"
                       class="bg-primary text-white hover:bg-primary-dark px-5 py-2.5 rounded-full font-bold text-sm
                              shadow-lg shadow-primary/30 hover:-translate-y-0.5 transition-all duration-200
                              flex items-center gap-1.5">
                        <i class="bi bi-person-plus-fill text-xs"></i>
                        Créer un compte
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger -->
            <button @click="open = !open"
                    class="md:hidden p-2 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100 transition-all duration-200"
                    aria-label="Menu">
                <i x-show="!open" class="bi bi-list text-2xl block"></i>
                <i x-show="open"  class="bi bi-x-lg text-xl block"></i>
            </button>
        </div>

        <!-- Mobile Dropdown -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-3"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-3"
             class="md:hidden border-t border-gray-100 py-6">
            <div class="flex flex-col gap-1">
                @foreach($links as $link)
                <a href="{{ route($link['route']) }}"
                   class="flex items-center gap-3 text-gray-600 hover:text-primary hover:bg-primary/5 font-medium py-3.5 px-4 rounded-2xl transition-all duration-200">
                    <i class="bi {{ $link['icon'] }} {{ $link['color'] }} text-base w-5 text-center"></i>
                    {{ $link['label'] }}
                </a>
                @endforeach
                <div class="flex flex-col gap-3 pt-4 mt-2 border-t border-gray-100">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="flex items-center justify-center gap-2 border-2 border-gray-200 text-gray-700 py-3.5 rounded-full font-semibold">
                                <i class="bi bi-speedometer2"></i> Admin
                            </a>
                        @elseif(Auth::user()->role === 'enseignant')
                            <a href="{{ route('enseignant.dashboard') }}"
                               class="flex items-center justify-center gap-2 border-2 border-gray-200 text-gray-700 py-3.5 rounded-full font-semibold">
                                <i class="bi bi-grid-fill"></i> Mon Espace
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 bg-gray-100 text-gray-700 py-3.5 rounded-full font-bold">
                                <i class="bi bi-box-arrow-right"></i> Déconnexion
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="flex items-center justify-center gap-2 border-2 border-gray-200 text-gray-700
                                  hover:border-primary hover:text-primary py-3.5 rounded-full font-semibold transition-all duration-200">
                            <i class="bi bi-box-arrow-in-right"></i> Connexion
                        </a>
                        <a href="{{ route('register') }}"
                           class="flex items-center justify-center gap-2 bg-primary text-white
                                  hover:bg-primary-dark py-3.5 rounded-full font-bold transition-all duration-200 shadow-lg shadow-primary/25">
                            <i class="bi bi-person-plus-fill"></i> Créer un compte
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
