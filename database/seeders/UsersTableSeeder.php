<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->insertGetId([
            'name' => 'Администратор',
            'email' => 'arkadiok2033@gmail.com',
            'is_admin' => 1,
        ]);

        DB::table('auths')->insert([
            'type' => 'native',
            'user_id' => $user,
            'password' => bcrypt('12345678'),
        ]);
    }
}
