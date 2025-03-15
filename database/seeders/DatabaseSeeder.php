<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create([
            'name' => 'Superadmin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Administrator',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Guest',
            'guard_name' => 'web'
        ]);

        $superadmin = User::create([
            'name' => 'Superadmin',
            'email' => 'jihadmaulana05@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $superadmin->assignRole('Superadmin');

        $administrator = User::create([
            'name' => 'Administrator',
            'email' => 'himurakoji91@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $administrator->assignRole('Administrator');

        $guest = User::create([
            'name' => 'Guest',
            'email' => 'kelanasamudera55@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $guest->assignRole('Guest');
    }
}
