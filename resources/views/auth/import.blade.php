@extends('template.admin_home')

@section('content')
    <div class="col-md-5">
        <div class="card">
            @if(session('errtm'))
                @foreach(session('errtm') as $message)
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @endforeach
            @endif

            @if(session('message'))
                <div class="alert alert-success" role="alert">
                    @foreach(session('message') as $message)
                        {{ $message }}
                    @endforeach
                </div>
            @endif

            @if(session('cath'))
                @foreach(session('cath') as $message)
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @endforeach
            @endif

            <div class="card-body">
                <div class="card-title" >
                    <h3> Importation donne </h3>
                </div>
                <form action="{{ url('/admin/import/data') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label> Note </label>
                        <input type="file" placeholder="note" class="form-control"
                               id="exampleInputPassword1"
                               name="note">
                        @error("note")
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label> Config_note </label>
                        <input type="file" placeholder="Congig_note" class="form-control @error("config_note") is-invalid @enderror" id="exampleInputPassword1" name="config_note">
                        @error("config_note")
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                                <button type="submit" class="btn btn-primary">Importer</button>
                </form>
            </div>
        </div>
    </div>
    
    @endsection