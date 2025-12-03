<div class="candidate-register">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/candidate-register.css') }}">
    @endpush

    <!-- Background decoratif -->
    <div class="candidate-register__bg-decor">
        <div class="candidate-register__bg-circle candidate-register__bg-circle--1"></div>
        <div class="candidate-register__bg-circle candidate-register__bg-circle--2"></div>
        <div class="candidate-register__bg-circle candidate-register__bg-circle--3"></div>
    </div>

    <div class="candidate-register__container">
        <!-- Header avec design amélioré -->
        <div class="candidate-register__header">
            <div class="candidate-register__header-badge">
                <i class="fa-solid fa-bullseye candidate-register__header-badge-icon"></i>
                <span class="candidate-register__header-badge-text">Candidature ouverte</span>
            </div>
            <h1 class="candidate-register__title">
                <span class="candidate-register__title-highlight">Rejoignez</span> le Club
            </h1>
            <p class="candidate-register__subtitle">
                Devenez acteur du changement au sein du Club Informatique U-Auben.<br>
                <span class="candidate-register__subtitle-emphasis">Votre vision compte.</span>
            </p>
        </div>

        <!-- Indicateur de progression -->
        <div class="candidate-register__progress">
            <div class="candidate-register__progress-step candidate-register__progress-step--active">
                <div class="candidate-register__progress-icon">
                    <i class="fa-solid fa-user"></i>
                </div>
                <span class="candidate-register__progress-label">Identité</span>
            </div>
            <div class="candidate-register__progress-line"></div>
            <div class="candidate-register__progress-step">
                <div class="candidate-register__progress-icon">
                    <i class="fa-solid fa-star"></i>
                </div>
                <span class="candidate-register__progress-label">Candidature</span>
            </div>
            <div class="candidate-register__progress-line"></div>
            <div class="candidate-register__progress-step">
                <div class="candidate-register__progress-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <span class="candidate-register__progress-label">Validation</span>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert--success candidate-register__alert">
                <div class="alert__icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="alert__message">{{ session('success') }}</div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert--error candidate-register__alert">
                <div class="alert__icon">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="alert__message">{{ session('error') }}</div>
            </div>
        @endif

        <div class="candidate-register__card">
            <form wire:submit="submit">
                @guest
                    <!-- Section inscription utilisateur -->
                    <div class="candidate-register__section candidate-register__section--fade-in">
                        <div class="candidate-register__section-header">
                            <div class="candidate-register__section-icon">
                                <i class="fa-solid fa-user-pen"></i>
                            </div>
                            <div>
                                <h2 class="candidate-register__section-title">Informations personnelles</h2>
                                <p class="candidate-register__section-subtitle">Renseignez vos coordonnées</p>
                            </div>
                        </div>

                        <div class="candidate-register__form-row candidate-register__form-row--two-cols">
                            <!-- Matricule -->
                            <div class="form-group form-group--modern">
                                <label for="matricule" class="form-group__label form-group__label--required">
                                    <i class="fa-solid fa-graduation-cap form-group__label-icon"></i>
                                    Matricule
                                </label>
                                <div class="form-group__input-wrapper">
                                    <input type="text" id="matricule" wire:model="matricule"
                                        class="form-group__input @error('matricule') form-group__input--error @enderror"
                                        placeholder="Ex: ABC123456">
                                    <span class="form-group__input-focus"></span>
                                </div>
                                @error('matricule')
                                    <span class="form-group__error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Nom -->
                            <div class="form-group form-group--modern">
                                <label for="nom" class="form-group__label form-group__label--required">
                                    <i class="fa-solid fa-user form-group__label-icon"></i>
                                    Nom
                                </label>
                                <div class="form-group__input-wrapper">
                                    <input type="text" id="nom" wire:model="nom"
                                        class="form-group__input @error('nom') form-group__input--error @enderror"
                                        placeholder="Votre nom">
                                    <span class="form-group__input-focus"></span>
                                </div>
                                @error('nom')
                                    <span class="form-group__error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="candidate-register__form-row candidate-register__form-row--two-cols">
                            <!-- Prénom -->
                            <div class="form-group form-group--modern">
                                <label for="prenom" class="form-group__label form-group__label--required">
                                    <i class="fa-solid fa-sparkles form-group__label-icon"></i>
                                    Prénom
                                </label>
                                <div class="form-group__input-wrapper">
                                    <input type="text" id="prenom" wire:model="prenom"
                                        class="form-group__input @error('prenom') form-group__input--error @enderror"
                                        placeholder="Votre prénom">
                                    <span class="form-group__input-focus"></span>
                                </div>
                                @error('prenom')
                                    <span class="form-group__error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group form-group--modern">
                                <label for="email" class="form-group__label form-group__label--required">
                                    <i class="fa-solid fa-envelope form-group__label-icon"></i>
                                    Email
                                </label>
                                <div class="form-group__input-wrapper">
                                    <input type="email" id="email" wire:model="email"
                                        class="form-group__input @error('email') form-group__input--error @enderror"
                                        placeholder="votre@email.com">
                                    <span class="form-group__input-focus"></span>
                                </div>
                                @error('email')
                                    <span class="form-group__error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Photo utilisateur -->
                        <div class="form-group form-group--modern">
                            <label for="photoUtilisateur" class="form-group__label">
                                <i class="fa-solid fa-camera form-group__label-icon"></i>
                                Photo de profil
                                <span class="form-group__label-optional">(optionnelle)</span>
                            </label>
                            <div class="candidate-register__upload-zone" x-data="{ isDragging: false }"
                                x-on:dragover.prevent="isDragging = true" x-on:dragleave.prevent="isDragging = false"
                                x-on:drop.prevent="isDragging = false"
                                :class="{ 'candidate-register__upload-zone--dragging': isDragging }">
                                <input type="file" id="photoUtilisateur" wire:model="photoUtilisateur"
                                    accept="image/jpeg,image/png" class="candidate-register__upload-input">
                                <div class="candidate-register__upload-content">
                                    @if ($photoUtilisateur)
                                        <div class="candidate-register__photo-preview">
                                            <img src="{{ $photoUtilisateur->temporaryUrl() }}" alt="Aperçu"
                                                class="candidate-register__photo-preview-img">
                                            <div class="candidate-register__photo-overlay">
                                                <span>Changer la photo</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="candidate-register__upload-icon">
                                            <i class="fa-solid fa-cloud-arrow-up"></i>
                                        </div>
                                        <p class="candidate-register__upload-text">
                                            <span class="candidate-register__upload-text-primary">Cliquez pour
                                                sélectionner</span>
                                            <span class="candidate-register__upload-text-secondary">ou glissez-déposez
                                                votre image</span>
                                        </p>
                                        <p class="candidate-register__upload-hint">PNG, JPG jusqu'à 2MB</p>
                                    @endif
                                </div>
                            </div>
                            @error('photoUtilisateur')
                                <span class="form-group__error">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    {{ $message }}
                                </span>
                            @enderror

                            <div wire:loading wire:target="photoUtilisateur" class="candidate-register__file-uploading">
                                <i class="fa-solid fa-spinner fa-spin"></i>
                                <span>Téléchargement en cours...</span>
                            </div>
                        </div>
                    </div>
                @endguest

                <!-- Section candidature -->
                <div class="candidate-register__section candidate-register__section--fade-in">
                    <div class="candidate-register__section-header">
                        <div class="candidate-register__section-icon candidate-register__section-icon--secondary">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div>
                            <h2 class="candidate-register__section-title">Votre candidature</h2>
                            <p class="candidate-register__section-subtitle">Exprimez votre vision et vos motivations
                            </p>
                        </div>
                    </div>

                    <!-- Documents (désactivés) -->
                    <div class="candidate-register__disabled-fields">
                        <div class="candidate-register__disabled-notice">
                            <i class="fa-solid fa-circle-info"></i>
                            <span>Documents complémentaires disponibles après validation</span>
                        </div>
                        <div class="candidate-register__disabled-grid">
                            <div class="candidate-register__disabled-item">
                                <div class="candidate-register__disabled-item-icon">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                                <div class="candidate-register__disabled-item-info">
                                    <span class="candidate-register__disabled-item-title">Photo officielle</span>
                                    <span class="candidate-register__disabled-item-desc">Dashboard candidat</span>
                                </div>
                            </div>
                            <div class="candidate-register__disabled-item">
                                <div class="candidate-register__disabled-item-icon">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </div>
                                <div class="candidate-register__disabled-item-info">
                                    <span class="candidate-register__disabled-item-title">Programme PDF</span>
                                    <span class="candidate-register__disabled-item-desc">Dashboard candidat</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vision -->
                    <div class="form-group form-group--modern">
                        <label for="vision" class="form-group__label form-group__label--required">
                            <i class="fa-solid fa-eye form-group__label-icon"></i>
                            Votre vision
                        </label>
                        <div class="form-group__textarea-wrapper">
                            <textarea id="vision" wire:model="vision" rows="6"
                                class="form-group__textarea @error('vision') form-group__textarea--error @enderror"
                                placeholder="Décrivez votre vision pour le Club Informatique U-Auben..."></textarea>
                            <span class="form-group__textarea-focus"></span>
                        </div>
                        @error('vision')
                            <span class="form-group__error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </span>
                        @enderror
                        <div class="candidate-register__char-counter">
                            @php $visionLength = strlen($vision ?? ''); @endphp
                            <div class="candidate-register__char-bar">
                                <div class="candidate-register__char-bar-fill {{ $visionLength > 1800 ? 'candidate-register__char-bar-fill--warning' : '' }} {{ $visionLength > 2000 ? 'candidate-register__char-bar-fill--error' : '' }}"
                                    style="width: {{ min(($visionLength / 2000) * 100, 100) }}%"></div>
                            </div>
                            <span
                                class="candidate-register__char-count {{ $visionLength > 1800 ? 'candidate-register__char-count--warning' : '' }} {{ $visionLength > 2000 ? 'candidate-register__char-count--error' : '' }}">
                                {{ $visionLength }} / 2000
                            </span>
                        </div>
                    </div>

                    <!-- Motivations -->
                    <div class="form-group form-group--modern">
                        <label for="motivations" class="form-group__label form-group__label--required">
                            <i class="fa-solid fa-lightbulb form-group__label-icon"></i>
                            Vos motivations
                        </label>
                        <div class="form-group__textarea-wrapper">
                            <textarea id="motivations" wire:model="motivations" rows="4"
                                class="form-group__textarea @error('motivations') form-group__textarea--error @enderror"
                                placeholder="Expliquez ce qui vous motive à rejoindre le club..."></textarea>
                            <span class="form-group__textarea-focus"></span>
                        </div>
                        @error('motivations')
                            <span class="form-group__error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </span>
                        @enderror
                        <div class="candidate-register__char-counter">
                            @php $motivationsLength = strlen($motivations ?? ''); @endphp
                            <div class="candidate-register__char-bar">
                                <div class="candidate-register__char-bar-fill {{ $motivationsLength > 900 ? 'candidate-register__char-bar-fill--warning' : '' }} {{ $motivationsLength > 1000 ? 'candidate-register__char-bar-fill--error' : '' }}"
                                    style="width: {{ min(($motivationsLength / 1000) * 100, 100) }}%"></div>
                            </div>
                            <span
                                class="candidate-register__char-count {{ $motivationsLength > 900 ? 'candidate-register__char-count--warning' : '' }} {{ $motivationsLength > 1000 ? 'candidate-register__char-count--error' : '' }}">
                                {{ $motivationsLength }} / 1000
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Disclaimer amélioré -->
                <div class="candidate-register__disclaimer">
                    <div class="candidate-register__disclaimer-icon">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <div class="candidate-register__disclaimer-content">
                        <p class="candidate-register__disclaimer-title">Que se passe-t-il ensuite ?</p>
                        <p class="candidate-register__disclaimer-text">
                            Votre candidature sera examinée par notre équipe d'administration.
                            Vous recevrez une notification par email dès que la décision sera prise.
                        </p>
                    </div>
                </div>

                <!-- Actions avec design amélioré -->
                <div class="candidate-register__actions">
                    <a href="{{ route('home') }}" class="btn btn--ghost btn--lg candidate-register__btn-cancel">
                        <i class="fa-solid fa-arrow-left"></i>
                        Retour
                    </a>

                    <button type="submit" class="btn btn--primary btn--lg candidate-register__btn-submit"
                        wire:loading.attr="disabled" wire:target="submit,photoOfficielle,programme,photoUtilisateur">
                        <span wire:loading.remove wire:target="submit" class="candidate-register__btn-content">
                            <span>Soumettre ma candidature</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>
                        <span wire:loading wire:target="submit" class="candidate-register__btn-loading">
                            <i class="fa-solid fa-spinner fa-spin"></i>
                            Envoi en cours...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer informatif -->
        <div class="candidate-register__footer">
            <p><i class="fa-solid fa-lock"></i> Vos données sont protégées et ne seront utilisées que dans le cadre de
                votre candidature.</p>
        </div>
    </div>

    <!-- Loading overlay amélioré -->
    <div wire:loading wire:target="submit" class="candidate-register__loading">
        <div class="candidate-register__loading-content">
            <div class="candidate-register__loading-animation">
                <i class="fa-solid fa-spinner fa-spin fa-3x"></i>
            </div>
            <h3 class="candidate-register__loading-title">Traitement en cours</h3>
            <p class="candidate-register__loading-text">Nous enregistrons votre candidature...</p>
        </div>
    </div>
</div>
