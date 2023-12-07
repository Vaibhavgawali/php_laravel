<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin=Role::create(['name'=>'Admin']);
        $candidate=Role::create(['name'=>'Candidate']);
        $insurer=Role::create(['name'=>'Insurer']);
        $institute=Role::create(['name'=>'Institute']);

        $manage_users_permission = Permission::create(['name' => 'manage users']);
        $put_modules_permission = Permission::create(['name' => 'put modules']);

        $take_assessment_permission=Permission::create(['name'=>'take assessment']);
        $post_cv_permission=Permission::create(['name'=>'post cv']);
        $download_certificate_permission=Permission::create(['name'=>'download certificate']);

        $put_req_permission=Permission::create(['name'=>'put requirement']);
        $view_details_permission=Permission::create(['name'=>'view details']);
        $view_and_download_cv_permission=Permission::create(['name'=>'view and download cv']);

        $admin_permissions=[
            $manage_users_permission,
            $put_modules_permission
        ];

        $candidate_permissions=[
            $take_assessment_permission,
            $post_cv_permission,
            $download_certificate_permission
        ];
        
        $insurer_permissions=[
            $put_req_permission,
            $view_details_permission,
            $view_and_download_cv_permission
        ];

        $institute_permissions=[
            $put_req_permission
        ];

        $admin->syncPermissions($admin_permissions);
        $candidate->syncPermissions($candidate_permissions);
        $insurer->syncPermissions($insurer_permissions);
        $institute->syncPermissions($institute_permissions);

        // $view_and_download_cv_permission=Permission::create(['name'=>'view and download cv']);
        // $role = Role::findByName('insurer');
        // $role->givePermissionTo($view_and_download_cv_permission);

    }
}
