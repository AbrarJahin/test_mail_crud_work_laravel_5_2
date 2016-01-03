<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
				$users = [
							[
							'user_type' => 'admin',
							'is_active' => 'active',
							'name' => 'Admin',
							'email' => 'admin@admin.com',
							'password' => bcrypt('123456'),
							],
							[
							'user_type' => 'admin',
							'is_active' => 'active',
							'name' => 'Piash',
							'email' => 'piash@piash.com',
							'password' => bcrypt('123456'),
							],
							[
							'user_type' => 'user',
							'is_active' => 'active',
							'name' => 'Abrar',
							'email' => 'abrar@abrar.com',
							'password' => bcrypt('123456'),
							],
							[
							'user_type' => 'user',
							'is_active' => 'active',
							'name' => 'Jahin',
							'email' => 'jahin@jahin.com',
							'password' => bcrypt('123456'),
							],
						];
                foreach ($users as $user)
                {
                	User::create($user);
                }
    }
}
