<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance; // Assuming you have an Attendance model
use Carbon\Carbon;

class AttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['present', 'absent', 'excused'];

        // Generate attendance data for the past 7 days
        for ($day = 0; $day < 7; $day++) {
            $date = Carbon::now()->subDays($day)->toDateString(); // Generate the date for the last 7 days
            
            // Loop through student IDs (1 to 25)
            for ($studentId = 1; $studentId <= 25; $studentId++) {
                // Assign a random class_id (1 to 9)
                $classId = rand(1, 9);

                // Assign a random status (present, absent, excused)
                $status = $statuses[array_rand($statuses)];

                // Insert the attendance record
                Attendance::create([
                    'student_id' => $studentId,
                    'class_id' => $classId,
                    'date' => $date,
                    'status' => $status,
                ]);
            }
        }
    }
}
