@extends('template.admin_home')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Liste des Étudiants</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        h1 {
            color: #343a40;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-group label {
            color: #495057;
        }
        .form-control {
            border-radius: 0.25rem;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 0.25rem;
            transition: background-color 0.2s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        table {
            margin-top: 20px;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #343a40;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Liste des Étudiants</h1>
        <form method="post" action="{{ route('admin.filtre') }}">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="id_promotion">Promotion</label>
                    <select id="id_promotion" name="promotion" class="form-control">
                        <option value="0">Tous</option>
                        @foreach($promotion as $promotion)
                            <option value="{{ $promotion->id_promotion }}">{{ $promotion->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Filtrer par nom">
                </div>
            </div>
            <button type="submit" id="filter" class="btn btn-primary">Filtrer</button>
        </form>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Promotion</th>
                    <th>Action</th>
                    
                </tr>
            </thead>
            <tbody id="student-table">
                @foreach($etudiants as $student)
                <tr>
                    <td><a class="dropdown-item" href="{{ url('/semestre/'.$student->numetu) }}">{{ $student->numetu }}</a></td>
                    
                    <td>{{ $student->nom }}</td>
                    <td>{{ $student->prenom }}</td>
                    <td>{{ $student->prom }}</td>
                    <td class="footable-sortable">
                        <a class="dropdown-item" href="{{ route('licence.etudiant', ['ids' => $student->numetu]) }}">
                            <p>info</p>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
</body>
</html>
@endsection
