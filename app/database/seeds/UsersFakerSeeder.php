<?php 
class UserFakerSeeder extends Seeder {
    public function run()
    {
        $faker = Faker\Factory::create();
        
        for( $i = 0; $i < 10; $i++) {
            $user = User::create(array(
                'user_email' => $faker->email,
                'username' => $faker->unique->userName,
                'password' => $faker->word,
                'remember_token' => str_random(50),
                'user_first_name' => $faker->firstName,
                'user_last_name' => $faker->lastName
            ));
                
        }
    }
}