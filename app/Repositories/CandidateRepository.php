<?php

namespace App\Repositories;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Collection;

class CandidateRepository
{
    /**
     * Créer un nouveau candidat
     */
    public function create(array $data): Candidate
    {
        return Candidate::create($data);
    }

    /**
     * Trouver un candidat par son ID
     */
    public function findById(int $id): ?Candidate
    {
        return Candidate::with('user')->find($id);
    }

    /**
     * Trouver un candidat par user_id
     */
    public function findByUserId(int $userId): ?Candidate
    {
        return Candidate::where('user_id', $userId)->first();
    }

    /**
     * Récupérer tous les candidats en attente
     */
    public function getPendingCandidates(): Collection
    {
        return Candidate::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Récupérer tous les candidats approuvés
     */
    public function getApprovedCandidates(): Collection
    {
        return Candidate::with('user')
            ->where('status', 'approved')
            ->orderBy('votes_count', 'desc')
            ->get();
    }

    /**
     * Mettre à jour un candidat
     */
    public function update(Candidate $candidate, array $data): bool
    {
        return $candidate->update($data);
    }

    /**
     * Valider une candidature
     */
    public function approve(Candidate $candidate, int $validatedBy): bool
    {
        return $candidate->update([
            'status' => 'approved',
            'validated_at' => now(),
            'validated_by' => $validatedBy,
            'rejection_reason' => null,
        ]);
    }

    /**
     * Rejeter une candidature
     */
    public function reject(Candidate $candidate, int $validatedBy, string $reason): bool
    {
        return $candidate->update([
            'status' => 'rejected',
            'validated_at' => now(),
            'validated_by' => $validatedBy,
            'rejection_reason' => $reason,
        ]);
    }

    /**
     * Incrémenter le nombre de votes
     */
    public function incrementVotesCount(Candidate $candidate): bool
    {
        return $candidate->increment('votes_count');
    }
}