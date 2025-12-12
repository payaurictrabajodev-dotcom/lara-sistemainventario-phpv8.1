<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $inventariadorRoleId = DB::table('roles')->where('nombre', 'inventariador')->value('id');
        $administradorRoleId = DB::table('roles')->where('nombre', 'administrador')->value('id');

        DB::table('users')->updateOrInsert(
            ['email' => 'inventariador@example.com'],
            [
                'name' => 'Inventariador Demo',
                'email' => 'inventariador@example.com',
                'password' => Hash::make('123123123'),
                'role_id' => $inventariadorRoleId,
                'es_administrador' => false,
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador Demo',
                'email' => 'admin@example.com',
                'password' => Hash::make('123123123'),
                'role_id' => $administradorRoleId,
                'es_administrador' => true,
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }
}
