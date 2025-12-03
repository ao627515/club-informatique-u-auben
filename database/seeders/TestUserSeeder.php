<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Créer des utilisateurs de test
     */
    public function run(): void
    {
        // Utilisateur simple pour tester la soumission de candidature
        $user = User::create([
            'matricule' => 'TEST001',
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole('user');

        // Candidat pour tester le dashboard candidat
        $candidateUser = User::create([
            'matricule' => 'TEST002',
            'nom' => 'Martin',
            'prenom' => 'Marie',
            'email' => 'candidate@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $candidateUser->assignRole(['user', 'candidate']);
    }
}
