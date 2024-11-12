<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\classes;
use App\Models\students;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
class ClassController extends Controller
{
    public function index(Request $request)
    {
        // Get today's date
        $today = now()->toDateString();
        
        // Get the selected class ID and date range from the request
        $selectedClassId = $request->input('class_id');
        $startDate = $request->input('start_date') ?? $today; // Default to today
        $endDate = $request->input('end_date') ?? $today; // Default to today
        
        // Total students, filtered by class if class_id is provided
        $totalStudentsQuery = students::query();
        if ($selectedClassId) {
            $totalStudentsQuery->where('class_id', $selectedClassId);
        }
        $totalStudents = $totalStudentsQuery->count();
    
        // Initialize the attendance query for the selected date range
        $attendanceQuery = Attendance::whereBetween('date', [$startDate, $endDate]);
    
        // Apply class filter if selected
        if ($selectedClassId) {
            $attendanceQuery->whereHas('student', function($query) use ($selectedClassId) {
                $query->where('class_id', $selectedClassId);
            });
        }
    
        // Fetch the filtered attendance data
        $attendances = $attendanceQuery->orderBy('class_id')->get();
    
        // Count total attendance by status in the specified date range
        $attendanceCounts = $attendanceQuery->selectRaw('status, COUNT(DISTINCT CONCAT(student_id, date)) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
    
        // Retrieve counts or set to 0 if not present
        $totalPresentToday = $attendanceCounts['present'] ?? 0;
        $totalAbsentToday = $attendanceCounts['absent'] ?? 0;
        $totalExcusedToday = $attendanceCounts['excused'] ?? 0;
        $totalOneLessonToday = $attendanceCounts['one lesson'] ?? 0;
    
        // Get classes for the dropdown
        $classes = classes::all();
    
        return view('welcome', compact(
            'totalStudents', 'totalPresentToday', 'totalAbsentToday', 'totalExcusedToday','totalOneLessonToday',
            'classes', 'selectedClassId', 'startDate', 'endDate', 'attendances' // Pass attendance data
        ));
    }
    
    
    
    

    public function students()
    {
        $class=classes::all();
        $student=students::all();

        return view('students', ["students"=> $student, "classes"=> $class]);
    }
    public function addStudent(Request $request)
    {
       
    
        // Filter out any empty names
        $names = array_filter($request->input('names'), function($name) {
            return !empty($name);
        });
    
        // Loop through each non-empty name
        foreach ($names as $name) {
            // Create a new student instance for each name
            $student = new students();
            $student->name = $name;
            $student->class_id = $request->input('class_id');
            $student->save();
        }
    
        // Redirect back after adding all students
        return redirect()->back()->with('success', 'Students added successfully.');
    }
    
    public function editStudent(Request $request, $id)
    {

        $student = students::findOrFail($id,);
        $student->name = $request->input('renameStudent');
        $student->class_id = $request->input('class_id');
        $student->save();
        return back()->with('info','گۆڕانکاری تێداکرا.');

    }
    public function deleteStudent($id)
    {
        $student = students::findOrFail($id,);
        $student->delete();
        return back()->with('warning','بابەتەکە سڕایەوە!');
    }

    public function bulkAssign(Request $request)
{
    // Assign each selected student to the new class
    students::whereIn('id', $request->student_ids)->update(['class_id' => $request->class_id]);

    return redirect()->back()->with('success', 'Students moved to the new class successfully.');
}

  


    public function classes()
    {
        $student =students::all();
        $class=classes::all();

        return view('classes', ["classes"=> $class, "students"=> $student]);
    }
    
    public function addClass(Request $request)
    {
        $request->validate([
            'name' => 'unique:classes,class_name,',
        ]);

        $class = new classes;
        $class->class_name= $request->input('name');
        $class->save();
        return redirect()->back();
    }

    public function editClass(Request $request, $id)
    {
        $request->validate([
            'renameClass' => 'unique:classes,class_name,' . $id,
        ], [
            'renameClass.unique' => 'This class name has already been taken.',
        ]);

        $class = classes::findOrFail($id,);
        $class->class_name = $request->input('renameClass');
    
        
        $class->save();
        return back()->with('info','گۆڕانکاری تێداکرا.');

    }

    public function checkClassName(Request $request)
{
    $className = $request->input('class_name');
    $classId = $request->input('class_id');

    // Check if the class name exists, excluding the current class
    $exists = classes::where('class_name', $className)
        ->where('id', '!=', $classId)
        ->exists();

    return response()->json(['exists' => $exists]);
}


public function deleteClass($id)
    {
        $class = classes::findOrFail($id,);
        $class->delete();
        return back()->with('warning','بابەتەکە سڕایەوە!');
    }
  

    public function attendanceForm(Request $request)
    {
        // Get all classes for the dropdown
        $classes = classes::all();
    
        // Set selected class ID to the requested class or the first class if none selected
        $selectedClassId = $request->input('class_id', $classes->first()?->id);
    
        // Get students and attendance records for the selected class
        $students = students::where('class_id', $selectedClassId)->get();
        $attendanceRecords = Attendance::where('class_id', $selectedClassId)
                            ->whereDate('date', now()->toDateString())
                            ->get()
                            ->keyBy('student_id');
    
        return view('getattendance', compact('classes', 'students', 'selectedClassId', 'attendanceRecords'));
    }
    
    

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'attendance.*' => 'required|in:present,absent,excused,one lesson', 
        ]);
    
        $today = now()->toDateString();  // Get today's date
    
        foreach ($request->attendance as $studentId => $status) {
            // Update the attendance if it exists, or create a new one
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'class_id' => $request->class_id,
                    'date' => $today,  // Use the date field to ensure one record per day
                ],
                [
                    'status' => $status
                ]
            );
        }
    
        return response()->json(['success' => true]);
    }
    

    
    public function showAttendanceReportStudent(Request $request)
    {
        // Retrieve all classes for dropdown selection
        $classes = Classes::all();
    
        // Retrieve selected class from request
        $classId = $request->input('class_id');
    
        // If no class is selected, default to the first class ID if it exists
        if (!$classId && $classes->isNotEmpty()) {
            $classId = $classes->first()->id;
        }
    
        // Calculate the current academic year
        $now = Carbon::now();
        $currentYear = $now->year;
        $academicYearStart = $now->month >= 9 ? $currentYear : $currentYear - 1;
    
        // Set the semester start and end dates
        $semesterStart = Carbon::create($academicYearStart, 9, 1)->startOfDay();
        $semesterEnd = Carbon::create($academicYearStart + 1, 6, 30)->endOfDay();
    
        // Retrieve students based on selected class (if specified) and load their attendance within the semester date range
        $students = Students::with(['attendances' => function ($query) use ($semesterStart, $semesterEnd) {
            $query->whereBetween('date', [$semesterStart, $semesterEnd]);
        }])
        ->when($classId, function ($query) use ($classId) {
            return $query->where('class_id', $classId);
        })
        ->get();
        
        // Convert attendance records to an array of dates with their status
        $attendanceRecords = [];
        foreach ($students as $student) {
            foreach ($student->attendances as $attendance) {
                $attendanceRecords[$attendance->date->toDateString()] = $attendance;
            }
        }
        
        // Pass the attendance records to the view
        return view('reportsbystudent', [
            'classes' => $classes,
            'students' => $students,
            'attendanceRecords' => $attendanceRecords, // Pass the structured records
            'selectedClassId' => $classId,
            'semesterStart' => $semesterStart->format('Y-m-d'),
            'semesterEnd' => $semesterEnd->format('Y-m-d'),
            'academicYear' => $academicYearStart . '-' . ($academicYearStart + 1),
        ]);
    }    
    


