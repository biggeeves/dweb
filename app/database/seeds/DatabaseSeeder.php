<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
        
          User::create(array('username' => 'gneils',
                'password' => Hash::make('14716e22')));

		// $this->call('UserTableSeeder');
	}

}
