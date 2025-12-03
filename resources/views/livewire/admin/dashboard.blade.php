@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-dashboard.css') }}">
@endpush

<div class="admin-dashboard">
    <div class="admin-dashboard__container">
        <div class="admin-dashboard__header">
            <h1 class="admin-dashboard__title">Dashboard Administrateur</h1>
            <div class="admin-dashboard__actions">
                <span class="badge badge--info">
                    {{ $pendingCandidates->count() }} en attente
                </span>
            </div>
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

        <!-- Stats Cards -->
        <div class="admin-dashboard__stats">
            <div class="admin-dashboard__stat-card">
                <div class="admin-dashboard__stat-icon admin-dashboard__stat-icon--warning">
                    ⏳
                </div>
                <div class="admin-dashboard__stat-content">
                    <div class="admin-dashboard__stat-label">En attente</div>
                    <div class="admin-dashboard__stat-value">{{ $pendingCandidates->count() }}</div>
                </div>
            </div>

            <div class="admin-dashboard__stat-card">
                <div class="admin-dashboard__stat-icon admin-dashboard__stat-icon--success">
                    ✅
                </div>
                <div class="admin-dashboard__stat-content">
                    <div class="admin-dashboard__stat-label">Total candidatures</div>
                    <div class="admin-dashboard__stat-value">{{ $pendingCandidates->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Candidates Section -->
        <div class="admin-dashboard__candidates">
            <div class="admin-dashboard__candidates-header">
                <h2 class="admin-dashboard__candidates-title">Candidatures en attente</h2>
            </div>

            @if ($pendingCandidates->isEmpty())
                <div class="admin-dashboard__empty">
                    <div class="admin-dashboard__empty-icon">📭</div>
                    <h3 class="admin-dashboard__empty-title">Aucune candidature en attente</h3>
                    <p class="admin-dashboard__empty-text">
                        Toutes les candidatures ont été traitées. Revenez plus tard pour voir les nouvelles soumissions.
                    </p>
                </div>
            @else
                <div class="admin-dashboard__candidates-list">
                    @foreach ($pendingCandidates as $candidate)
                        <div class="admin-dashboard__candidate-card">
                            @if ($candidate->photo_officielle_path)
                                <img src="{{ Storage::url($candidate->photo_officielle_path) }}"
                                    alt="{{ $candidate->user->prenom }}" class="admin-dashboard__candidate-photo">
                            @else
                                <div class="admin-dashboard__candidate-photo"
                                    style="display: flex; align-items: center; justify-content: center; background: var(--color-bg-secondary); font-size: 2rem; font-weight: bold; color: var(--color-text-secondary);">
                                    {{ substr($candidate->user->prenom, 0, 1) }}{{ substr($candidate->user->nom, 0, 1) }}
                                </div>
                            @endif

                            <div class="admin-dashboard__candidate-info">
                                <h3 class="admin-dashboard__candidate-name">
                                    {{ $candidate->user->prenom }} {{ $candidate->user->nom }}
                                </h3>
                                <div class="admin-dashboard__candidate-email">
                                    📧 {{ $candidate->user->email }}
                                </div>
                                <div class="admin-dashboard__candidate-meta">
                                    <span class="badge badge--secondary">
                                        {{ $candidate->user->matricule }}
                                    </span>
                                    <span class="admin-dashboard__candidate-date">
                                        📅 {{ $candidate->created_at->format('d/m/Y à H:i') }}
                                    </span>
                                </div>

                                <!-- Vision preview -->
                                <div style="margin-top: var(--spacing-sm);">
                                    <p
                                        style="font-size: var(--font-size-small); color: var(--color-text-secondary); line-height: 1.5;">
                                        <strong>Vision:</strong> {{ Str::limit($candidate->vision, 150) }}
                                    </p>
                                </div>
                            </div>

                            <div class="admin-dashboard__candidate-actions">
                                @if ($candidate->programme_path)
                                    <a href="{{ Storage::url($candidate->programme_path) }}" target="_blank"
                                        class="btn btn--sm btn--tertiary">
                                        📄 Programme
                                    </a>
                                @endif

                                <button wire:click="approve({{ $candidate->id }})"
                                    wire:confirm="Êtes-vous sûr de vouloir valider cette candidature ?"
                                    class="btn btn--sm btn--primary">
                                    ✓ Valider
                                </button>

                                <button wire:click="openRejectModal({{ $candidate->id }})"
                                    class="btn btn--sm btn--outline">
                                    ✕ Rejeter
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
@if ($showRejectModal)
    <div class="admin-dashboard__reject-modal" wire:click.self="closeRejectModal">
        <div class="admin-dashboard__reject-content">
            <div class="admin-dashboard__reject-header">
                <h3 class="admin-dashboard__reject-title">Rejeter la candidature</h3>
            </div>

            <form wire:submit="reject">
                <div class="admin-dashboard__reject-body">
                    <div class="form-group">
                        <label class="form-group__label form-group__label--required">
                            Raison du rejet
                        </label>
                        <textarea wire:model="rejectionReason" rows="4"
                            class="form-group__textarea @error('rejectionReason') form-group__textarea--error @enderror"
                            placeholder="Expliquez la raison du rejet de manière claire et constructive..."></textarea>
                        @error('rejectionReason')
                            <span class="form-group__error">{{ $message }}</span>
                        @enderror
                        <p class="form-group__help">
                            Cette raison sera visible par le candidat.
                        </p>
                    </div>
                </div>

                <div class="admin-dashboard__reject-footer">
                    <button type="button" wire:click="closeRejectModal" class="btn btn--ghost">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn--primary" wire:loading.attr="disabled" wire:target="reject">
                        <span wire:loading.remove wire:target="reject">Confirmer le rejet</span>
                        <span wire:loading wire:target="reject">
                            <span class="loading"></span> En cours...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
