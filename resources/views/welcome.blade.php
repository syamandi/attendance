@extends('layout')

@section('content')
@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Dashboard</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333333;
            margin: 0;
            padding: 0;
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
            margin-bottom: 1rem;
        }
        .stat-card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 1rem;
            min-width: 200px;
            flex: 1;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
           
        }
        .stat-card.present {
            background-color: #009879;
            color: #ffffff;
            
        }
        .stat-card.absent {
            background-color: #e74c3c;
            color: #ffffff;
        }
        .stat-card.excused {
            background-color: #f39c12;
            color: #ffffff;
        }
        .stat-card.onelesson {
            background-color: #FD8B51;
            color: #ffffff;
        } 
        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            color: #666666;
            font-size: 1.3rem;
        }
        .present .stat-label,.absent .stat-label, .excused .stat-label, .onelesson .stat-label  {
            color: #e8f5e9;
        }

        
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 5%;
                
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
       
      
        .sort-icon {
            display: inline-block;
            width: 0;
            height: 0;
            margin-left: 5px;
            vertical-align: middle;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
        }

        .sort-icon.asc {
            border-bottom: 5px solid #fff;
        }

        .sort-icon.desc {
            border-top: 5px solid #fff;
        }

        .sort-icon.unsorted {
            border-bottom: 5px solid #ccc;
        }

      
        @media (max-width: 768px) {
            .main-content {
            padding: 0.2rem;
            max-width: 1200px;
            margin: 0 auto;
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
        }

        @media print {
        body * {
            visibility: hidden;
        }
        .custom-table th:nth-child(1),
            .custom-table td:nth-child(1) {
                display:flex;
            }
            .sort-icon {
                display: none;}
        
      
            .custom-table th:nth-child(4),
            .custom-table th:nth-child(5),
            .custom-table td:nth-child(4),
            .custom-table td:nth-child(5) {
                display: none;
            }

            
        #printableArea, #printableArea * {
            visibility: visible;
        }

        #printableArea {
            position: absolute;
            left: 20px;
            top: 20px;
            width: 95%;
        }

        #classSelectForm, .styled-table {
            width: 100%;
        }

        /* Show the logo only during printing */
        .print-logo {
            display: block !important;
            margin: 0 auto 20px auto;
            max-width: 100px; /* Adjust size as needed */
        }
        .print-title {
            display: block !important;
            margin: 0 auto 20px auto;
            max-width: 250px; /* Adjust size as needed */
        }
        .print-btn {
        display: none;
    }
    .label {
        display: flex;
        align-items: center;
        text-align: center;
    }
    .form-control {
    text-align: left;
}
.table-header-text {
    display: flex;
    justify-content: space-between;
    margin: 10px 0 10px 0;
}

    }
     /* Hide the logo in the normal view */
     .print-logo,.print-title {
        display: none;
    }
    @page { size: auto;  margin: 0mm; }
    </style>
</head>

