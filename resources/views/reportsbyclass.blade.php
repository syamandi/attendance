@php
    use Carbon\Carbon;
@endphp
@php
    $kurdishMonths = [
        1 => 'کانوونی دووەم',
        2 => 'شوبات',
        3 => 'ئادار(مارت)',
        4 => 'نیسان',
        5 => 'ئایار(مایس)',
        6 => 'حوزەیران',
        7 => 'تەمموز',
        8 => 'ئاب',
        9 => 'ئەیلول',
        10 => 'تشرینی یەکەم',
        11 => 'تشرینی دووەم',
        12 => 'کانوونی یەکەم'
    ];
@endphp
@extends('layout')

@section('content')
<body>
    

<main class="main-content">
<form method="GET" action="">

    <select class="filter-select" id="class_id" name="class_id" onchange="this.form.submit()" >
    <option value="" {{ $selectedClassId == 'all' ? 'selected' : '' }}>هەموو پۆلەکان</option>
        @foreach($classes as $class)
            <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' :'' }}>
                {{ $class->class_name }}
            </option>
        @endforeach
    </select>
    <label for="class_id" class="filter-label ">&nbsp;:پۆل</label>
    
    <select class="filter-select dropdown-spacing" id="month" name="month" onchange="this.form.submit()" >
    @for($i = 1; $i <= 12; $i++)
    <option value="{{ $i }}" {{ $i == $selectedMonth ? 'selected' : '' }}>
        {{ $kurdishMonths[$i] }}&nbsp;( {{$i}} )
    </option>
@endfor
    </select>
    <label for="month" class="filter-label">&nbsp;:مانگ</label>
    
    <button class="print-btn" onclick="printForm()">
        <span class="printer-wrapper">
            <span class="printer-container">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 92 75">
                    <path
                    stroke-width="5"
                    stroke="black"
                    d="M12 37.5H80C85.2467 37.5 89.5 41.7533 89.5 47V69C89.5 70.933 87.933 72.5 86 72.5H6C4.067 72.5 2.5 70.933 2.5 69V47C2.5 41.7533 6.75329 37.5 12 37.5Z"
                    ></path>
                    <mask fill="white" id="path-2-inside-1_30_7">
                    <path
                        d="M12 12C12 5.37258 17.3726 0 24 0H57C70.2548 0 81 10.7452 81 24V29H12V12Z"
                    ></path>
                    </mask>
                    <path
                    mask="url(#path-2-inside-1_30_7)"
                    fill="black"
                    d="M7 12C7 2.61116 14.6112 -5 24 -5H57C73.0163 -5 86 7.98374 86 24H76C76 13.5066 67.4934 5 57 5H24C20.134 5 17 8.13401 17 12H7ZM81 29H12H81ZM7 29V12C7 2.61116 14.6112 -5 24 -5V5C20.134 5 17 8.13401 17 12V29H7ZM57 -5C73.0163 -5 86 7.98374 86 24V29H76V24C76 13.5066 67.4934 5 57 5V-5Z"
                    ></path>
                    <circle fill="black" r="3" cy="49" cx="78"></circle>
                </svg>
                </span>

                <span class="printer-page-wrapper">
                <span class="printer-page"></span>
            </span>
        </span>
        Print
        </button>
</form>


