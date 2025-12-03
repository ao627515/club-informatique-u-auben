<?php

namespace App\Livewire\Candidate;

use App\Data\CandidateData;
use App\Services\CandidateService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegisterPage extends Component
{
    use WithFileUploads;

    public $photoOfficielle;
    public $programme;
    public $vision;
    public $motivations;

    public function mount(CandidateService $candidateService): void
    {
        // Vérifier que l'utilisateur est authentifié
        if (!Auth::check()) {
            abort(403, 'Vous devez être connecté pour accéder à cette page.');
        }

        // Vérifier si l'utilisateur a déjà une candidature
        if ($candidateService->userHasCandidate(Auth::id())) {
            $this->redirect(route('candidate.dashboard'), navigate: true);
        }

        // Vérifier si l'utilisateur a le rôle 'user'
        if (!Auth::user()->hasRole('user')) {
            abort(403, 'Seuls les utilisateurs peuvent soumettre une candidature.');
        }
    }

    /**
     * Règles de validation
     */
    protected function rules(): array
    {
        return [
            'photoOfficielle' => 'required|image|mimes:jpeg,png|max:2048',
            'programme' => 'required|file|mimes:pdf|max:5120',
            'vision' => 'required|string|min:100|max:2000',
            'motivations' => 'required|string|min:50|max:1000',
        ];
    }

    /**
     * Messages de validation personnalisés
     */
    protected function messages(): array
    {
        return [
            'photoOfficielle.required' => 'La photo officielle est obligatoire.',
            'photoOfficielle.image' => 'Le fichier doit être une image.',
            'photoOfficielle.mimes' => 'La photo doit être au format JPEG ou PNG.',
            'photoOfficielle.max' => 'La photo ne doit pas dépasser 2 Mo.',
            'programme.required' => 'Le programme est obligatoire.',
            'programme.file' => 'Le fichier doit être un document.',
            'programme.mimes' => 'Le programme doit être au format PDF.',
            'programme.max' => 'Le programme ne doit pas dépasser 5 Mo.',
            'vision.required' => 'La vision est obligatoire.',
            'vision.min' => 'La vision doit contenir au moins 100 caractères.',
            'vision.max' => 'La vision ne doit pas dépasser 2000 caractères.',
            'motivations.required' => 'Les motivations sont obligatoires.',
            'motivations.min' => 'Les motivations doivent contenir au moins 50 caractères.',
            'motivations.max' => 'Les motivations ne doivent pas dépasser 1000 caractères.',
        ];
    }

    /**
     * Soumettre la candidature
     */
    public function submit(CandidateService $candidateService): void
    {
        $this->validate();

        try {
            $candidateData = new CandidateData(
                userId: Auth::id(),
                photoOfficielle: $this->photoOfficielle,
                programme: $this->programme,
                vision: $this->vision,
                motivations: $this->motivations
            );

            $candidateService->createCandidate($candidateData, Auth::user());

            session()->flash('success', 'Votre candidature a été soumise avec succès ! Elle sera examinée par un administrateur.');

            $this->redirect(route('candidate.dashboard'), navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors de la soumission de votre candidature. Veuillez réessayer.');
        }
    }

    public function render()
    {
        return view('livewire.candidate.register-page');
    }
}
