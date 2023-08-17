<?php

namespace Database\Seeders;

use App\Models\department;
use Faker\Factory;
use Illuminate\Database\Seeder;

class departmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i = 0; $i <= 10000; $i++) {

            $department = new department();
            $department->name = $faker->colorName();
            $department->address = substr($faker->firstName(),20);
            $department->save();
        }

        //  $department=new department();
        //  $department->name="name new";
        //  $department->address="addresss new";
        //  $department->save();
    }
}
