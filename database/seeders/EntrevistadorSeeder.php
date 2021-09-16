<?php

namespace Database\Seeders;

use App\Models\Entrevistador;
use Illuminate\Database\Seeder;

class EntrevistadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Entrevistador::factory()
            ->count(15)
            ->create();
    }
}
