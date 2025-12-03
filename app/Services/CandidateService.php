<?php

namespace App\Services;

use App\Data\CandidateData;
use App\Models\Candidate;
use App\Models\User;
use App\Repositories\CandidateRepository;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class CandidateService
{
  public function __construct(
    public CandidateRepository $candidateRepository
  ) {}

  /**
   * Créer une nouvelle candidature
   *
   * @throws FileDoesNotExist
   * @throws FileIsTooBig
   */
  public function createCandidate(CandidateData $data, User $user): Candidate
  {
    return DB::transaction(function () use ($data, $user) {
      $candidate = $this->candidateRepository->create([
        'user_id' => $data->userId,
        'photo_officielle_path' => '',
        'programme_path' => '',
        'vision' => $data->vision,
        'motivations' => $data->motivations,
        'status' => 'pending',
      ]);

      $candidate->addMedia($data->photoOfficielle)
        ->toMediaCollection('photo_officielle');

      $candidate->addMedia($data->programme)
        ->toMediaCollection('programme');

      $candidate->update([
        'photo_officielle_path' => $candidate->getFirstMediaPath('photo_officielle'),
        'programme_path' => $candidate->getFirstMediaPath('programme'),
      ]);

      activity()
        ->causedBy($user)
        ->performedOn($candidate)
        ->log('Candidature soumise');

      return $candidate->fresh();
    });
  }

  /**
   * Valider une candidature et assigner le rôle candidate
   */
  public function approveCandidate(Candidate $candidate, User $admin): bool
  {
    return DB::transaction(function () use ($candidate, $admin) {
      $approved = $this->candidateRepository->approve($candidate, $admin->id);

      if ($approved) {
        $candidate->user->assignRole('candidate');

        activity()
          ->causedBy($admin)
          ->performedOn($candidate)
          ->log('Candidature validée');
      }

      return $approved;
    });
  }

  /**
   * Rejeter une candidature
   */
  public function rejectCandidate(Candidate $candidate, User $admin, string $reason): bool
  {
    $rejected = $this->candidateRepository->reject($candidate, $admin->id, $reason);

    if ($rejected) {
      activity()
        ->causedBy($admin)
        ->performedOn($candidate)
        ->withProperties(['reason' => $reason])
        ->log('Candidature rejetée');
    }

    return $rejected;
  }

  /**
   * Mettre à jour le profil d'un candidat
   *
   * @throws FileDoesNotExist
   * @throws FileIsTooBig
   */
  public function updateProfile(Candidate $candidate, array $data): bool
  {
    return DB::transaction(function () use ($candidate, $data) {
      $updateData = [];
      if (isset($data['vision'])) {
        $updateData['vision'] = $data['vision'];
      }
      if (isset($data['motivations'])) {
        $updateData['motivations'] = $data['motivations'];
      }

      if (isset($data['photo_officielle'])) {
        $candidate->clearMediaCollection('photo_officielle');
        $candidate->addMedia($data['photo_officielle'])
          ->toMediaCollection('photo_officielle');
        $updateData['photo_officielle_path'] = $candidate->getFirstMediaPath('photo_officielle');
      }

      if (isset($data['programme'])) {
        $candidate->clearMediaCollection('programme');
        $candidate->addMedia($data['programme'])
          ->toMediaCollection('programme');
        $updateData['programme_path'] = $candidate->getFirstMediaPath('programme');
      }

      $updated = $this->candidateRepository->update($candidate, $updateData);

      if ($updated) {
        activity()
          ->causedBy($candidate->user)
          ->performedOn($candidate)
          ->log('Profil candidat mis à jour');
      }

      return $updated;
    });
  }

  /**
   * Vérifier si un utilisateur a déjà une candidature
   */
  public function userHasCandidate(int $userId): bool
  {
    return $this->candidateRepository->findByUserId($userId) !== null;
  }
}
