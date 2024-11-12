@extends('layout')

@section('content')
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333333;
            margin: 50px;
            padding: 0;
        }
        .form-control {
            margin-left: -15px; /* Adjust this value to reduce the space further */
            padding-left: 8px; /* Optional: fine-tune input padding */
            background-color: #f0f2f5;
        
        }
        .header {
            background-color: #ffffff;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .main-content {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .filter-label {
            font-weight: bold;
            font-size: 0.9rem;
        }
        .filter-select, .filter-date {
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.9rem;
            min-width: 200px;
           
        }
        .stats-container {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .stat-card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 1rem;
            min-width: 200px;
            flex: 1;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-card.highlight {
            background-color: #009879;
            color: #ffffff;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            color: #666666;
            font-size: 0.9rem;
        }
        .highlight .stat-label {
            color: #e8f5e9;
        }

         /* New styles for the table */
         .table-container {
            overflow-x: auto;
            margin-top: 2rem;
            
        }
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 25px 0 25px 0;
           
        }
        .custom-table th,
        .custom-table td {
            padding: 12px;
             text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }
        .custom-table th {
            background-color: #009879; !important;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9rem;
            color: #ffff;
        }
        
        .custom-table td {
            font-size: 1.2rem;
        }
        .table-header-text {
            display: none;
        }

        .custom-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
        
    }
    

    .custom-table tbody tr:last-of-type {
        border-bottom: 2px solid #009879;
    }
       
        .submit-btn {
        width: 200px;
        height: 45px;
        align-items: center;
        justify-content: center;
        background-color: white;
        border: 1px solid rgb(213, 213, 213);
        border-radius: 10px;
        gap: 10px;
        font-size: 16px;
        cursor: pointer;
        overflow: hidden;
        font-weight: 500;
        box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.065);
        transition: all 0.3s;
        margin-bottom: 10px;
        }
       
        .submit-btn:hover {
        background-color: rgb(239, 239, 239);
        }
        .radio-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }

    .radio-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4px 10px;
        background-color: #f0f2f5;
        border: 1px solid #ccc;
        border-radius: 20px;
        cursor: pointer;
        font-size: 25px;
        transition: all 0.3s ease;
        width: 20%;
    }

    .radio-label:hover {
        background-color: #e0e2e5;
    }

    .radio-input {
        display: none;
    }

    .radio-input:checked + .radio-label {
        color: white;
    }

    .radio-input:checked + .radio-label[for^="present-"] {
        background-color: #009879;
        border-color: #009879;
    }

    .radio-input:checked + .radio-label[for^="absent-"] {
        background-color: #e74c3c;
        border-color: #ff4d4d;
    }

    .radio-input:checked + .radio-label[for^="excused-"] {
        background-color: #f39c12;
        border-color: #ffa500;
    }
    .radio-input:checked + .radio-label[for^="one-lesson-"] {
    background-color: #FD8B51;
    border-color: #fa7c3c;
}
        
      
        @media (max-width: 768px) {
            .main-content {
            padding: 0.2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .radio-group {
            flex-direction: column;
            align-items: stretch;
        }

        .radio-label {
            width: 100%;
        }
            .filters {
                flex-direction: column;
            }
            .filter-group {
                width: 100%;
            }
            .filter-select {
            text-align: center;
        }
            .stats-container {
                flex-direction: column;
            }
            .stat-card {
                width: 100%;
            }
            .custom-table th,
            .custom-table td {
                padding: 8px;
            }
            .custom-table th {
                font-size: 0.8rem;
            }
            .custom-table td {
                font-size: 0.85rem;
            }
            .custom-table th:nth-child(1),
            .custom-table td:nth-child(1) {
                display: none;
            }
            .submit-btn {
                width: 100%};
        }
    </style>


<div class="container">
    <!-- Class Selection Dropdown -->
    <form action="{{ route('attendance.form') }}" method="GET" id="classSelectForm">
        <div class="row mb-3">
            <div class="col-12 col-md-6 d-flex flex-column flex-md-row align-items-md-center mb-3 mb-md-0">
                <label for="class_id" class="filter-label me-3">Class:</label>
                <select class="filter-select" id="class_id" name="class_id" onchange="this.form.submit()" required>
                    <option value="" selected="true" disabled>Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                            {{ $class->class_name }}
                        </option>
                    @endforeach
                </select>
                
            </div>
        </div>
        
    </form>

   
    @if(isset($students) && $students->isNotEmpty())
    <form action="{{ route('attendance.store') }}" method="POST" id="attendanceForm">
        @csrf
        <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
        <table class="custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                    <tbody>
                    @foreach ($students as $index => $student)
                    @php
                        $attendance = $attendanceRecords->get($student->id);
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $student->name }}</td>
                        <td>
                        <div class="radio-group">
                            <input type="radio" id="present-{{ $student->id }}" name="attendance[{{ $student->id }}]" value="present" class="radio-input" required {{ (isset($attendance) && $attendance->status == 'present') ? 'checked' : '' }}>
                            <label for="present-{{ $student->id }}" class="radio-label">هاتوو</label>

                            <input type="radio" id="absent-{{ $student->id }}" name="attendance[{{ $student->id }}]" value="absent" class="radio-input" required {{ (isset($attendance) && $attendance->status == 'absent') ? 'checked' : '' }}>
                            <label for="absent-{{ $student->id }}" class="radio-label">غیاب</label>

                            <input type="radio" id="excused-{{ $student->id }}" name="attendance[{{ $student->id }}]" value="excused" class="radio-input" required {{ (isset($attendance) && $attendance->status == 'excused') ? 'checked' : '' }}>
                            <label for="excused-{{ $student->id }}" class="radio-label">مۆڵەت</label>
                         
                            <input type="radio" id="one-lesson-{{ $student->id }}" name="attendance[{{ $student->id }}]" value="one lesson" class="radio-input" required {{ (isset($attendance) && $attendance->status == 'one lesson') ? 'checked' : '' }}>
                            <label for="one-lesson-{{ $student->id }}" class="radio-label">یەک وانە</label>
                        </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <button id="submitBtn" class="submit-btn" type="submit" disabled>Submit Attendance</button>
    </form>
    @else
        @if($selectedClassId)
            <p>No students found for the selected class.</p>
        @endif
    @endif

    
