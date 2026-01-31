<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // Teacher permissions
            'view_your_class',
            'view_any_fee::student',
            'view_any_allowance::report',
            'view_any_memo',

            // Client permissions
            'view_any_my_clients',
            'view_teacher_class',
            'view_monthly_fee',
            'view_any_transaction',

            // Admin permissions
            'view_any_overdue::fee',
            'view_any_add_class',
            'view_any_calculator_fee',
            'view_any_record_student',
            'view_any_student_info',
            'view_any_users',
            'view_any_class_names',
            'view_any_class_packages',
            'view_any_fee_rates',
            'view_any_assign_class_teachers',
            'view_any_report_classes',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        // Admin (Role 1) - Full access
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(Permission::all());
        }

        // Teacher (Role 2)
        $teacherRole = Role::where('name', 'teacher')->first();
        if ($teacherRole) {
            $teacherRole->givePermissionTo([
                'view_your_class',
                'view_any_fee::student',
                'view_any_allowance::report',
                'view_any_memo',
            ]);
        }

        // Client/Registrar (Role 4)
        $clientRole = Role::where('name', 'client')->first();
        if ($clientRole) {
            $clientRole->givePermissionTo([
                'view_any_my_clients',
                'view_teacher_class',
                'view_monthly_fee',
                'view_any_transaction',
            ]);
        }
    }
}
