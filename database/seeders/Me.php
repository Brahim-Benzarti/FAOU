<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Me extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "root",
            'email' => 'root@faou.com',
            'super'=>'1',
            'position'=>'Admin',
            'password' => Hash::make('root'),
        ]);
    }
}
