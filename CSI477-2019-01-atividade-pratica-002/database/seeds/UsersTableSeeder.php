<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'csi477@ufop.com',
            'email_verified_at' => now(),
            'password' => Hash::make('csi477'),
            'type'=>1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
