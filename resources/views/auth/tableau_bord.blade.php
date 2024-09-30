@extends('template.admin_home')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Liste des Étudiants</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        h1 {
            color: #343a40;
            margin-bottom: 30px;
            text-align: center;
            font-weight: bold;
            font-size: 2.5rem;
        }
        .form-group label {
            color: #495057;
            font-weight: 500;
        }
        .form-control {
            border-radius: 0.25rem;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 0.25rem;
            transition: background-color 0.3s, transform 0.2s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            transform: translateY(-2px);
        }
        .table-wrapper {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            overflow: hidden;
            background-color: white;
            padding: 20px;
        }
        table {
            margin-top: 20px;
            border-collapse: separate;
            width: 100%;
            border-spacing: 0;
        }
        table th, table td {
            padding: 15px;
            text-align: left;
        }
        table th {
            background-color: #343a40;
            color: white;
            font-weight: bold;
            position: sticky;
            top: 0;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #e9ecef;
        }
        table tr {
            transition: background-color 0.2s;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tableau de bord des Étudiants</h1>
        <div class="table-wrapper">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Etudiants total</th>
                        <th>Admis en licence</th>
                        <th>Non-Admis en licen</th>
                    </tr>
                </thead>
                <tbody id="student-table">
                    <tr>
                         <td>{{ $nombre }}</td>
                         <td class="footable-sortable">
                            <a class="dropdown-item" href="{{ route('admis.etudiant') }}">{{ $admis }}</a>     
                        </td>
                        <td class="footable-sortable">
                            <a class="dropdown-item" href="{{ route('non_admis.etudiant') }}">{{ $non_admis }}</a>     
                        </td>
                        
                    </tr>
                </tbody>
                
            </table>
           
        </div>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
</body>
</html>
@endsection
