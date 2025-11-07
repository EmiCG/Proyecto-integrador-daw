<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure admin user exists (created in DatabaseSeeder) and has role 'admin'
        $adminEmail = 'admin@gmail.com';

        $admin = User::where('email', $adminEmail)->first();
        if (! $admin) {
            $admin = User::create([
                'name' => 'admin',
                'email' => $adminEmail,
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]);
        } else {
            $admin->role = 'admin';
            $admin->save();
        }

        // Mark all other users as 'trabajador' if they don't have role set
        User::where('id', '!=', $admin->id)->get()->each(function (User $u) {
            if (empty($u->role)) {
                $u->role = 'trabajador';
                $u->save();
            }
        });
    }
}
