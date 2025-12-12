<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $roles = [
            'administrador',
            'inventariador',
            'usuario',
        ];

        foreach ($roles as $nombre) {
            DB::table('roles')->updateOrInsert(
                ['nombre' => $nombre],
                ['updated_at' => $now, 'created_at' => DB::raw('COALESCE(created_at, NOW())')]
            );
        }
    }
}
