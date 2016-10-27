<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('users')->delete();
	
        DB::table('users')->insert([
			'username' => 'admin',
			'firstname' => 'tom',
			'lastname' => 'bergantiños',
			'password' => bcrypt('p@ssw0rd123')
		]);
    }
}
