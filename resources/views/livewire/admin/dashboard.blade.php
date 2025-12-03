<div class="admin-dashboard">
    <h1>Dashboard Administrateur</h1>

    @if (session()->has('success'))
        <div class="alert alert--success">{{ session('success') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert--error">{{ session('error') }}</div>
    @endif

    <h2>Candidatures en attente ({{ $pendingCandidates->count() }})</h2>

    @if($pendingCandidates->isEmpty())
        <p>Aucune candidature en attente.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nom complet</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingCandidates as $candidate)
                    <tr>
                        <td>{{ $candidate->user->prenom }} {{ $candidate->user->nom }}</td>
                        <td>{{ $candidate->user->email }}</td>
                        <td>{{ $candidate->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <button wire:click="approve({{ $candidate->id }})" wire:confirm="Valider cette candidature ?">
                                Valider
                            </button>
                            <button wire:click="openRejectModal({{ $candidate->id }})">
                                Rejeter
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($showRejectModal)
        <div class="modal" wire:click.self="closeRejectModal">
            <div class="modal__content">
                <h3>Rejeter la candidature</h3>
                <form wire:submit="reject">
                    <textarea wire:model="rejectionReason" rows="4" placeholder="Raison du rejet"></textarea>
                    @error('rejectionReason') <span>{{ $message }}</span> @enderror
                    <button type="submit">Confirmer</button>
                    <button type="button" wire:click="closeRejectModal">Annuler</button>
                </form>
            </div>
        </div>
    @endif
</div>