<main class="main-content">
    <form action="{{ route('index.form') }}" method="GET" id="classSelectForm">
        <div class="filters">
            <!-- Class Selection Dropdown -->
            <div class="filter-group">
                <label for="class_id" class="filter-label">Class:</label>
                <select class="filter-select" id="class_id" name="class_id" onchange="this.form.submit()" required>
                    <option value="" selected>All Classes</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                            {{ $class->class_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date Range Picker -->
            <div class="filter-group">
                <label for="reportrange" class="filter-label">Date:</label>
                <div id="reportrange" class="filter-select">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span>{{ request('start_date', now()->subDays(30)->format('Y-m-d')) }} - {{ request('end_date', now()->format('Y-m-d')) }}</span>
                    <i class="fa fa-caret-down"></i>
                </div>
                <input type="hidden" name="start_date" id="start_date" value="{{ request('start_date', now()->subDays(30)->format('Y-m-d')) }}">
                <input type="hidden" name="end_date" id="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}">
            </div>
        </div>
    </form>
  

    <div class="stats-container">
    <div class="stat-card">
        <div class="stat-value">{{ $totalStudents }}</div>
        <div class="stat-label">کۆی گشتی قوتابی</div>
    </div>
</div>

<div class="stats-container">
    <div class="stat-card present">
        <div class="stat-value">{{ $totalPresentToday }}</div>
        <div class="stat-label">هاتوو</div>
    </div>
    <div class="stat-card absent">
        <div class="stat-value">{{ $totalAbsentToday }}</div>
        <div class="stat-label">غیاب</div>
    </div>
    <div class="stat-card excused">
        <div class="stat-value">{{ $totalExcusedToday }}</div>
        <div class="stat-label">مۆڵەت</div>
    </div>
    <div class="stat-card onelesson">
        <div class="stat-value">{{ $totalOneLessonToday }}</div>
        <div class="stat-label">غیابی یەک وانە</div>
    </div>
</div>

    
    <div id="printableArea">
        
        <!-- Logo to appear during printing -->
        <img src="assets/img/margret-logo.svg" alt="logo" class="print-logo">
        <h4 class="print-title">Student Attendance</h4>
        <div class="table-header-text">
            <span id="classText">Class: </span>
            <span id="dateText">Date: </span>
        </div>
        
        
            @if($attendances->isNotEmpty())
            
            <table class="custom-table">
                <thead>
                    <tr>
                    <th onclick="sortTable(0)"># <span class="sort-icon unsorted" data-column="0"></span></th>
                <th onclick="sortTable(1)">Student Name <span class="sort-icon unsorted" data-column="1"></th>
                <th onclick="sortTable(2)">Status <span class="sort-icon unsorted" data-column="2"></th>
                <th onclick="sortTable(3)">Class <span class="sort-icon unsorted" data-column="3"></th>
                <th onclick="sortTable(4)">Date <span class="sort-icon unsorted" data-column="4"></th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $index => $attendance)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $attendance->student->name }}</td>
                        @if ($attendance->status == 'present') 
                        <td>هاتوو</td>
                        @elseif ($attendance->status == 'absent')
                        <td>غیاب</td>
                        @elseif ($attendance->status == 'excused')
                        <td>مۆڵەت</td>
                        @else 
                        <td>یەک وانە</td>
                        @endif
                        <td>{{ $attendance->student->class->class_name }}</td>
                        <td>{{ Carbon::parse($attendance->date)->format('d-m-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        
    </div>
</main>


<script>
    let sortDirection = {};

    function sortTable(columnIndex) {
        const table = document.querySelector(".custom-table tbody");
        const rows = Array.from(table.querySelectorAll("tr"));

        sortDirection[columnIndex] = !sortDirection[columnIndex];
        const sortedRows = rows.sort((a, b) => {
            const cellA = a.cells[columnIndex].textContent.trim().toLowerCase();
            const cellB = b.cells[columnIndex].textContent.trim().toLowerCase();

            if (!isNaN(cellA) && !isNaN(cellB)) return sortDirection[columnIndex] ? cellA - cellB : cellB - cellA;
            return sortDirection[columnIndex] ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
        });

        sortedRows.forEach(row => table.appendChild(row));
        updateSortIndicators(columnIndex);
    }

    function updateSortIndicators(columnIndex) {
        document.querySelectorAll(".custom-table th .sort-icon").forEach((header) => {
            header.className = `sort-icon ${header.getAttribute('data-column') == columnIndex ? (sortDirection[columnIndex] ? 'asc' : 'desc') : 'unsorted'}`;
        });
    }





$(function() {
    var start = moment("{{ request('start_date') ? request('start_date') : now()->format('Y-m-d') }}");
    var end = moment("{{ request('end_date') ? request('end_date') : now()->format('Y-m-d') }}");

    function cb(start, end) {
        $('#reportrange span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
        $('#start_date').val(start.format('YYYY-MM-DD'));
        $('#end_date').val(end.format('YYYY-MM-DD'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        // Set the hidden inputs for start_date and end_date
        $('#start_date').val(picker.startDate.format('YYYY-MM-DD'));
        $('#end_date').val(picker.endDate.format('YYYY-MM-DD'));
        
        // Automatically submit the form after selecting a date range
        $('#classSelectForm').submit();
    });

    cb(start, end);
});

// Print function
function printForm() {
    window.print();
}

function updateHeaderText() {
    var classSelect = document.getElementById('class_id');
    var selectedClass = classSelect.options[classSelect.selectedIndex].text;
    document.getElementById('classText').textContent = 'Class: ' + selectedClass;

    // Get the end date from the date range picker and format it
    var endDate = document.getElementById('end_date').value;
    var formattedEndDate = moment(endDate, "YYYY-MM-DD").format("DD-MM-YYYY");
    document.getElementById('dateText').textContent = 'Date: ' + formattedEndDate;
}



// Call updateHeaderText when the page loads
document.addEventListener('DOMContentLoaded', updateHeaderText);

// Update header text when class or date changes
document.getElementById('class_id').addEventListener('change', updateHeaderText);
$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
    // ... (previous code remains unchanged) ...
    updateHeaderText();
});
</script>
@endsection