<div id="printableArea">
    @foreach ($studentsByClass as $classId => $studentsInClass)
        <div class="student-report">
            <div class="print-header">
                <h4 class="print-class">{{ $classes->where('id', $classId)->first()->class_name }} : پۆلی</h4>
                <h4 class="print-title">مانگی ({{$selectedMonth.')-'.$currentYear}}</h4> 
            </div>
            <div class="table-container">
                <table class="custom-table" dir="rtl">
                    <thead>
                        <tr>
                            <th>ژ</th>
                            <th>ناوی قوتابی</th>
                            @for ($day = 1; $day <= $endDate->day; $day++)
                                <th>{{ $day }}</th>
                            @endfor
                            <th>‌‌غ</th>
                            <th>م</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($studentsInClass as $index => $student)
                            <tr>
                            <td>{{ $index + 1 }}</td>
                                <td>{{ $student->name }}</td>
                                @for ($day = 1; $day <= $endDate->day; $day++)
                                    <td>
                                        @php
                                            $status = $attendanceStatuses[$student->id][$day] ?? null;
                                        @endphp
                                        @if ($status === 'present')
                                            ✔
                                        @elseif ($status === 'absent')
                                            غ
                                        @elseif ($status === 'excused')
                                            م
                                        @elseif ($status == 'one lesson') 
                                            <span class="one-lesson">١و</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endfor
                                <td class="total-column">{{ count(array_filter($attendanceStatuses[$student->id], fn($status) => $status === 'absent')) }}</td>
                                <td class="total-column">{{ count(array_filter($attendanceStatuses[$student->id], fn($status) => $status === 'excused')) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
</main>
</body>

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
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
    }
    .filter-group {
        display: flex;
        align-items: center;
        flex: 1;
        min-width: 200px;
    }
    .filter-label {
        margin-right: 10px;
        font-weight: bold;
    }
    .filter-select {
        flex: 1;
        padding: 8px;
        border-radius: 4px;
        border: 1px solid #ddd;
       
    }
    .dropdown-spacing {
        margin-left: 20px; /* Adjust spacing as needed */
    }
    .print-btn {
        width: 100px;
        height: 45px;
        display: flex;
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
        .printer-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 100%;
        }
        .printer-container {
        height: 50%;
        width: 100%;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        }

        .printer-container svg {
        width: 100%;
        height: auto;
        transform: translateY(4px);
        }
        .printer-page-wrapper {
        width: 100%;
        height: 50%;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        }
        .printer-page {
        width: 70%;
        height: 10px;
        border: 1px solid black;
        background-color: white;
        transform: translateY(0px);
        transition: all 0.3s;
        transform-origin: top;
        }
        .print-btn:hover .printer-page {
        height: 16px;
        background-color: rgb(239, 239, 239);
        }
        .print-btn:hover {
        background-color: rgb(239, 239, 239);
        }
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        direction: rtl;
        margin-top: 10px;
        font-size: 12px;
    }
    .custom-table td:nth-child(2) {
        white-space: nowrap;
        text-align: right;
    }
    .custom-table th, .custom-table td {
        border: 1px solid #ddd;
        padding: 6px;
        text-align: center;
    }
    .custom-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    .table-container {
        margin-bottom: 30px;
        overflow-x: auto;
    }
    .student-report {
        page-break-after: always;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .student-report:last-child {
        page-break-after: auto;
    }
    .print-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .print-title {
        text-align: right;
        color: #333;
        font-size: 1.2em;
    }
    .print-class {
        text-align: left;
        color: #333;
        font-size: 1.2em;
    }
    .one-lesson {
    color: #ffcc00; /* Choose any color you prefer */
    font-weight: bold; /* Optional styling */
    }
    .added-absent {
    color: #ff0000;
    
    font-size: 0.8em;
    vertical-align: super;
    margin-left: 2px;
    }

    .updated-absent {
    color: #ff0000;
    font-weight: bold;
    }

    .one-lesson {
    position: relative;
    }

    .one-lesson .added-absent {
    position: absolute;
    top: -5px;
    right: -5px;
    }
    @media print {
        @page {
            size: A4 landscape;
            margin: 1mm 1mm;
        }

        body {
            margin: 0;
            padding: 0 !important;
            min-width: 992px !important;
        }

        .main-content {
            padding: 0 !important;
        }
        .custom-table td:first-child {
            white-space: nowrap;
            text-align: left;
        }
        .student-report {
            page-break-after: always;
            border: none !important;
            padding: 0 !important;
            box-shadow: none !important;
        }

        .custom-table {
            font-size: 8pt;
            width: 100% !important;
        }

        .custom-table th,
        .custom-table td {
            padding: 2px !important;
        }

        .print-header {
            font-size: 10pt;
            margin-bottom: 5px;
        }

        /* Hide non-essential elements */
        .print-btn, .filters, #reportrange {
            display: none !important;
        }
        
        
    }
    @media (max-width: 768px) {
        .filters {
            flex-direction: column;
            
        }
        .filter-group {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const tables = document.querySelectorAll('.custom-table');

    tables.forEach(table => {
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            let oneLessonCount = 0;
            let additionalAbsents = 0;
            const cells = row.querySelectorAll('td');
            const absentCell = row.querySelector('td:nth-last-child(2)');

            cells.forEach(cell => {
                if (cell.textContent.trim() === '١و') {
                    oneLessonCount++;
                    if (oneLessonCount === 3) {
                        additionalAbsents++;
                        oneLessonCount = 0;
                        cell.innerHTML += '<span class="added-absent">+غ</span>';
                    }
                }
            });

            // Update the absent count cell
            if (absentCell) {
                const originalAbsent = parseInt(absentCell.textContent) || 0;
                const newAbsentCount = originalAbsent + additionalAbsents;
                absentCell.textContent = newAbsentCount;
                if (newAbsentCount > originalAbsent) {
                    absentCell.classList.add('updated-absent');
                }
            }
        });
    });
});
    function getCurrentSchoolYear() {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth(); // 0-indexed, so January is 0

        // Assuming the school year starts in September (month index 8)
        if (currentMonth >= 8) {
            return `${currentYear}-${currentYear + 1}`;
        } else {
            return `${currentYear - 1}-${currentYear}`;
        }
    }

    function printForm() {
        // Create a new window for printing
        var printWindow = window.open('', '_blank');
        
        // Get the printable content
        var printableContent = document.getElementById('printableArea').innerHTML;
        
        // Get the current school year
        var currentSchoolYear = getCurrentSchoolYear();
        
        // Write the content to the new window
        printWindow.document.write('<html><head><title>ڕاپۆرتی ئامادەبوونی قوتابی</title>');
        printWindow.document.write('<style>');
        printWindow.document.write(`
            @page {
                size: A4 landscape;
                margin: 0; /* Reduced left and right margins */
            }
                 
            body { font-family: Arial, sans-serif; font-size:15px; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;}
            .student-report { page-break-after: always; page-break-inside: avoid; }
            .student-report:last-child { page-break-after: auto; }
            .one-lesson {color: #ffcc00; font-weight: bold; }
            .custom-table { width: 100%; border-collapse: collapse; direction: rtl; margin-top: 0px; font-size: 12px; }
            .custom-table th, .custom-table td { border: 1px solid black; padding: 2px; text-align: center; min-width:20px;}
            .custom-table th {  background-color: #edbebe; color: #ba0404;  font-weight: bold; }
            .custom-table td:first-child { white-space: nowrap; text-align: center;}
            .custom-table td:nth-child(2) { white-space: nowrap; text-align: right; width: 160px; }
            .custom-table th:nth-last-child(1), 
            .custom-table td:nth-last-child(1) { width: 25px;}
            .custom-table th:nth-last-child(2), 
            .custom-table td:nth-last-child(2) { width: 25px; }
            .table-container { margin-bottom: 30px; }
            .print-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
            .print-title { text-align: right; margin-bottom: 0px; }
            .print-class { text-align: left; margin-bottom: 0px; }
            .school-year-header { display: flex; justify-content: space-between; margin-bottom: 5px; font-weight: bold; }
            .school-year { text-align: left; }
            .school-name { text-align: right; }
            .header-line { border: none; border-top: 1px solid #000; margin: 5px 0; }
           /* Manager's Info Section */
        .manager-info { 
            position: fixed; 
            bottom: 80px; 
            left: 80px; 
            display: flex; 
            flex-direction: column; 
            align-items: flex-start; 
            font-size: 12px;
            font-weight:bold;
            
        }
        .manager-name { text-align: left; }
        .manager-title { margin-top: 5px; width: 100%; text-align: center; }
            
                    `);
        printWindow.document.write('</style></head><body>');

        // Add the new header to each student report
        var studentReports = printableContent.split('<div class="student-report">');
        var modifiedContent = studentReports.map(function(report, index) {
            if (index === 0) return report; // Skip the first split as it's empty
            return '<div class="student-report">' +
                   '<div class="school-year-header">' +
                   '<span class="school-year">' + currentSchoolYear + ' /ساڵی خوێندنی</span>' +
                   '<span class="school-name">قوتابخانەی مارگرێت ی بنەڕەتی - 201795</span>' +
                   '</div>' +
                   '<hr class="header-line">' +
                   report+
                   '</div>';
        }).join('');

        printWindow.document.write(modifiedContent);
       
        printWindow.document.write(`
            <div class="manager-info">
                <div class="manager-name">هەرێز ئازاد حسن محمد</div>
                <div class="manager-title">بەڕێوەبەر</div>
            </div>
        `);
        printWindow.document.write('<style>');
        printWindow.document.write(`  .added-absent {
                                        color: #ff0000 !important;
                                        -webkit-print-color-adjust: exact;
                                        print-color-adjust: exact;
                                    }

                                    .updated-absent {
                                        color: #ff0000 !important;
                                        -webkit-print-color-adjust: exact;
                                        print-color-adjust: exact;
                                    }

                                    .one-lesson {
                                        color: #ffcc00 !important;
                                        -webkit-print-color-adjust: exact;
                                        print-color-adjust: exact;
                                    }
                                    `);
        printWindow.document.write('</body></html>');
        
        // Wait for content to be written
        printWindow.document.close();
        printWindow.focus();
        
        // Print the window
        printWindow.print();
        
        // Close the print window after printing
        printWindow.close();
    }
    </script>


<script>
    $(function() {
    $('#reportrange').daterangepicker({
        locale: {
            format: 'YYYY-MM' // Format to display only year and month
        },
        showDropdowns: true,
        minYear: 2000,
        maxYear: parseInt(moment().format('YYYY'),10),
        startDate: moment().startOf('month'),
        endDate: moment().endOf('month'),
        autoApply: true,
        linkedCalendars: false,
        singleDatePicker: false,
    }, function(start, end, label) {
        // Set the hidden input values with the formatted months
        $('#start_date').val(start.format('YYYY-MM-01'));
        $('#end_date').val(end.endOf('month').format('YYYY-MM-DD'));

        // Trigger form submit if needed or add additional actions
        $('#classSelectForm').submit();
    });

    // Customize the display text in the date range picker
    $('#reportrange span').html(moment().startOf('month').format('YYYY-MM') + ' - ' + moment().format('YYYY-MM'));
});
</script>

@endsection