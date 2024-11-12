<?php

namespace Database\Seeders;

use App\Models\students;
use Illuminate\Database\Seeder;
use App\Models\Student; // Assuming you have a Student model
use Illuminate\Support\Facades\DB;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Classes from 1 to 9
        for ($classId = 1; $classId <= 9; $classId++) {
            // Create 5 students per class
            for ($i = 1; $i <= 5; $i++) {
                students::create([
                    'name' => 'Student ' . $i . ' of Class ' . $classId,
                    'class_id' => $classId
                ]);
            }
        }
    }
}
