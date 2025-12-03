<div class="candidate-registration">
    <div class="candidate-registration__container">
        <div class="candidate-registration__header">
            <h1 class="candidate-registration__title">Soumettre votre candidature</h1>
            <p class="candidate-registration__subtitle">
                Remplissez le formulaire ci-dessous pour soumettre votre candidature au Club Informatique UAN.
            </p>
        </div>

        @if (session()->has('success'))
            <div class="alert alert--success">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert--error">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit="submit" class="candidate-registration__form">
            <!-- Photo officielle -->
            <div class="form-group">
                <label for="photoOfficielle" class="form-group__label">
                    Photo officielle <span class="form-group__required">*</span>
                </label>
                <input type="file" id="photoOfficielle" wire:model="photoOfficielle" accept="image/jpeg,image/png"
                    class="form-group__input form-group__input--file">
                @error('photoOfficielle')
                    <span class="form-group__error">{{ $message }}</span>
                @enderror
                <p class="form-group__hint">Format: JPEG ou PNG, Max: 2 Mo</p>

                @if ($photoOfficielle)
                    <div class="form-group__preview">
                        <img src="{{ $photoOfficielle->temporaryUrl() }}" alt="Aperçu photo"
                            class="form-group__preview-image">
                    </div>
                @endif

                <div wire:loading wire:target="photoOfficielle" class="form-group__loading">
                    Téléchargement en cours...
                </div>
            </div>

            <!-- Programme PDF -->
            <div class="form-group">
                <label for="programme" class="form-group__label">
                    Programme (PDF) <span class="form-group__required">*</span>
                </label>
                <input type="file" id="programme" wire:model="programme" accept="application/pdf"
                    class="form-group__input form-group__input--file">
                @error('programme')
                    <span class="form-group__error">{{ $message }}</span>
                @enderror
                <p class="form-group__hint">Format: PDF, Max: 5 Mo</p>

                @if ($programme)
                    <p class="form-group__file-name">{{ $programme->getClientOriginalName() }}</p>
                @endif

                <div wire:loading wire:target="programme" class="form-group__loading">
                    Téléchargement en cours...
                </div>
            </div>

            <!-- Vision -->
            <div class="form-group">
                <label for="vision" class="form-group__label">
                    Votre vision <span class="form-group__required">*</span>
                </label>
                <textarea id="vision" wire:model="vision" rows="6" class="form-group__textarea"
                    placeholder="Décrivez votre vision pour le Club Informatique UAN (100-2000 caractères)"></textarea>
                @error('vision')
                    <span class="form-group__error">{{ $message }}</span>
                @enderror
                @if ($vision)
                    <p class="form-group__counter">{{ strlen($vision) }} / 2000 caractères</p>
                @endif
            </div>

            <!-- Motivations -->
            <div class="form-group">
                <label for="motivations" class="form-group__label">
                    Vos motivations <span class="form-group__required">*</span>
                </label>
                <textarea id="motivations" wire:model="motivations" rows="4" class="form-group__textarea"
                    placeholder="Expliquez vos motivations (50-1000 caractères)"></textarea>
                @error('motivations')
                    <span class="form-group__error">{{ $message }}</span>
                @enderror
                @if ($motivations)
                    <p class="form-group__counter">{{ strlen($motivations) }} / 1000 caractères</p>
                @endif
            </div>

            <!-- Boutons d'action -->
            <div class="candidate-registration__actions">
                <button type="submit" class="btn btn--primary" wire:loading.attr="disabled" wire:target="submit">
                    <span wire:loading.remove wire:target="submit">Soumettre ma candidature</span>
                    <span wire:loading wire:target="submit">Envoi en cours...</span>
                </button>

                <a href="{{ route('home') }}" class="btn btn--secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
