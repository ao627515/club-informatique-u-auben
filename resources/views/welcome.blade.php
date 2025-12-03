<x-layouts.app>
    <x-slot name="title">Accueil - Club Informatique U-Auben</x-slot>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    @endpush

    <div class="home">
        <!-- Hero Section -->
        <section class="home__hero">
            <div class="container">
                <h1 class="home__hero-title">
                    Bienvenue au Club Informatique U-Auben
                </h1>
                <p class="home__hero-subtitle">
                    L'association des étudiants passionnés d'informatique de l'Université Aube Nouvelle
                </p>
                <div class="home__hero-actions">
                    <a href="{{ route('candidate.register') }}" class="btn btn--primary btn--lg">
                        Devenir Candidat
                    </a>
                </div>
            </div>
        </section>

        <!-- Info Section -->
        <section class="home__info">
            <div class="container">
                <div class="home__info-content">
                    <h2 class="home__info-title">À propos du club</h2>
                    <p class="home__info-text">
                        Le Club Informatique de l'Université Aube Nouvelle est une association d'étudiants
                        passionnés par les technologies de l'information et de la communication.
                        Nous organisons des activités, des formations et des événements pour développer
                        les compétences numériques de nos membres.
                    </p>
                    <p class="home__info-text">
                        Rejoignez-nous en soumettant votre candidature dès maintenant !
                    </p>
                </div>
            </div>
        </section>
    </div>
</x-layouts.app>
