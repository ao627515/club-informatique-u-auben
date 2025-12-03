<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Créer les rôles et permissions du système
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer les permissions pour les visiteurs
        $visitorPermissions = [
            Permission::create(['name' => 'view_public_pages']),
            Permission::create(['name' => 'view_candidates_list']),
            Permission::create(['name' => 'view_candidate_profile']),
        ];

        // Créer les permissions pour les utilisateurs
        $userPermissions = [
            Permission::create(['name' => 'vote']),
            Permission::create(['name' => 'participate_activities']),
            Permission::create(['name' => 'update_own_profile']),
            Permission::create(['name' => 'view_vote_results_after_period']),
        ];

        // Créer les permissions pour les candidats
        $candidatePermissions = [
            Permission::create(['name' => 'candidate.view_dashboard']),
            Permission::create(['name' => 'candidate.update_profile']),
            Permission::create(['name' => 'candidate.view_application_status']),
            Permission::create(['name' => 'candidate.upload_documents']),
        ];

        // Créer les permissions pour les admins
        $adminPermissions = [
            Permission::create(['name' => 'manage_users']),
            Permission::create(['name' => 'manage_candidates']),
            Permission::create(['name' => 'manage_votes']),
            Permission::create(['name' => 'manage_activities']),
            Permission::create(['name' => 'manage_mandates']),
            Permission::create(['name' => 'manage_roles']),
            Permission::create(['name' => 'view_activity_logs']),
            Permission::create(['name' => 'access_admin_dashboard']),
        ];

        // Créer le rôle User avec ses permissions
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([...$visitorPermissions, ...$userPermissions]);

        // Créer le rôle Candidate avec ses permissions
        $candidateRole = Role::create(['name' => 'candidate']);
        $candidateRole->givePermissionTo([...$visitorPermissions, ...$userPermissions, ...$candidatePermissions]);

        // Créer le rôle Admin avec toutes les permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([...$visitorPermissions, ...$userPermissions, ...$candidatePermissions, ...$adminPermissions]);
    }
}
