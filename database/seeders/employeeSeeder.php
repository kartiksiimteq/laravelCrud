<?php

namespace Database\Seeders;

use App\Models\employee;
use Faker\Factory;
use Illuminate\Database\Seeder;

class employeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //     $employee=new employee();
        //     $employee->name="new";
        //     $employee->mobile="ww";
        //     $employee->department_id=1;
        //     $employee->mobile="999";
        //     $employee->image="";
        //     $employee->save();
        // }
        $faker = Factory::create();
        for ($i = 0; $i <= 10000; $i++) {

            $employee = new employee();
            $employee->name = $faker->name();
            $employee->mobile = $faker->phoneNumber();
            $employee->department_id = 1;
            $employee->image = "";
            $employee->save();
        }
    }
}