public function showAttendanceReportClass(Request $request)
{
    $classes = Classes::orderBy('id')->get();
    $classId = $request->input('class_id');
    $selectedMonth = $request->input('month', 1);

    // Check if "all classes" is selected
    $isAllClasses = $classId === 'all' || $classId === null;

    // Get the current year
    $currentYear = Carbon::now()->year;

    // Set the start and end dates for the selected month
    $startDate = Carbon::createFromDate($currentYear, $selectedMonth, 1)->startOfDay();
    $endDate = $startDate->copy()->endOfMonth()->endOfDay();

    // Get all students for the selected class(es) along with their attendance for the month
    $studentsQuery = Students::with(['attendances' => function ($query) use ($startDate, $endDate) {
        $query->whereBetween('date', [$startDate, $endDate]);
    }, 'class']);

    // Apply class filter only if a specific class is selected
    if (!$isAllClasses) {
        $studentsQuery->where('class_id', $classId);
    }

    $students = $studentsQuery->get();

    // Group students by class and sort by class ID
    $studentsByClass = $students->groupBy('class_id')->sortKeys();

    // Prepare a mapping of each student to their attendance status for each day of the month
    $attendanceStatuses = [];
    foreach ($students as $student) {
        // Create an array to hold attendance status for each day
        $attendanceStatuses[$student->id] = [];
        
        // Fill attendance statuses for each day of the month
        for ($day = 1; $day <= $endDate->day; $day++) {
            $date = Carbon::createFromDate($currentYear, $selectedMonth, $day)->startOfDay();
            
            // Use Carbon's startOfDay() and endOfDay() for comparison
            $attendanceRecord = $student->attendances->first(function ($attendance) use ($date) {
                return $attendance->date->startOfDay()->equalTo($date);
            });

            // Set attendance status based on the record
            if ($attendanceRecord) {
                $attendanceStatuses[$student->id][$day] = $attendanceRecord->status; // 'present', 'absent', etc.
            } else {
                $attendanceStatuses[$student->id][$day] = null; // No record for the day
            }
        }
    }

    return view('reportsbyclass', [
        'classes' => $classes,
        'studentsByClass' => $studentsByClass,
        'selectedClassId' => $isAllClasses ? 'all' : $classId,
        'selectedMonth' => $selectedMonth,
        'currentYear' => $currentYear,
        'attendanceStatuses' => $attendanceStatuses,
        'endDate' => $endDate,
    ]);
}
    
