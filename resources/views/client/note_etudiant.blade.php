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
        }
        .card {
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            font-size: 1.5rem;
            text-align: center;
        }
        .card-header p {
            margin: 0;
            color: #fff;
            font-size: 1rem;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
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
        .table-footer {
            font-weight: bold;
            background-color: #f1f1f1;
        }
        .result-summary {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Navbar, header, etc. -->
        <div class="row mb-4">
            <div class="col-md-12">
                @auth
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <!-- Optional content can go here -->
                        </div>
                        <div>
                            <form action="{{ route('auth.logout') }}" method="post">
                                @method("delete")
                                @csrf
                                <button class="btn btn-danger">Se déconnecter</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3>Résultats</h3>
                <p>Nom : {{ $nom }}</p>
                <p>Prénom : {{ $prenom }}</p>
                <p>Naissance : {{ $dtn }}</p>
                <p>Numéro d'inscription : {{ $num }}</p>
            </div>
            <div class="card-body">
                <table id="demo-foo-addrow" class="table content-table table-striped">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Nom Matière</th>
                            <th>Crédits</th>
                            <th>Note</th>
                            <th>Résultat</th>
                            <th>Session</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($note['notes'] as $res)
                            <tr>
                                <td>{{ $res->code }}</td>
                                <td>{{ $res->nom_matiere }}</td>
                                <td>{{ $res->credit_obtenu }}</td>
                                <td>{{ $res->note }}</td>
                                <td>{{ $res->resultat }}</td>
                                {{-- <td>{{ $res->session }}</td> --}}
                            </tr>
                        @endforeach
                        <tr class="table-footer">
                            <td colspan="2">SEMESTRE {{ $res->id_semestre }}</td>
                            <td>{{ $credit_obtenu }}</td>
                            <td>{{ $moyenne }}</td>
                            <td colspan="2">. . .</td>
                            {{-- <td>{{ $session }}</td> --}}
                        </tr>
                    </tbody>
                </table>
                <div class="result-summary">
                    {{-- <h3>Résultat:{{ $session }}</h3> --}}
                    <p>Crédits: {{ $credit_obtenu }}</p>
                    <p>Moyenne générale: {{ $moyenne }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
@endsection
