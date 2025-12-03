<?php

namespace App\Livewire\Candidate;

use App\Models\Candidate;
use App\Repositories\CandidateRepository;
use App\Services\CandidateService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Dashboard extends Component
{
    use WithFileUploads;

    public Candidate $candidate;

    public $vision;

    public $motivations;

    public $photoOfficielle;

    public $programme;

    public $isEditing = false;

    public function mount(CandidateRepository $candidateRepository): void
    {
        // Récupérer la candidature de l'utilisateur
        $this->candidate = $candidateRepository->findByUserId(Auth::id());

        if (! $this->candidate) {
            $this->redirect(route('candidate.register'), navigate: true);
        }

        $this->vision = $this->candidate->vision;
        $this->motivations = $this->candidate->motivations;
    }

    /**
     * Activer le mode édition
     */
    public function edit(): void
    {
        $this->isEditing = true;
    }

    /**
     * Annuler l'édition
     */
    public function cancelEdit(): void
    {
        $this->isEditing = false;
        $this->vision = $this->candidate->vision;
        $this->motivations = $this->candidate->motivations;
        $this->photoOfficielle = null;
        $this->programme = null;
        $this->resetValidation();
    }

    /**
     * Règles de validation
     */
    protected function rules(): array
    {
        return [
            'vision' => 'required|string|min:100|max:2000',
            'motivations' => 'required|string|min:50|max:1000',
            'photoOfficielle' => 'nullable|image|mimes:jpeg,png|max:2048',
            'programme' => 'nullable|file|mimes:pdf|max:5120',
        ];
    }

    /**
     * Sauvegarder les modifications
     */
    public function save(CandidateService $candidateService): void
    {
        $this->validate();

        try {
            $data = [
                'vision' => $this->vision,
                'motivations' => $this->motivations,
            ];

            if ($this->photoOfficielle) {
                $data['photo_officielle'] = $this->photoOfficielle;
            }

            if ($this->programme) {
                $data['programme'] = $this->programme;
            }

            $candidateService->updateProfile($this->candidate, $data);

            $this->candidate->refresh();
            $this->isEditing = false;
            $this->photoOfficielle = null;
            $this->programme = null;

            session()->flash('success', 'Votre profil a été mis à jour avec succès !');
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors de la mise à jour de votre profil.');
        }
    }

    public function render()
    {
        return view('livewire.candidate.dashboard');
    }
}
