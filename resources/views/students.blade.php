
@extends('layout')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        :root {
            --primary-color: #009879;
            --primary-dark: #007d63;
            --primary-light: #00b894;
            --text-color: #333;
            --background-color: #f4f4f4;
            --white: #ffffff;
            --gray-light: #e0e0e0;
            --gray: #808080;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: var(--white);
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .main-content {
            padding: 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .user-greeting {
            margin-bottom: 1rem;
        }

        .filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
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
            border: 1px solid var(--gray-light);
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
            background-color: var(--white);
            border-radius: 8px;
            padding: 1rem;
            min-width: 200px;
            flex: 1;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-card.highlight {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .highlight .stat-label {
            color: var(--primary-light);
        }

       
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 2rem;

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

        .label-top{
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: block;

        }
        

        .class-dropdown {
            display: flex;
            align-items: center;
            gap: 1rem; /* Adds space between the dropdown and the button */
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 80px;
            margin: 5px 0 5px 0;
            transition: background-color 0.3s ease;
        }

        .btn-secondary {
            background-color: var(--gray);
            color: var(--white);  
        }

        .btn-success {
            background-color: var(--primary-light);
            color: var(--white);
        }
        .btn-add {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 150px;
            margin: 5px 0 5px 0;
            background-color: var(--primary-light);
            color: var(--white);
            transition: background-color 0.3s ease;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: var(--white);
        }

        .actions-container {
            display: flex;
            justify-content: flex-start; /* Align button to the left */
            margin-bottom: -80px;
        }
        .addstudent-btn {
            width: 150px;
            height: 45px;
            align-items: center;
            justify-content: center;
            background-color: white;
            border: 1px solid rgb(213, 213, 213);
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            overflow: hidden;
            font-weight: 500;
            box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.065);
            transition: all 0.3s;
            margin-top: 35px;
        
        }
        .addstudent-btn:hover {
            background-color: rgb(239, 239, 239);
        }
        .move-students-container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        @media (max-width: 768px) {
            .main-content {
            padding: 0.2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .actions-container {
        justify-content: center; /* Align button to the left */
        margin-bottom: 15px;
       
    }
    .addstudent-btn {
            width: 100%; /* Full width on mobile */
            margin-top: 10px;
        }
        .custom-table th,td {
            font-size: 0.8rem;
        }
            .filters {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
            }

            .stats-container {
                flex-direction: column;
            }

            .stat-card {
                width: 100%;
            }

            .btn {
                padding: 0.4rem 0.2rem;
                font-size: 0.8rem;
                width: 50px;
                text-align: center;
            }

            .class-dropdown {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .class-dropdown select, .class-dropdown button {
                width: 100%;
            }
            #searchInput{
                display: none;
            }

            .move-students-container {
                align-items: stretch;
                margin-top: 1rem;
            }
            .custom-table th:nth-child(2),
            .custom-table td:nth-child(2) {
                display: none;
            }
            
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
    </style>
</head>
<body>
<main class="main-content">
    
        
<div class="actions-container">
        <button class="addstudent-btn" type="submit" data-bs-toggle="modal" data-bs-target="#addStudentModal">+&nbsp;Add Student</button>
        @include('addstudent_modal')
</div>
  

       <!-- Bulk Move Form -->
    <form action="{{ route('bulkAssignStudents') }}" method="POST" id="bulkAssignForm" onsubmit="return validateForm()">
    @csrf
    <div class="move-students-container">
        
        <label class="label-top">Move Selected Students</label>
        <!-- Dropdown to select new class and move button beside it -->
        <div class="class-dropdown" id="classDropdownContainer">
        
            <input type="text" id="searchInput" class="filter-select" placeholder="Search students..." onkeyup="filterStudents()">
        
    <select class="filter-select bulkmoveinput" id="class_id" name="class_id" required>
                <option value="">Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary" id="moveButton" disabled>Move</button>
        </div>
    
    </div>
    
    <table class="custom-table">
        <thead>
            <tr>
                <th>
                    <label>
                        <input type="checkbox" id="checkAll" onclick="toggleAllCheckboxes(this)"> <!-- Check All checkbox -->
                    </label>
                </th>
                <th onclick="sortTable(1)"># <span class="sort-icon unsorted" data-column="1"></span></th>
                <th onclick="sortTable(2)">Student Name <span class="sort-icon unsorted" data-column="2"></th>
                <th onclick="sortTable(3)">Current Class <span class="sort-icon unsorted" data-column="3"></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $index => $student)
            <tr class="active-row" onclick="rowClicked(event, this)">
                <td>
                    <label>
                        <input type="checkbox" class="student-checkbox" name="student_ids[]" value="{{ $student->id }}" onchange="toggleMoveButton(event)">
                    </label>
                </td>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $classes->where('id', $student->class_id)->pluck('class_name')->first() ?? 'Unassigned' }}</td>
            </form><td>
                    <a href="#renameStudentModal{{$student->id}}" data-bs-toggle="modal" class="btn btn-success">Edit</a>
                    <a href="#deleteStudentModal{{$student->id}}" data-bs-toggle="modal" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            @include('editstudent_modal')
            @endforeach
        </tbody>
    </table>


    
    
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
                
                if (!isNaN(cellA) && !isNaN(cellB)) {
                    return sortDirection[columnIndex] ? cellA - cellB : cellB - cellA;
                }
                return sortDirection[columnIndex]
                    ? cellA.localeCompare(cellB)
                    : cellB.localeCompare(cellA);
            });

            sortedRows.forEach(row => table.appendChild(row));
            updateSortIndicators(columnIndex);
        }

        function updateSortIndicators(columnIndex) {
            const headers = document.querySelectorAll(".custom-table th .sort-icon");
            headers.forEach((header) => {
                const headerColumnIndex = header.getAttribute('data-column');
                if (headerColumnIndex == columnIndex) {
                    header.className = `sort-icon ${sortDirection[columnIndex] ? 'asc' : 'desc'}`;
                } else {
                    header.className = 'sort-icon unsorted';
                }
            });
        }

        // Existing JavaScript functions...
