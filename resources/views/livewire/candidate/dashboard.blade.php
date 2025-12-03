<div class="candidate-dashboard">
    <div class="candidate-dashboard__container">
        <h1>Dashboard Candidat</h1>

        @if (session()->has('success'))
            <div class="alert alert--success">{{ session('success') }}</div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert--error">{{ session('error') }}</div>
        @endif

        <!-- Statut -->
        <div class="status-card status-card--{{ $candidate->status }}">
            <h2>
                @if ($candidate->status === 'pending')
                    ⏳ Candidature en cours de validation
                @elseif($candidate->status === 'approved')
                    ✅ Candidature validée
                @else
                    ❌ Candidature rejetée
                @endif
            </h2>
            @if ($candidate->status === 'rejected' && $candidate->rejection_reason)
                <p><strong>Raison :</strong> {{ $candidate->rejection_reason }}</p>
            @endif
        </div>

        <!-- Profil -->
        <div class="profile-section">
            <h2>Mon Profil</h2>
            @if (!$isEditing)
                <button wire:click="edit" class="btn btn--secondary">Modifier</button>
            @endif

            @if ($isEditing)
                <form wire:submit="save">
                    <div class="form-group">
                        <label>Vision</label>
                        <textarea wire:model="vision" rows="6"></textarea>
                        @error('vision')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Motivations</label>
                        <textarea wire:model="motivations" rows="4"></textarea>
                        @error('motivations')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Photo officielle</label>
                        <input type="file" wire:model="photoOfficielle" accept="image/*">
                        @error('photoOfficielle')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Programme</label>
                        <input type="file" wire:model="programme" accept="application/pdf">
                        @error('programme')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn--primary">Sauvegarder</button>
                    <button type="button" wire:click="cancelEdit" class="btn btn--secondary">Annuler</button>
                </form>
            @else
                <div class="profile-view">
                    <p><strong>Vision:</strong> {{ $candidate->vision }}</p>
                    <p><strong>Motivations:</strong> {{ $candidate->motivations }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
