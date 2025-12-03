@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/candidate-dashboard.css') }}">
@endpush

<div class="candidate-dashboard">
    <div class="candidate-dashboard__container">
        <div class="candidate-dashboard__header">
            <h1 class="candidate-dashboard__title">Mon Dashboard</h1>
            <p class="candidate-dashboard__subtitle">Gérez votre candidature et consultez son statut</p>
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

        <!-- Status Card -->
        <div class="candidate-dashboard__status-card candidate-dashboard__status-card--{{ $candidate->status }}">
            <div class="candidate-dashboard__status-header">
                <div
                    class="candidate-dashboard__status-icon candidate-dashboard__status-icon--{{ $candidate->status }}">
                    @if ($candidate->status === 'pending')
                        ⏳
                    @elseif($candidate->status === 'approved')
                        ✅
                    @else
                        ❌
                    @endif
                </div>
                <div class="candidate-dashboard__status-text">
                    <h2 class="candidate-dashboard__status-title">
                        @if ($candidate->status === 'pending')
                            Candidature en cours de validation
                        @elseif($candidate->status === 'approved')
                            Candidature validée
                        @else
                            Candidature rejetée
                        @endif
                    </h2>
                    <p class="candidate-dashboard__status-description">
                        @if ($candidate->status === 'pending')
                            Votre candidature est en cours d'examen par les administrateurs.
                        @elseif($candidate->status === 'approved')
                            Félicitations ! Votre candidature a été approuvée.
                        @else
                            Votre candidature n'a pas été retenue.
                        @endif
                    </p>
                </div>
            </div>

            @if ($candidate->status === 'rejected' && $candidate->rejection_reason)
                <div class="candidate-dashboard__rejection-reason">
                    <p class="candidate-dashboard__rejection-title">Raison du rejet :</p>
                    <p class="candidate-dashboard__rejection-text">{{ $candidate->rejection_reason }}</p>
                </div>
            @endif
        </div>

        <!-- Profile Grid -->
        <div class="candidate-dashboard__grid">
            <!-- Profile Section -->
            <div class="candidate-dashboard__profile-card">
                <div class="candidate-dashboard__profile-header">
                    <h2 class="candidate-dashboard__profile-title">Mon Profil</h2>
                    <div class="candidate-dashboard__profile-actions">
                        @if (!$isEditing)
                            <button wire:click="edit" class="btn btn--sm btn--secondary">
                                ✏️ Modifier
                            </button>
                        @endif
                    </div>
                </div>

                @if ($isEditing)
                    <form wire:submit="save">
                        <div class="form-group">
                            <label class="form-group__label form-group__label--required">Vision</label>
                            <textarea wire:model="vision" rows="6"
                                class="form-group__textarea @error('vision') form-group__textarea--error @enderror"
                                placeholder="Décrivez votre vision (100-2000 caractères)"></textarea>
                            @error('vision')
                                <span class="form-group__error">{{ $message }}</span>
                            @enderror
                            @if ($vision)
                                <p class="candidate-register__char-count">{{ strlen($vision) }} / 2000 caractères</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="form-group__label form-group__label--required">Motivations</label>
                            <textarea wire:model="motivations" rows="4"
                                class="form-group__textarea @error('motivations') form-group__textarea--error @enderror"
                                placeholder="Expliquez vos motivations (50-1000 caractères)"></textarea>
                            @error('motivations')
                                <span class="form-group__error">{{ $message }}</span>
                            @enderror
                            @if ($motivations)
                                <p class="candidate-register__char-count">{{ strlen($motivations) }} / 1000 caractères
                                </p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="form-group__label">Remplacer la photo officielle</label>
                            <input type="file" wire:model="photoOfficielle" accept="image/jpeg,image/png"
                                class="form-group__file">
                            @error('photoOfficielle')
                                <span class="form-group__error">{{ $message }}</span>
                            @enderror
                            <div wire:loading wire:target="photoOfficielle" class="form-group__help">
                                ⏳ Téléchargement en cours...
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-group__label">Remplacer le programme (PDF)</label>
                            <input type="file" wire:model="programme" accept="application/pdf"
                                class="form-group__file">
                            @error('programme')
                                <span class="form-group__error">{{ $message }}</span>
                            @enderror
                            <div wire:loading wire:target="programme" class="form-group__help">
                                ⏳ Téléchargement en cours...
                            </div>
                        </div>

                        <div class="candidate-dashboard__edit-actions">
                            <button type="submit" class="btn btn--primary" wire:loading.attr="disabled"
                                wire:target="save,photoOfficielle,programme">
                                <span wire:loading.remove wire:target="save">💾 Sauvegarder</span>
                                <span wire:loading wire:target="save">
                                    <span class="loading"></span> Sauvegarde...
                                </span>
                            </button>
                            <button type="button" wire:click="cancelEdit" class="btn btn--ghost">
                                Annuler
                            </button>
                        </div>
                    </form>
                @else
                    <div class="candidate-dashboard__field">
                        <label class="candidate-dashboard__field-label">Vision</label>
                        <p class="candidate-dashboard__field-value">{{ $candidate->vision }}</p>
                    </div>

                    <div class="candidate-dashboard__field">
                        <label class="candidate-dashboard__field-label">Motivations</label>
                        <p class="candidate-dashboard__field-value">{{ $candidate->motivations }}</p>
                    </div>
                @endif
            </div>

            <!-- Documents Section -->
            <div class="candidate-dashboard__documents">
                <h2 class="candidate-dashboard__documents-title">Mes Documents</h2>

                <div class="candidate-dashboard__document-item">
                    <div class="candidate-dashboard__document-header">
                        <span class="candidate-dashboard__document-name">📸 Photo officielle</span>
                    </div>
                    @if ($candidate->photo_officielle_path)
                        <div class="candidate-dashboard__document-preview">
                            <img src="{{ Storage::url($candidate->photo_officielle_path) }}" alt="Photo officielle"
                                class="candidate-dashboard__document-image">
                        </div>
                    @else
                        <p class="candidate-dashboard__field-value--empty">Aucune photo</p>
                    @endif
                </div>

                <div class="candidate-dashboard__document-item">
                    <div class="candidate-dashboard__document-header">
                        <span class="candidate-dashboard__document-name">📄 Programme</span>
                        @if ($candidate->programme_path)
                            <a href="{{ Storage::url($candidate->programme_path) }}" target="_blank"
                                class="btn btn--sm btn--tertiary">
                                Télécharger
                            </a>
                        @endif
                    </div>
                    @if ($candidate->programme_path)
                        <p class="form-group__help">PDF disponible au téléchargement</p>
                    @else
                        <p class="candidate-dashboard__field-value--empty">Aucun programme</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
