@extends('template.admin_home')

@section('content')
@if(session('success'))
  <div class="alert alert-success">
     {{ session('success') }}
  </div>
  @endif

  @if(session('error'))
  <div class="alert alert-danger">
     {{ session('error') }}
  </div>
  @endif

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
        }
        .content-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .content-table tbody tr:hover {
            background-color: #e9ecef;
        }
        h3, h2 {
            color: #343a40;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }
        .table-striped tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Navbar, header, etc. -->
        <div class="row mb-4">
            <div class="col-md-12">
                {{-- @auth
                    <div class="d-flex justify-content-between align-items-center">
                        <div></div>
                        <div>
                            <form action="{{ route('auth.logout')}}" method="post">
                                @method("delete")
                                @csrf
                                <button class="btn btn-danger">Se déconnecter</button>
                            </form>
                        </div>
                    </div>
                @endauth --}}
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Inserer note</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.insert_note') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="etudiant">Etudiant</label>
                            <input type="text" class="form-control" id="etudiant" name="etudiant" value="1931" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="id_matiere">Matiere</label>
                            <select id="id_matiere" name="matiere" class="form-control">
                                @foreach($m as $b)
                                    <option value="{{ $b->id_matiere }}">{{ $b->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="duree">Note</label>
                            <input type="number" class="form-control" id="note" name="note" step="0.01" required>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
                </form>
            </div>
        </div>
              @if(session('message'))
                  <p>{{session('message') }}</p>
              @endif
        <div class="mt-5">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
@endsection
