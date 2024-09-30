@extends('template.admin_home')
  
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include your custom CSS here -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        .card {
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            transition: background-color 0.3s ease;
        }
        .btn-danger:hover {
            background-color: #bd2130;
            border-color: #b21f2d;
        }
        .content-table thead th {
            background-color: #343a40;
            color: #fff;
            text-align: center;
        }
        .content-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .content-table tbody tr:hover {
            background-color: #e9ecef;
            transition: background-color 0.3s ease;
        }
        h3, h2 {
            color: #343a40;
            text-align: center;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }
        .table-striped tbody tr:hover {
            background-color: #f1f1f1;
        }
        .navbar {
            background-color: #343a40;
            color: #fff;
            padding: 10px 20px;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
        }
        .navbar a:hover {
            color: #ccc;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
            border-top: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Navbar, header, etc. -->
        <div class="navbar mb-4">
            <div class="d-flex justify-content-between align-items-center w-100">
                
                @auth
                    <div>
                        <form action="{{ route('auth.logout') }}" method="post">
                            @method("delete")
                            @csrf
                            <button class="btn btn-danger">Se déconnecter</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3>Semestres</h3>
            </div>
            <div class="card-body">
                <table id="demo-foo-addrow" class="table content-table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Moyenne</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($semestre as $res)
                           
                                <tr>
                                    <td class="footable-sortable">
                                        <a class="dropdown-item" href="{{ route('etudiant.note', ['ids' => $res->id_semestre, 'etu' => $num]) }}">
                                            {{ $res->semestre }}
                                        </a>
                                    </td>
                                    <td>{{ $res->moyenne }}</td>
                                </tr>
                          
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="footer mt-4">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Tous droits réservés.</p>
        </div>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
@endsection
