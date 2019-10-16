<?php

use Illuminate\Database\Seeder;
//use Faker\Generator as Faker;

use App\User;
class UserSeeder extends Seeder
{
    public function __construct()
    {
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i=0;$i<200;$i++):
            $gender = ($i % 2 === 0) ? 'male' : 'female';
            $g = ($gender === 'male') ? 'men' : 'women';
            $avatar = 'https://randomuser.me/api/portraits/' . $g . '/' . rand(1, 99) . '.jpg';
            $name = $faker->name($gender);
            $email = strtolower($name).time(). '@envoyerair.com';

            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->avatar = $avatar;
            $user->password = time();
            $user->save();
        endfor;
    }
}
