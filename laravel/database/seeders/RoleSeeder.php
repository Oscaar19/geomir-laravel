<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles=[
            // ['id' => '1', 'name' => 'author'],
            // ['id' => '2', 'name' => 'editor'],
            // ['id' => '3', 'name' => 'admin'],
            ['name' => 'author'],
            ['name' => 'editor'],
            ['name' => 'admin'],
        ];
        DB::table('roles')->insert($roles);      
    }
}
