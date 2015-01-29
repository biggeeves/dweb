<?php

class UserTableSeeder extends Seeder
{

public function run()
{
    DB::table('users')->delete();
    User::create(array(
        'user_last_name'     => 'Neils',
        'user_first_name'     => 'Greg',
        'username' => 'myusername',
        'user_email'    => 'gneils@somedomain.com',
        'password' => Hash::make('mypassword'),
    ));
}

}
