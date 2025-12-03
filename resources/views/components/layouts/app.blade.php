<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Club Informatique U-Auben' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- CSS Global et Composants -->
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">

    <!-- CSS spécifiques aux pages -->
    @stack('styles')

    <!-- Vite Assets -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <script src="https://kit.fontawesome.com/6ecc15475c.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="app">
        <!-- Header/Navigation -->
        <header class="header">
            <div class="header__container container">
                <a href="{{ route('home') }}" class="header__logo">
                    <span class="header__logo-text">Club Informatique U-Auben</span>
                </a>

                <nav class="nav">
                    <button class="nav__toggle" aria-label="Menu">☰</button>

                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="{{ route('home') }}"
                                class="nav__link {{ request()->routeIs('home') ? 'nav__link--active' : '' }}">
                                Accueil
                            </a>
                        </li>

                        @guest
                            <li class="nav__item">
                                <a href="{{ route('candidate.register') }}" class="nav__link nav__link--primary">
                                    Devenir Candidat
                                </a>
                            </li>
                        @else
                            @role('admin')
                                <li class="nav__item">
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="nav__link {{ request()->routeIs('admin.dashboard') ? 'nav__link--active' : '' }}">
                                        Dashboard Admin
                                    </a>
                                </li>
                            @endrole

                            @role('candidate')
                                <li class="nav__item">
                                    <a href="{{ route('candidate.dashboard') }}"
                                        class="nav__link {{ request()->routeIs('candidate.dashboard') ? 'nav__link--active' : '' }}">
                                        Mon Dashboard
                                    </a>
                                </li>
                            @endrole

                            <li class="nav__item">
                                <div class="user-menu">
                                    <button class="user-menu__trigger" onclick="toggleUserMenu()">
                                        @if (auth()->user()->photo_path)
                                            <img src="{{ Storage::url(auth()->user()->photo_path) }}"
                                                alt="{{ auth()->user()->prenom }}" class="user-menu__avatar">
                                        @else
                                            <div class="user-menu__avatar">{{ substr(auth()->user()->prenom, 0, 1) }}</div>
                                        @endif
                                        <span class="user-menu__name">{{ auth()->user()->prenom }}</span>
                                    </button>

                                    <ul class="user-menu__dropdown" id="userMenuDropdown">
                                        <li class="user-menu__dropdown-item">
                                            <span class="user-menu__dropdown-link" style="pointer-events: none;">
                                                {{ auth()->user()->email }}
                                            </span>
                                        </li>
                                        <li>
                                            <hr class="user-menu__dropdown-divider">
                                        </li>
                                        <li class="user-menu__dropdown-item">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="user-menu__dropdown-link"
                                                    style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; font: inherit;">
                                                    Déconnexion
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer__container">
                <div class="footer__grid">
                    <div class="footer__section">
                        <h3 class="footer__title">Club Informatique U-Auben</h3>
                        <p class="footer__text">
                            L'association des étudiants passionnés d'informatique de l'Université Aube Nouvelle.
                            Ensemble, construisons l'avenir numérique.
                        </p>
                        <div class="footer__social">
                            <a href="#" class="footer__social-link" aria-label="Facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="#" class="footer__social-link" aria-label="LinkedIn">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="footer__social-link" aria-label="GitHub">
                                <i class="fa-brands fa-github"></i>
                            </a>
                        </div>
                    </div>

                    <div class="footer__section">
                        <h3 class="footer__title">Navigation</h3>
                        <ul class="footer__list">
                            <li><a href="{{ route('home') }}" class="footer__link">Accueil</a></li>
                            <li><a href="{{ route('candidate.register') }}" class="footer__link">Devenir Candidat</a>
                            </li>
                        </ul>
                    </div>

                    <div class="footer__section">
                        <h3 class="footer__title">Contact</h3>
                        <p class="footer__text">
                            <i class="fa-solid fa-envelope"
                                style="color: var(--color-tertiary-light-blue); margin-right: 8px;"></i>
                            contact@clubinfo-u-auben.bf
                        </p>
                        <p class="footer__text">
                            <i class="fa-solid fa-location-dot"
                                style="color: var(--color-tertiary-light-blue); margin-right: 8px;"></i>
                            Université Aube Nouvelle<br>
                            <span style="margin-left: 24px;">Ouagadougou, Burkina Faso</span>
                        </p>
                    </div>
                </div>

                <div class="footer__bottom">
                    <p class="footer__copyright">
                        &copy; {{ date('Y') }} Club Informatique U-Auben. Tous droits réservés.
                    </p>
                    <p class="footer__made-with">
                        Fait avec <i class="fa-solid fa-heart"></i> par les étudiants de U-Auben
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Script pour le menu utilisateur -->
    <script>
        function toggleUserMenu() {
            const dropdown = document.getElementById('userMenuDropdown');
            dropdown.classList.toggle('user-menu__dropdown--open');
        }

        // Fermer le menu si on clique ailleurs
        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('.user-menu');
            const dropdown = document.getElementById('userMenuDropdown');

            if (userMenu && dropdown && !userMenu.contains(event.target)) {
                dropdown.classList.remove('user-menu__dropdown--open');
            }
        });

        // Script pour le menu mobile
        const navToggle = document.querySelector('.nav__toggle');
        const navList = document.querySelector('.nav__list');

        if (navToggle && navList) {
            navToggle.addEventListener('click', function() {
                navList.classList.toggle('nav__list--open');
            });
        }
    </script>
</body>

</html>
