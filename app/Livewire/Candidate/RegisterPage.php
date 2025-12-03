<?php

namespace App\Livewire\Candidate;

use App\Data\CandidateData;
use App\Models\User;
use App\Services\CandidateService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegisterPage extends Component
{
    use WithFileUploads;

    // Stepper state
    public $currentStep = 1;

    // Champs utilisateur
    public $matricule;

    public $nom;

    public $prenom;

    public $email;

    public $telephone;

    public $password;

    public $password_confirmation;

    public $photoUtilisateur;

    // Champs candidature
    public $photoOfficielle;

    public $programme;

    public $vision;

    public function mount(CandidateService $candidateService): void
    {
        // Si l'utilisateur est déjà authentifié
        if (Auth::check()) {
            // Vérifier s'il a déjà une candidature
            if ($candidateService->userHasCandidate(Auth::id())) {
                $this->redirect(route('candidate.dashboard'), navigate: true);
            }

            // Si authentifié mais pas de candidature, il peut continuer
            // (on cachera les champs d'inscription dans la vue)
        }
    }

    /**
     * Validation d'une étape spécifique
     */
    public function validateStep(int $step): bool
    {
        try {
            // Étape 1 : Identité (pour les guests uniquement)
            if ($step === 1 && ! Auth::check()) {
                $this->validate([
                    'matricule' => 'required|string|max:50|unique:users,matricule',
                    'nom' => 'required|string|max:100',
                    'prenom' => 'required|string|max:100',
                    'email' => 'required|email|unique:users,email',
                    'telephone' => 'required|string|max:20',
                    'photoUtilisateur' => 'nullable|image|mimes:jpeg,png|max:2048',
                ]);
            }

            // Étape 2 : Candidature
            if ($step === 2) {
                $this->validate([
                    'vision' => 'required|string|min:1|max:2000',
                ]);
            }

            return true;
        } catch (\Illuminate\Validation\ValidationException $e) {
            return false;
        }
    }

    /**
     * Vérifie si on peut aller à une étape donnée
     */
    public function canGoToStep(int $targetStep): bool
    {
        // Peut toujours revenir en arrière
        if ($targetStep <= $this->currentStep) {
            return true;
        }

        // Pour aller en avant, toutes les étapes précédentes doivent être validées
        for ($i = 1; $i < $targetStep; $i++) {
            if (! $this->validateStep($i)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Aller à une étape donnée
     */
    public function goToStep(int $step): void
    {
        if ($step < 1 || $step > 3) {
            return;
        }

        // Si on essaie d'aller en avant, valider l'étape actuelle
        if ($step > $this->currentStep && ! $this->canGoToStep($step)) {
            session()->flash('error', 'Veuillez compléter les étapes précédentes avant de continuer.');

            return;
        }

        $this->currentStep = $step;
    }

    /**
     * Aller à l'étape suivante
     */
    public function nextStep(): void
    {
        if ($this->validateStep($this->currentStep)) {
            $this->goToStep($this->currentStep + 1);
        }
    }

    /**
     * Revenir à l'étape précédente
     */
    public function previousStep(): void
    {
        $this->goToStep($this->currentStep - 1);
    }

    /**
     * Règles de validation
     */
    protected function rules(): array
    {
        $rules = [
            // Photo officielle et programme optionnels
            'vision' => 'required|string|min:1|max:2000',
        ];

        // Si l'utilisateur n'est pas authentifié, ajouter les règles d'inscription
        if (! Auth::check()) {
            $rules = array_merge($rules, [
                'matricule' => 'required|string|max:50|unique:users,matricule',
                'nom' => 'required|string|max:100',
                'prenom' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'telephone' => 'required|string|max:20',
                'photoUtilisateur' => 'nullable|image|mimes:jpeg,png|max:2048',
            ]);
        }

        return $rules;
    }

    /**
     * Messages de validation personnalisés
     */
    protected function messages(): array
    {
        return [
            'matricule.required' => 'Le matricule est obligatoire.',
            'matricule.unique' => 'Ce matricule est déjà utilisé.',
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => "L'email est obligatoire.",
            'email.email' => "L'email doit être une adresse valide.",
            'email.unique' => 'Cet email est déjà utilisé.',
            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'telephone.max' => 'Le numéro de téléphone ne doit pas dépasser 20 caractères.',
            'photoUtilisateur.image' => 'Le fichier doit être une image.',
            'photoUtilisateur.mimes' => 'La photo doit être au format JPEG ou PNG.',
            'photoUtilisateur.max' => 'La photo ne doit pas dépasser 2 Mo.',
            'photoOfficielle.image' => 'Le fichier doit être une image.',
            'photoOfficielle.mimes' => 'La photo doit être au format JPEG ou PNG.',
            'photoOfficielle.max' => 'La photo ne doit pas dépasser 2 Mo.',
            'programme.file' => 'Le fichier doit être un document.',
            'programme.mimes' => 'Le programme doit être au format PDF.',
            'programme.max' => 'Le programme ne doit pas dépasser 5 Mo.',
            'vision.required' => 'La vision est obligatoire.',
            'vision.min' => 'La vision doit contenir au moins 1 caractère.',
            'vision.max' => 'La vision ne doit pas dépasser 2000 caractères.',
        ];
    }

    /**
     * Soumettre la candidature
     */
    public function submit(CandidateService $candidateService): void
    {
        // Vérifier qu'on est bien à la dernière étape
        if ($this->currentStep !== 3) {
            session()->flash('error', 'Veuillez compléter toutes les étapes avant de soumettre.');

            return;
        }

        // Valider toutes les étapes
        if (! $this->validateStep(1) || ! $this->validateStep(2)) {
            session()->flash('error', 'Veuillez compléter toutes les étapes avant de soumettre.');

            return;
        }

        $this->validate();

        try {
            DB::transaction(function () use ($candidateService) {
                $user = Auth::user();

                // Si l'utilisateur n'est pas authentifié, créer le compte sans mot de passe
                if (! $user) {
                    $user = User::create([
                        'matricule' => $this->matricule,
                        'nom' => $this->nom,
                        'prenom' => $this->prenom,
                        'email' => $this->email,
                        'telephone' => $this->telephone,
                        'photo_path' => $this->photoUtilisateur ? $this->photoUtilisateur->store('photos', 'public') : null,
                        'email_verified_at' => now(),
                    ]);

                    // Assigner le rôle user
                    $user->assignRole('user');

                    // Connecter l'utilisateur
                    // Auth::login($user);
                }

                // Créer la candidature sans photo officielle ni programme
                $candidateData = new CandidateData(
                    userId: $user->id,
                    photoOfficielle: null,
                    programme: null,
                    vision: $this->vision,
                );

                $candidateService->createCandidate($candidateData, $user);
            });

            session()->flash('success', 'Votre candidature a été soumise avec succès ! Votre dossier est en cours de traitement par un administrateur.');
            $this->reset();
            $this->currentStep = 1;
            // On reste sur la même page, pas de redirection
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.candidate.register-page');
    }
}
