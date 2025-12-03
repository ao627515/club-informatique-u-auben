<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Créer le compte administrateur par défaut
     */
    public function run(): void
    {
        $admin = User::create([
            'matricule' => 'ADMIN001',
            'nom' => 'Admin',
            'prenom' => 'Système',
            'email' => 'admin@clubinfo-uan.bf',
            'password' => Hash::make('AdminUAN2025!'),
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('admin');
    }
}
