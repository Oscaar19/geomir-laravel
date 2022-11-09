<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $visibilities=[
            // ['id' => '1', 'name' => 'author'],
            // ['id' => '2', 'name' => 'editor'],
            // ['id' => '3', 'name' => 'admin'],
            ['name' => 'public'],
            ['name' => 'contacts'],
            ['name' => 'private'],
        ];
        DB::table('visibilities')->insert($visibilities);
    }
}


//PREGUNTAR POR LAS RELACIONES DE FK Y PORQUE NO SE COMITEA TODO