<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('msrole')->insert([
            [ 'name' => 'admin' ],
            [ 'name' => 'customer' ],
            [ 'name' => 'staff' ],
        ]);

    }
}