</script>
<script>
    function filterStudents() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.custom-table tbody tr');

        rows.forEach(row => {
            const studentName = row.cells[2].textContent.toLowerCase();
            if (studentName.includes(searchInput)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
<script>
    function validateForm() {
        const checkboxes = document.querySelectorAll('.student-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Please select at least one student to move.');
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }

    // Reset all checkboxes and dropdown on page load
    window.onload = function() {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        const moveButton = document.getElementById('moveButton');
        const checkAll = document.getElementById('checkAll');

        // Uncheck all checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.checked = false; // Ensure all checkboxes are unchecked on page load
        });

        // Reset class dropdown to default
        const classDropdown = document.getElementById('class_id');
        classDropdown.selectedIndex = 0; // Select the first option (which is "Select Class")

        toggleMoveButton(); // Update button visibility
        checkAll.checked = false; // Ensure "Check All" is unchecked on page load
    };

    // Handle checkbox toggling for each row
    function rowClicked(event, row) {
        // Ensure that clicking the checkbox itself doesn't trigger the row click event
        if (event.target.tagName === 'INPUT') return;
        
        const checkbox = row.querySelector('.student-checkbox');
        checkbox.checked = !checkbox.checked; // Toggle the checkbox when row is clicked
        toggleMoveButton(); // Update the move button visibility based on checkbox status
    }

    // Enable or disable the "Move" button based on checkbox selection
    function toggleMoveButton() {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        const moveButton = document.getElementById('moveButton');
        const checkAll = document.getElementById('checkAll');

        // Check if any checkbox is selected
        const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

        // Enable or disable the move button
        moveButton.disabled = !anyChecked;

        // Check or uncheck "Check All" checkbox
        checkAll.checked = checkboxes.length > 0 && Array.from(checkboxes).every(checkbox => checkbox.checked);
    }

    // Toggle all checkboxes based on "Check All" checkbox status
    function toggleAllCheckboxes(checkAllCheckbox) {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = checkAllCheckbox.checked;
        });
        toggleMoveButton(); // Update button visibility
    }
</script>
</body>
</html>
@endsection