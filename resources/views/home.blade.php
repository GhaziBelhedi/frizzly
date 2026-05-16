@extends('layouts.app')
@section('title', 'Accueil')

@section('content')

{{-- ══════════════════════════════════════════════
     HERO
══════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-white pt-16 pb-28 lg:pt-24 lg:pb-36">
    {{-- Animated background blobs --}}
    <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full pointer-events-none animate-blob"
         style="background:radial-gradient(circle, #FDECEA 0%, transparent 70%); transform-origin:center;"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full pointer-events-none animate-blob"
         style="background:radial-gradient(circle, #FFF8E7 0%, transparent 70%); animation-delay:3s;"></div>

    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center relative z-10">

        {{-- ── Text side ─────────────────────────── --}}
        <div>
            <div class="flex items-center gap-3 mb-6">
                <div class="flex -space-x-2">
                    <img src="{{ asset('flag.png') }}" alt="Tunisie" class="w-10 h-10 rounded-full border-2 border-white shadow-md relative z-10">
                </div>
                <span class="bg-primary/10 text-primary text-xs font-bold px-4 py-2 rounded-full uppercase tracking-wide">
                    Plateforme éducative innovante · Tunisie
                </span>
            </div>

            <h1 class="text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                L'enseignant de
                <span class="gradient-text" style="background-image: linear-gradient(135deg, #E94E3C, #FFC857, #4DA3FF);">
                    demain
                </span><br>commence aujourd'hui
            </h1>

            <p class="text-xl text-gray-500 leading-relaxed mb-10 max-w-lg">
                Frizzly développe les compétences entrepreneuriales des enseignants via le Frizzly Kit — un dispositif pédagogique interactif, un assistant IA et des programmes certifiants.
            </p>

            <div class="flex flex-wrap gap-4 mb-10">
                <a href="{{ route('programme') }}"
                   class="inline-flex items-center gap-2 bg-primary text-white px-8 py-4 rounded-2xl font-bold text-lg
                          shadow-xl shadow-primary/30 hover:bg-primary-dark hover:-translate-y-1 transition-all duration-300">
                    <i class="bi bi-play-circle-fill"></i>
                    Commencer le test
                </a>
                <a href="{{ route('about') }}"
                   class="inline-flex items-center gap-2 bg-white text-gray-700 px-8 py-4 rounded-2xl font-bold text-lg
                          border-2 border-gray-200 hover:border-primary hover:text-primary transition-all duration-300">
                    En savoir plus <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            {{-- Stats --}}
            <div class="flex flex-wrap items-center gap-6 pt-6 border-t border-gray-100">
                @foreach([['500+','Enseignants','primary'],['12k+','Élèves','blue'],['5','Modules','green'],['9','Compétences','purple']] as $s)
                <div class="text-center">
                    <p class="text-2xl font-extrabold text-{{ $s[2] }}">{{ $s[0] }}</p>
                    <p class="text-xs text-gray-400 font-medium mt-0.5">{{ $s[1] }}</p>
                </div>
                @if(!$loop->last)<div class="w-px h-8 bg-gray-200"></div>@endif
                @endforeach
            </div>
        </div>

        {{-- ── SVG Illustration ─────────────────── --}}
        <div class="relative flex items-center justify-center h-[420px]">
            <svg viewBox="0 0 460 400" xmlns="http://www.w3.org/2000/svg" class="w-full max-w-lg">
                <defs>
                    <filter id="cs"><feDropShadow dx="0" dy="5" stdDeviation="5" flood-color="#00000018"/></filter>
                    <filter id="cs2"><feDropShadow dx="0" dy="3" stdDeviation="3" flood-color="#00000015"/></filter>
                </defs>
                {{-- Background blob --}}
                <ellipse cx="230" cy="200" rx="175" ry="155" fill="#FFF0EE" opacity="0.8"/>
                <circle cx="360" cy="80" r="55" fill="#FFF8E7" opacity="0.7"/>
                <circle cx="90" cy="300" r="40" fill="#EBF4FF" opacity="0.7"/>

                {{-- Teacher body --}}
                <rect x="168" y="198" width="94" height="105" rx="22" fill="#4DA3FF"/>
                <path d="M194 198 L230 220 L266 198" fill="white" opacity="0.2"/>

                {{-- Head --}}
                <circle cx="215" cy="162" r="44" fill="#FDDBB4"/>

                {{-- Hair --}}
                <path d="M172 155 Q176 112 215 107 Q254 112 258 155 Q248 128 215 126 Q182 128 172 155Z" fill="#4A3728"/>

                {{-- Eyes --}}
                <circle cx="200" cy="160" r="5.5" fill="#2D3748"/>
                <circle cx="230" cy="160" r="5.5" fill="#2D3748"/>
                <circle cx="202" cy="158" r="2" fill="white"/>
                <circle cx="232" cy="158" r="2" fill="white"/>

                {{-- Eyebrows --}}
                <path d="M193 149 Q200 145 207 149" stroke="#4A3728" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                <path d="M223 149 Q230 145 237 149" stroke="#4A3728" stroke-width="2.5" fill="none" stroke-linecap="round"/>

                {{-- Nose --}}
                <ellipse cx="215" cy="170" rx="3" ry="2" fill="#E8A87C"/>

                {{-- Smile --}}
                <path d="M202 178 Q215 190 228 178" stroke="#4A3728" stroke-width="2.5" fill="none" stroke-linecap="round"/>

                {{-- Cheeks --}}
                <circle cx="192" cy="175" r="7" fill="#F4A261" opacity="0.3"/>
                <circle cx="238" cy="175" r="7" fill="#F4A261" opacity="0.3"/>

                {{-- Arms --}}
                <rect x="118" y="208" width="55" height="22" rx="11" fill="#4DA3FF"/>
                <rect x="257" y="208" width="55" height="22" rx="11" fill="#4DA3FF"/>
                <circle cx="118" cy="219" r="11" fill="#FDDBB4"/>
                <circle cx="312" cy="219" r="11" fill="#FDDBB4"/>

                {{-- Legs --}}
                <rect x="177" y="292" width="30" height="58" rx="10" fill="#2D3748"/>
                <rect x="223" y="292" width="30" height="58" rx="10" fill="#2D3748"/>
                <ellipse cx="192" cy="350" rx="21" ry="9" fill="#1A202C"/>
                <ellipse cx="238" cy="350" rx="21" ry="9" fill="#1A202C"/>

                {{-- Removed the floating cards to focus on the guy --}}


                {{-- Decorative dots and stars --}}
                <circle cx="318" cy="28" r="14" fill="#FFC857" opacity="0.9"/>
                <circle cx="318" cy="28" r="8" fill="#FFD97D"/>
                <circle cx="138" cy="30" r="10" fill="#E94E3C" opacity="0.8"/>
                <circle cx="138" cy="30" r="5" fill="#F47C6E"/>
                <circle cx="400" cy="195" r="8" fill="#2ECC71" opacity="0.75"/>
                <circle cx="38" cy="340" r="9" fill="#4DA3FF" opacity="0.75"/>
                <circle cx="410" cy="330" r="6" fill="#8E6CFF" opacity="0.8"/>
                <circle cx="355" cy="170" r="5" fill="#FFC857"/>
                <circle cx="90" cy="150" r="4" fill="#4DA3FF" opacity="0.8"/>
            </svg>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     FEATURES — 4 colorful cards
══════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28" style="background: linear-gradient(180deg, #F9FAFB 0%, #FFFFFF 100%)">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-primary font-bold text-xs uppercase tracking-widest">Ce que Frizzly vous offre</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-3">Tout ce dont vous avez besoin</h2>
            <p class="text-gray-500">Une suite d'outils pensés pour les enseignants du primaire d'aujourd'hui.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @php
            $features = [
                [
                    'icon'    => 'bi-patch-check-fill',
                    'title'   => 'Test Diagnostique',
                    'desc'    => 'Identifiez votre profil pédagogique et vos axes de développement en quelques minutes.',
                    'bg'      => 'linear-gradient(135deg,#FDECEA,#FFF5F4)',
                    'icon_bg' => 'linear-gradient(135deg,#E94E3C,#F47C6E)',
                    'border'  => '#E94E3C22',
                    'link_c'  => '#E94E3C',
                ],
                [
                    'icon'    => 'bi-robot',
                    'title'   => 'ChatBot IA',
                    'desc'    => 'Votre assistant pédagogique intelligent disponible 24h/24 pour répondre à toutes vos questions.',
                    'bg'      => 'linear-gradient(135deg,#F0ECFF,#F7F4FF)',
                    'icon_bg' => 'linear-gradient(135deg,#8E6CFF,#A98BFF)',
                    'border'  => '#8E6CFF22',
                    'link_c'  => '#8E6CFF',
                ],
                [
                    'icon'    => 'bi-book-half',
                    'title'   => 'Bibliothèque',
                    'desc'    => 'Des centaines de ressources pédagogiques validées par des experts en sciences de l\'éducation.',
                    'bg'      => 'linear-gradient(135deg,#EBF4FF,#F0F7FF)',
                    'icon_bg' => 'linear-gradient(135deg,#4DA3FF,#70B8FF)',
                    'border'  => '#4DA3FF22',
                    'link_c'  => '#4DA3FF',
                ],
                [
                    'icon'    => 'bi-mortarboard-fill',
                    'title'   => 'Programme',
                    'desc'    => 'Un parcours certifiant en 5 modules pour développer 9 compétences entrepreneuriales.',
                    'bg'      => 'linear-gradient(135deg,#E8FAF0,#F0FDF6)',
                    'icon_bg' => 'linear-gradient(135deg,#2ECC71,#55D98D)',
                    'border'  => '#2ECC7122',
                    'link_c'  => '#2ECC71',
                ],
            ];
            @endphp

            @foreach($features as $f)
            <div class="card-hover rounded-3xl p-7 border-2 group cursor-pointer"
                 style="background:{{ $f['bg'] }}; border-color:{{ $f['border'] }};">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform duration-300"
                     style="background:{{ $f['icon_bg'] }};">
                    <i class="bi {{ $f['icon'] }} text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $f['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-4">{{ $f['desc'] }}</p>
                <a href="#" class="inline-flex items-center gap-1 font-semibold text-sm hover:gap-2 transition-all duration-200"
                   style="color:{{ $f['link_c'] }}">
                    Découvrir <i class="bi bi-arrow-right text-xs"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     PROGRAMME PREVIEW — 5 coloured module cards
══════════════════════════════════════════════ --}}
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-blue font-bold text-xs uppercase tracking-widest">Notre programme certifiant</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-3">5 modules pour se transformer</h2>
            <p class="text-gray-500">Un parcours progressif ancré dans des situations professionnelles réelles.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-10">
            @php
            $modules = [
                ['num'=>'01','title'=>'Se connaître','sub'=>'Autonomie · Confiance','color'=>'#E94E3C','light'=>'#FDECEA','dur'=>'14h'],
                ['num'=>'02','title'=>'Créer & Innover','sub'=>'Créativité · Résolution','color'=>'#2ECC71','light'=>'#E8FAF0','dur'=>'14h'],
                ['num'=>'03','title'=>'Agir dans l\'incertitude','sub'=>'Prise de risque · Confiance','color'=>'#F97316','light'=>'#FEF3EA','dur'=>'7h'],
                ['num'=>'04','title'=>'Collaborer','sub'=>'Collaboration · Leadership','color'=>'#4DA3FF','light'=>'#EBF4FF','dur'=>'7h'],
                ['num'=>'05','title'=>'Leadership','sub'=>'Initiative · Leadership','color'=>'#8E6CFF','light'=>'#F0ECFF','dur'=>'7h'],
            ];
            @endphp

            @foreach($modules as $m)
            <a href="{{ route('programme') }}"
               class="card-hover rounded-2xl p-5 text-center border-2 group block"
               style="background:{{ $m['light'] }}; border-color:{{ $m['color'] }}30;">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3 font-extrabold text-xl text-white shadow-md"
                     style="background:{{ $m['color'] }};">
                    {{ $m['num'] }}
                </div>
                <p class="font-bold text-gray-900 text-sm leading-snug mb-1">{{ $m['title'] }}</p>
                <p class="text-xs text-gray-500 mb-2">{{ $m['sub'] }}</p>
                <span class="inline-block text-xs font-bold px-2.5 py-1 rounded-full"
                      style="background:{{ $m['color'] }}18; color:{{ $m['color'] }};">
                    {{ $m['dur'] }}
                </span>
            </a>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('programme') }}"
               class="inline-flex items-center gap-2 bg-primary text-white px-8 py-4 rounded-2xl font-bold
                      shadow-lg shadow-primary/25 hover:bg-primary-dark hover:-translate-y-0.5 transition-all duration-200">
                <i class="bi bi-mortarboard-fill"></i> Voir le programme complet
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     FRIZZLY KIT SHOWCASE
══════════════════════════════════════════════ --}}
<section class="py-20" style="background:linear-gradient(135deg,#F9FAFB 0%,#FFF5F4 100%)">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-secondary-dark font-bold text-xs uppercase tracking-widest">Le Frizzly Kit</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-3">Trois dimensions de compétences</h2>
            <p class="text-gray-500">Des cartes pédagogiques interactives pour développer vos compétences directement dans la pratique de classe.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @php
            $dimensions = [
                ['icon'=>'bi-lightbulb-fill','name'=>'Cognitif et créatif','color'=>'#4DA3FF','light'=>'rgba(77,163,255,0.12)',
                 'skills'=>['Créativité','Pensée critique','Innovation','Résolution de problèmes']],
                ['icon'=>'bi-lightning-charge-fill','name'=>'Action et conatif','color'=>'#F97316','light'=>'rgba(249,115,22,0.12)',
                 'skills'=>['Prise d\'initiative','Autonomie','Adaptabilité','Leadership']],
                ['icon'=>'bi-people-fill','name'=>'Social','color'=>'#2ECC71','light'=>'rgba(46,204,113,0.12)',
                 'skills'=>['Communication','Collaboration','Interaction sociale','Dynamique de groupe']],
            ];
            @endphp

            @foreach($dimensions as $dim)
            <div class="card-hover rounded-2xl overflow-hidden border-2 cursor-pointer group bg-white"
                 style="border-color:{{ $dim['color'] }}30;">
                <div class="h-28 flex items-center justify-center"
                     style="background:{{ $dim['light'] }};">
                    <i class="bi {{ $dim['icon'] }} text-5xl group-hover:scale-125 transition-transform duration-400 inline-block"
                       style="color:{{ $dim['color'] }};"></i>
                </div>
                <div class="p-5">
                    <p class="font-bold text-gray-900 text-base mb-3">{{ $dim['name'] }}</p>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($dim['skills'] as $skill)
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-md"
                              style="background:{{ $dim['color'] }}15; color:{{ $dim['color'] }};">{{ $skill }}</span>
                        @endforeach
                    </div>
                    <div class="w-8 h-1 rounded-full mt-4" style="background:{{ $dim['color'] }};"></div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('produits') }}"
               class="inline-flex items-center gap-2 border-2 border-gray-200 text-gray-700 px-8 py-3
                      rounded-2xl font-semibold hover:border-primary hover:text-primary transition-all duration-200">
                Découvrir le Frizzly Kit <i class="bi bi-box-seam-fill"></i>
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     HOW IT WORKS
══════════════════════════════════════════════ --}}


