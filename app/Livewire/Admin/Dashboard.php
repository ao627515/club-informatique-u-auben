<?php

namespace App\Livewire\Admin;

use App\Models\Candidate;
use App\Repositories\CandidateRepository;
use App\Services\CandidateService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $pendingCandidates;

    public $selectedCandidate;

    public $rejectionReason = '';

    public $showRejectModal = false;

    public function mount(CandidateRepository $candidateRepository): void
    {
        $this->loadPendingCandidates($candidateRepository);
    }

    /**
     * Charger les candidatures en attente
     */
    public function loadPendingCandidates(CandidateRepository $candidateRepository): void
    {
        $this->pendingCandidates = $candidateRepository->getPendingCandidates();
    }

    /**
     * Approuver une candidature
     */
    public function approve(int $candidateId, CandidateService $candidateService, CandidateRepository $candidateRepository): void
    {
        $candidate = Candidate::find($candidateId);

        if (! $candidate) {
            session()->flash('error', 'Candidature introuvable.');

            return;
        }

        $candidateService->approveCandidate($candidate, Auth::user());

        session()->flash('success', 'Candidature validée avec succès ! Le rôle "candidate" a été assigné.');

        $this->loadPendingCandidates($candidateRepository);
    }

    /**
     * Ouvrir le modal de rejet
     */
    public function openRejectModal(int $candidateId): void
    {
        $this->selectedCandidate = $candidateId;
        $this->showRejectModal = true;
        $this->rejectionReason = '';
    }

    /**
     * Fermer le modal de rejet
     */
    public function closeRejectModal(): void
    {
        $this->showRejectModal = false;
        $this->selectedCandidate = null;
        $this->rejectionReason = '';
    }

    /**
     * Rejeter une candidature
     */
    public function reject(CandidateService $candidateService, CandidateRepository $candidateRepository): void
    {
        $this->validate([
            'rejectionReason' => 'required|string|min:10|max:500',
        ], [
            'rejectionReason.required' => 'La raison du rejet est obligatoire.',
            'rejectionReason.min' => 'La raison doit contenir au moins 10 caractères.',
            'rejectionReason.max' => 'La raison ne doit pas dépasser 500 caractères.',
        ]);

        $candidate = Candidate::find($this->selectedCandidate);

        if (! $candidate) {
            session()->flash('error', 'Candidature introuvable.');

            return;
        }

        $candidateService->rejectCandidate($candidate, Auth::user(), $this->rejectionReason);

        session()->flash('success', 'Candidature rejetée.');

        $this->closeRejectModal();
        $this->loadPendingCandidates($candidateRepository);
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