</div>
<script>
$(function() {
  $('input[name="date"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 2020,
    maxYear: parseInt(moment().format('YYYY'),10),
    startDate: moment(), // Set initial date to today
    locale: {
      format: 'DD-MM-YYYY' // Change date format
    }
  }, function(start, end, label) {

  });
});
</script>


<script>
        toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,     // Shows the timer countdown
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "500",
        "timeOut": "2000",       // Duration of the toast in milliseconds
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('attendanceForm');
        const classSelect = document.getElementById('class_id');
        const submitBtn = document.getElementById('submitBtn');

        // Enable submit button when any radio button is clicked
        form.addEventListener('change', function() {
            submitBtn.disabled = false;
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Create FormData object
            let formData = new FormData(form);

            // Submit form data using AJAX
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {

                    // Move to the next class
                    let options = Array.from(classSelect.options);
                    let selectedIndex = options.findIndex(option => option.selected);
                    
                    if (selectedIndex < options.length - 1) {
                        classSelect.selectedIndex = selectedIndex + 1;
                        classSelect.form.submit();
                    } else {
                        toastr.info('All attendances has been submitted.');
                    }
                } else {
                    toastr.error('Error submitting attendance. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('An error occurred. Please try again.');
            });
        });
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('attendanceForm');
    const submitBtn = document.getElementById('submitBtn');
    const radioInputs = document.querySelectorAll('.radio-input');
    let isFormChanged = false;
    let isSubmitted = false;

    function updateButtonState() {
        const allChecked = Array.from(radioInputs).every(input => {
            const name = input.getAttribute('name');
            return document.querySelector(`input[name="${name}"]:checked`) !== null;
        });
        submitBtn.disabled = !allChecked || isSubmitted || !isFormChanged;
    }

    function handleChange() {
        isFormChanged = true;
        updateButtonState();
    }

    radioInputs.forEach(input => {
        input.addEventListener('change', handleChange);
    });

    form.addEventListener('submit', function(e) {
        if (submitBtn.disabled) {
            e.preventDefault();
            return;
        }
        isSubmitted = true;
        submitBtn.disabled = true;
        // Form will be submitted normally
    });

    // Check initial state
    isFormChanged = Array.from(radioInputs).some(input => input.checked);
    updateButtonState();
});
</script>
@endsection
