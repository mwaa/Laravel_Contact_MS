<?php
/**
 * Created by PhpStorm.
 * User: Mwaa
 * Date: 1/30/2015
 * Time: 5:42 PM
 */
use Faker\Factory as Faker;

class ContactsTableSeeder extends Seeder {

    public  function  run()
    {
        $faker = Faker::create();
        $ownerids = User::lists('id');

        foreach(range(1,100) as $index)
        {
            contact::create([
                'owner_id' => $faker->randomElement($ownerids),
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->email(),
                'address' => $faker->address(),
                'twitter' => $faker-> word().$faker->randomNumber()
            ]);
        }
    }
} 