<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'William',
            'last_name' => 'Sanchez',
            'email' => 'williamlopez0721@gmail.com',
            'password' => Hash::make('Willian2012'),
            'role_id' => 1, 
            'destinatary' => 'no',
            'vote' => 'no',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
