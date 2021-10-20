<?php

use App\Models\Carro;
use Illuminate\Database\Seeder;

class CarrosSeeder extends Seeder
{
    private $mockMarcasModelos = [
        "Chery" => "Celer Hatch",
        "Fiat" => "Doblò",
        "Ford" => "Courier",
        "Honda" => "CR-V",
        "Jeep" => "Cherokee",
        "GM/Chevrolet" => "Blazer"
    ];
    /**
     * Run the database seeds.  
     *
     * @return void
     */
    public function run()
    {
        $totCarros = Carro::count();
        // Somente insere na tabela carros caso ela não possua nenhum item.
        if ($totCarros < 1) {

            foreach ($this->mockMarcasModelos as $marca => $modelo) {
                $faker = Faker\Factory::create();
                $currCarro = new Carro();
                $currCarro->ano = $faker->dateTimeBetween("now", "5 years");
                $currCarro->modelo = $modelo;
                $currCarro->marca = $marca;
                $currCarro->save();
            }
        }
    }
}