public function manualattendanceForm(Request $request)
{
    // Get all classes for the dropdown
    $classes = classes::all();

    // Set selected class ID to the requested class or the first class if none selected
    $selectedClassId = $request->input('class_id', $classes->first()?->id);

    // Get the selected date or use today's date if not provided
    $attendanceDateInput = $request->input('attendance_date');

    // Validate the date format first to prevent parsing issues
    if ($attendanceDateInput && Carbon::hasFormat($attendanceDateInput, 'Y-m-d')) {
        $selectedDate = Carbon::parse($attendanceDateInput)->format('Y-m-d');
    } else {
        // If the date is missing or in the wrong format, default to today's date
        $selectedDate = now()->toDateString();
    }
    // Get students for the selected class
    $students = students::where('class_id', $selectedClassId)->get();

    // Check if attendance records exist for the selected date and class
    $attendanceExists = Attendance::where('class_id', $selectedClassId)
                        ->whereDate('date', $selectedDate)
                        ->exists();

    // Get attendance records if they exist
    $attendanceRecords = $attendanceExists 
        ? Attendance::where('class_id', $selectedClassId)
            ->whereDate('date', $selectedDate)
            ->get()
            ->keyBy('student_id')
        : collect();

    return view('manualattendance', compact('classes', 'students', 'selectedClassId', 'attendanceRecords', 'selectedDate', 'attendanceExists'));
}

public function manualstoreAttendance(Request $request)
{
    $request->validate([
        'class_id' => 'required',
        'attendance_date' => 'required|date',
        'attendance.*' => 'required|in:present,absent,excused,one lesson', 
    ]);

    $selectedDate = $request->input('attendance_date');

    foreach ($request->attendance as $studentId => $status) {
        // Update the attendance if it exists, or create a new one
        Attendance::updateOrCreate(
            [
                'student_id' => $studentId,
                'class_id' => $request->class_id,
                'date' => $selectedDate,  // Use the selected date
            ],
            [
                'status' => $status
            ]
        );
    }

    return response()->json(['success' => true]);
}

    
    
    
}
