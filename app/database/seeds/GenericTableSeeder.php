<?php
class GenericTableSeeder extends Seeder {
   public function run()
   {
       $faker = Faker\Factory::create();
       for( $i = 0; $i < 10 ; $i++) {
         
         DB::table('Crf_xm');
         $crf_xm = Crf_xm::create(array(
              'demo_id' => $faker->text($maxNbChars = 8),
              'formdate' => $faker->date($format = 'Y-m-d', $max = 'now'),
              'xm01' => $faker->randomDigit,
              'xm02' => $faker->randomDigit,
              'xm02a' => $faker->randomDigit,
              'xm03' => $faker->randomDigit,
              'xm04' => $faker->randomDigit,
              'xm05' => $faker->randomDigit,
              'xm06' => $faker->randomDigit,
              'xm07' => $faker->randomDigit,
              'xm07a' => $faker->date($format = 'Y-m-d', $max = 'now'),
              'xm08' => $faker->randomDigit,
              'xm08b' => $faker->date($format = 'Y-m-d', $max = 'now'),
              'dccdate' => $faker->date($format = 'Y-m-d', $max = 'now'),
              'dcctime' => $faker->time($format = 'H:i:s', $max = 'now'),
              'dccwho' => $faker->text($maxNbChars = 22),
              'dccedits' => $faker->randomDigit,
              'dstamp' => $faker->date($format = 'Y-m-d', $max = 'now'),
              'dwho' => $faker->text($maxNbChars = 22)
           ));
       }
   }
}
?>
