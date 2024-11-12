@extends('layout')

@section('content')
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
            padding: 0.6rem 0.8rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 90px;
            margin: 5px 0 5px 0;
            text-align: center;
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

        }
        .addclass-btn {
            
            margin: 35px 0 10px 0;
            width: 150px;
            height: 45px;
            align-items: center;
            background-color: white;
            border: 1px solid rgb(213, 213, 213);
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            overflow: hidden;
            font-weight: 500;
            box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.065);
            transition: all 0.3s;
            
        
        }
        .addclass-btn:hover {
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
    .addclass-btn {
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
                width: 60px;
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

            

            .move-students-container {
                align-items: stretch;
                margin-top: 1rem;
            }
            .custom-table th:nth-child(1),
            .custom-table td:nth-child(1) {
                display: none;
            }
            
        }
        

    </style>
    <div class="main-content">
<div class="actions-container">
<!-- Add Class Button to Open Modal -->
<button class="addclass-btn" data-bs-toggle="modal" data-bs-target="#addClassModal">+ Add Class</button>
@include('addclass_modal')
</div>

<table class="custom-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Class Name</th>
            <th>Number of Students</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($classes as $index => $class)
        <tr class="active-row">
            <td data-label="#">{{ $index + 1 }}</td>
            <td data-label="Class Name">{{$class->class_name}}</td>
            <td data-label="Number of Students">{{$students->whereIn("class_id", $class->id)->count()}}</td>
            <td data-label="Actions">
                <a href="#renameClassModal{{$class->id}}" data-bs-toggle="modal" class="btn btn-success">Rename</a>
                <a href="#deleteClassModal{{$class->id}}" data-bs-toggle="modal" class="btn btn-danger">Delete</a>
            </td>
            @include('editclass_modal')
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@endsection