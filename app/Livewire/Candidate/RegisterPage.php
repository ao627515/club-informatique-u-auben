<?php

namespace App\Livewire\Candidate;

use App\Data\CandidateData;
use App\Models\User;
use App\Services\CandidateService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegisterPage extends Component
{
    use WithFileUploads;

    // Champs utilisateur
    public $matricule;

    public $nom;

    public $prenom;

    public $email;

    public $password;

    public $password_confirmation;

    public $photoUtilisateur;

    // Champs candidature
    public $photoOfficielle;

    public $programme;

    public $vision;

    public $motivations;

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
     * Règles de validation
     */
    protected function rules(): array
    {
        $rules = [
            // Photo officielle et programme deviennent optionnels
            'vision' => 'required|string|min:1|max:2000',
            'motivations' => 'required|string|min:1|max:1000',
        ];

        // Si l'utilisateur n'est pas authentifié, ajouter les règles d'inscription
        if (! Auth::check()) {
            $rules = array_merge($rules, [
                'matricule' => 'required|string|max:50|unique:users,matricule',
                'nom' => 'required|string|max:100',
                'prenom' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
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
            // Suppression des messages liés au mot de passe
            'photoUtilisateur.image' => 'Le fichier doit être une image.',
            'photoUtilisateur.mimes' => 'La photo doit être au format JPEG ou PNG.',
            'photoUtilisateur.max' => 'La photo ne doit pas dépasser 2 Mo.',
            'photoOfficielle.required' => 'La photo officielle est obligatoire.',
            'photoOfficielle.image' => 'Le fichier doit être une image.',
            'photoOfficielle.mimes' => 'La photo doit être au format JPEG ou PNG.',
            'photoOfficielle.max' => 'La photo ne doit pas dépasser 2 Mo.',
            'programme.required' => 'Le programme est obligatoire.',
            'programme.file' => 'Le fichier doit être un document.',
            'programme.mimes' => 'Le programme doit être au format PDF.',
            'programme.max' => 'Le programme ne doit pas dépasser 5 Mo.',
            'vision.required' => 'La vision est obligatoire.',
            'vision.min' => 'La vision doit contenir au moins 1 caractère.',
            'vision.max' => 'La vision ne doit pas dépasser 2000 caractères.',
            'motivations.required' => 'Les motivations sont obligatoires.',
            'motivations.min' => 'Les motivations doivent contenir au moins 1 caractère.',
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
            DB::transaction(function () use ($candidateService) {
                $user = Auth::user();

                // Si l'utilisateur n'est pas authentifié, créer le compte sans mot de passe
                if (! $user) {
                    $user = User::create([
                        'matricule' => $this->matricule,
                        'nom' => $this->nom,
                        'prenom' => $this->prenom,
                        'email' => $this->email,
                        'photo_path' => $this->photoUtilisateur ? $this->photoUtilisateur->store('photos', 'public') : null,
                        'email_verified_at' => now(),
                    ]);

                    // Assigner le rôle user
                    $user->assignRole('user');

                    // Connecter l'utilisateur
                    Auth::login($user);
                }

                // Créer la candidature sans photo officielle ni programme
                $candidateData = new CandidateData(
                    userId: $user->id,
                    photoOfficielle: null,
                    programme: null,
                    vision: $this->vision,
                    motivations: $this->motivations
                );

                $candidateService->createCandidate($candidateData, $user);

                session()->flash('success', 'Votre candidature a été soumise avec succès ! Elle sera examinée par un administrateur. Vous recevrez un mot de passe par email si votre candidature est retenue.');

                $this->redirect(route('candidate.dashboard'), navigate: true);
            });
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.candidate.register-page');
    }
}
