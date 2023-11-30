<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        $array = [
            [
                'name' => 'categories',
                'label' => 'Categorias',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'brands',
                'label' => 'Marcas',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'profiles',
                'label' => 'Perfiles',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'type_stores',
                'label' => 'Tipo de tiendas',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'cylinder_capacities',
                'label' => 'Cilindraje',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'models',
                'label' => 'Modelos',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'boxes',
                'label' => 'Cajas',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'type_products',
                'label' => 'Tipo de productos',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'countries',
                'label' => 'Paises',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'days',
                'label' => 'Dias',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'modules',
                'label' => 'Modulos',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'states',
                'label' => 'Estados',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'cities',
                'label' => 'Ciudades',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'products',
                'label' => 'Productos',  
                'type' => '2',
                'created_at' => now()
            ],
            [
                'name' => 'users',
                'label' => 'Usuarios',  
                'type' => '3',
                'created_at' => now()
            ],
            [
                'name' => 'subscriptions',
                'label' => 'Subscripciones',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'plans',
                'label' => 'Planes',  
                'type' => '1',
                'created_at' => now()
            ],
            [
                'name' => 'stores',
                'label' => 'Tiendas',  
                'type' => '1',
                'created_at' => now()
            ],

        ];
        DB::table('tables')->insert($array);
    }
}
