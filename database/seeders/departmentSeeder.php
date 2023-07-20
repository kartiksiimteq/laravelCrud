<?php

namespace Database\Seeders;

use App\Models\department;
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
     $department=new department();
     $department->name="name new";
     $department->address="addresss new";
     $department->save();
    }
}
