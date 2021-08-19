<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdressesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Adress::insert([
            'logradouro' => 'Rua Gaivota',
            'numero' => 2121,
            'bairro' => 'Jardim dos Pássaros',
            'cep' => '87505500',
            'cidade' => 'Umuarama',
            'estado' => 'PR',
            'user_id' => 1,
            'tipo' => RESIDENCIAL
        ]);
    }
}
