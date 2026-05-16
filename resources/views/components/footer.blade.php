<footer class="bg-gray-900 text-gray-300 pt-16 pb-8 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-64 h-64 bg-primary/5 rounded-full -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-80 h-80 bg-blue/5 rounded-full translate-x-1/3 translate-y-1/3 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

            <!-- Brand -->
            <div class="lg:col-span-2">
                <a href="{{ route('home') }}" class="inline-flex mb-5">
                    <img src="{{ asset('logo.png') }}" alt="Frizzly" class="h-16 w-auto brightness-0 invert opacity-90">
                </a>
                <p class="text-gray-400 leading-relaxed text-sm max-w-sm mb-6">
                    Transformez la posture professionnelle des enseignants à travers les compétences entrepreneuriales et des outils pédagogiques innovants.
                </p>
                <div class="flex gap-3">
                    @foreach([['bi-twitter-x','#'],['bi-linkedin','#'],['bi-instagram','#'],['bi-youtube','#']] as $s)
                    <a href="{{ $s[1] }}"
                       class="w-9 h-9 bg-gray-800 hover:bg-primary rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all duration-200 hover:scale-110">
                        <i class="bi {{ $s[0] }} text-sm"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Plateforme -->
            <div>
                <h4 class="text-white font-bold mb-5 text-sm uppercase tracking-widest">Plateforme</h4>
                <ul class="space-y-3 text-sm">
                    @foreach([['about','Nous connaître'],['programme','Programme'],['produits','Produits'],['contact','Contact']] as $l)
                    <li>
                        <a href="{{ route($l[0]) }}"
                           class="text-gray-400 hover:text-primary transition-colors duration-200 flex items-center gap-1.5 group">
                            <i class="bi bi-arrow-right text-xs opacity-0 group-hover:opacity-100 -ml-1 group-hover:ml-0 transition-all duration-200"></i>
                            {{ $l[1] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-white font-bold mb-5 text-sm uppercase tracking-widest">Contact</h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex items-start gap-2">
                        <i class="bi bi-envelope-fill text-primary mt-0.5 shrink-0"></i>
                        <a href="mailto:hello@frizzly.tn" class="hover:text-primary transition-colors">hello@frizzly.tn</a>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-geo-alt-fill text-primary mt-0.5 shrink-0"></i>
                        <span>Tunis, Tunisie 🇹🇳</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-clock-fill text-primary mt-0.5 shrink-0"></i>
                        <span>Lun – Ven, 9h – 18h</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="border-t border-gray-800 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm">
            <p class="text-gray-500">© {{ date('Y') }} Frizzly. Tous droits réservés.</p>
            <p class="text-gray-400 flex items-center gap-1.5 font-medium">
                Fait avec <span class="text-red-400">❤️</span> en Tunisie 🇹🇳
            </p>
            <div class="flex gap-5 text-xs text-gray-600">
                <a href="#" class="hover:text-primary transition-colors">Confidentialité</a>
                <a href="#" class="hover:text-primary transition-colors">CGU</a>
                <a href="#" class="hover:text-primary transition-colors">Mentions légales</a>
            </div>
        </div>
    </div>
</footer>
