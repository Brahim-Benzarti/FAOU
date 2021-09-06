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
            'name' => "Brahim Benzarti",
            'email' => 'brahim.al.benzarti@gmail.com',
            'super'=>'1',
            'position'=>'IT Manager',
            'password' => Hash::make('root'),
        ]);
        DB::table('users')->insert([
            'name' => "Zoubair Khouaja",
            'email' => 'second@faou.com',
            'super'=>'1',
            'position'=>'CEO',
            'password' => Hash::make('testing'),
        ]);
    }
}