{{-- ══════════════════════════════════════════════
     CTA BANNER
══════════════════════════════════════════════ --}}
<section class="py-20 relative overflow-hidden" style="background:linear-gradient(135deg,#E94E3C 0%,#FFC857 100%);">
    <div class="absolute inset-0 animate-gradient opacity-20"
         style="background:linear-gradient(135deg,#E94E3C,#FFC857,#4DA3FF,#8E6CFF);background-size:300% 300%;"></div>
    {{-- Decorative circles --}}
    <div class="absolute -top-20 -right-20 w-80 h-80 bg-white/10 rounded-full pointer-events-none"></div>
    <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-white/10 rounded-full pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
        <p class="text-white/80 font-semibold mb-3 text-sm uppercase tracking-widest">Rejoignez la communauté Frizzly</p>
        <h2 class="text-4xl lg:text-5xl font-extrabold text-white mb-6">
            Prêt à transformer votre classe ?
        </h2>
        <p class="text-xl text-white/85 mb-10 max-w-xl mx-auto">
            Plus de 500 enseignants tunisiens  font confiance à Frizzly. 🇹🇳
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('register') }}"
               class="inline-flex items-center gap-2 bg-white text-primary px-10 py-4 rounded-2xl font-bold text-lg
                      hover:bg-secondary hover:text-gray-900 transition-all duration-200 shadow-2xl hover:-translate-y-1">
                <i class="bi bi-rocket-takeoff-fill"></i>
                Commencer gratuitement
            </a>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 glass text-white px-10 py-4 rounded-2xl font-bold text-lg
                      hover:bg-white/25 transition-all duration-200">
                Nous contacter
            </a>
        </div>
    </div>
</section>

@endsection
