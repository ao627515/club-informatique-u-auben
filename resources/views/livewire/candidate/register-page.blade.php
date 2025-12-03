<div class="candidate-register">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/candidate-register.css') }}">
    @endpush

    <div class="candidate-register__container">
        <div class="candidate-register__header">
            <h1 class="candidate-register__title">Soumettre votre candidature</h1>
            <p class="candidate-register__subtitle">
                Remplissez le formulaire ci-dessous pour soumettre votre candidature au Club Informatique U-Auben.
            </p>
        </div>

        @if (session()->has('success'))
            <div class="alert alert--success">
                <div class="alert__message">{{ session('success') }}</div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert--error">
                <div class="alert__message">{{ session('error') }}</div>
            </div>
        @endif

        <div class="candidate-register__card">
            <form wire:submit="submit">
                @guest
                    <!-- Section inscription utilisateur -->
                    <div class="candidate-register__section">
                        <h2 class="candidate-register__section-title">Informations personnelles</h2>

                        <div class="candidate-register__form-row candidate-register__form-row--two-cols">
                            <!-- Matricule -->
                            <div class="form-group">
                                <label for="matricule" class="form-group__label form-group__label--required">
                                    Matricule
                                </label>
                                <input type="text" id="matricule" wire:model="matricule"
                                    class="form-group__input @error('matricule') form-group__input--error @enderror"
                                    placeholder="Ex: ABC123456">
                                @error('matricule')
                                    <span class="form-group__error">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nom -->
                            <div class="form-group">
                                <label for="nom" class="form-group__label form-group__label--required">
                                    Nom
                                </label>
                                <input type="text" id="nom" wire:model="nom"
                                    class="form-group__input @error('nom') form-group__input--error @enderror">
                                @error('nom')
                                    <span class="form-group__error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="candidate-register__form-row candidate-register__form-row--two-cols">
                            <!-- Prénom -->
                            <div class="form-group">
                                <label for="prenom" class="form-group__label form-group__label--required">
                                    Prénom
                                </label>
                                <input type="text" id="prenom" wire:model="prenom"
                                    class="form-group__input @error('prenom') form-group__input--error @enderror">
                                @error('prenom')
                                    <span class="form-group__error">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="form-group__label form-group__label--required">
                                    Email
                                </label>
                                <input type="email" id="email" wire:model="email"
                                    class="form-group__input @error('email') form-group__input--error @enderror">
                                @error('email')
                                    <span class="form-group__error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="candidate-register__form-row candidate-register__form-row--two-cols">
                            <!-- ...rien, suppression des champs mot de passe... -->
                        </div>

                        <!-- Photo utilisateur -->
                        <!-- Photo de profil (optionnelle) conservée -->
                        <div class="form-group">
                            <label for="photoUtilisateur" class="form-group__label">
                                Photo de profil (optionnelle)
                            </label>
                            <input type="file" id="photoUtilisateur" wire:model="photoUtilisateur"
                                accept="image/jpeg,image/png" class="form-group__file">
                            @error('photoUtilisateur')
                                <span class="form-group__error">{{ $message }}</span>
                            @enderror

                            @if ($photoUtilisateur)
                                <div class="candidate-register__photo-preview">
                                    <img src="{{ $photoUtilisateur->temporaryUrl() }}" alt="Aperçu"
                                        class="candidate-register__photo-preview-img">
                                </div>
                            @endif

                            <div wire:loading wire:target="photoUtilisateur" class="candidate-register__file-info">
                                ⏳ Téléchargement en cours...
                            </div>
                        </div>
                    </div>
                @endguest

                <!-- Section candidature -->
                <div class="candidate-register__section">
                    <h2 class="candidate-register__section-title">Informations de candidature</h2>

                    <!-- Photo officielle -->
                    <div class="form-group">
                        <label for="photoOfficielle" class="form-group__label">
                            Photo officielle (optionnelle)
                        </label>
                        <input type="file" id="photoOfficielle" wire:model="photoOfficielle"
                            accept="image/jpeg,image/png" class="form-group__file" disabled>
                        <p class="form-group__help">À renseigner sur le dashboard candidat après acceptation.</p>
                    </div>

                    <!-- Programme PDF -->
                    <div class="form-group">
                        <label for="programme" class="form-group__label">
                            Programme (PDF, optionnel)
                        </label>
                        <input type="file" id="programme" wire:model="programme" accept="application/pdf"
                            class="form-group__file" disabled>
                        <p class="form-group__help">À renseigner sur le dashboard candidat après acceptation.</p>
                    </div>

                    <!-- Vision -->
                    <div class="form-group">
                        <label for="vision" class="form-group__label form-group__label--required">
                            Votre vision
                        </label>
                        <textarea id="vision" wire:model="vision" rows="6"
                            class="form-group__textarea @error('vision') form-group__textarea--error @enderror"
                            placeholder="Décrivez votre vision pour le Club Informatique U-Auben (1-2000 caractères)"></textarea>
                        @error('vision')
                            <span class="form-group__error">{{ $message }}</span>
                        @enderror
                        @if ($vision)
                            <p
                                class="candidate-register__char-count {{ strlen($vision) > 1800 ? 'candidate-register__char-count--warning' : '' }} {{ strlen($vision) > 2000 ? 'candidate-register__char-count--error' : '' }}">
                                {{ strlen($vision) }} / 2000 caractères
                            </p>
                        @endif
                    </div>

                    <!-- Motivations -->
                    <div class="form-group">
                        <label for="motivations" class="form-group__label form-group__label--required">
                            Vos motivations
                        </label>
                        <textarea id="motivations" wire:model="motivations" rows="4"
                            class="form-group__textarea @error('motivations') form-group__textarea--error @enderror"
                            placeholder="Expliquez vos motivations (1-1000 caractères)"></textarea>
                        @error('motivations')
                            <span class="form-group__error">{{ $message }}</span>
                        @enderror
                        @if ($motivations)
                            <p
                                class="candidate-register__char-count {{ strlen($motivations) > 900 ? 'candidate-register__char-count--warning' : '' }} {{ strlen($motivations) > 1000 ? 'candidate-register__char-count--error' : '' }}">
                                {{ strlen($motivations) }} / 1000 caractères
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Disclaimer -->
                <div class="candidate-register__disclaimer">
                    ℹ️ Votre candidature sera examinée par les administrateurs. Vous serez notifié par email une
                    fois
                    qu'elle sera validée ou rejetée.
                </div>

                <!-- Actions -->
                <div class="candidate-register__actions">
                    <button type="submit" class="btn btn--primary btn--lg" wire:loading.attr="disabled"
                        wire:target="submit,photoOfficielle,programme,photoUtilisateur">
                        <span wire:loading.remove wire:target="submit">Soumettre ma candidature</span>
                        <span wire:loading wire:target="submit">
                            <span class="loading"></span> Envoi en cours...
                        </span>
                    </button>

                    <a href="{{ route('home') }}" class="btn btn--ghost btn--lg">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Loading overlay pour les uploads lourds -->
    <div wire:loading wire:target="submit" class="candidate-register__loading">
        <div class="candidate-register__loading-content">
            <div class="candidate-register__loading-spinner">
                <div class="loading loading--lg"></div>
            </div>
            <p class="candidate-register__loading-text">Traitement de votre candidature en cours...</p>
        </div>
    </div>
</div>
