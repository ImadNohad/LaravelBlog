@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-12">
                <h1>Add Categorie</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="m-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/admin/categories" method="POST">
                    @csrf
                    <div class="form-outline mb-4">
                        <label class="form-label" for="txtNom">Nom</label>
                        <input type="text" name="nom" id="txtNom" class="form-control"
                            value="{{ old('nom') }}" />
                    </div>

                    <div class="form-check d-flex">
                        <label class="form-label" for="cbActive">Active</label>
                        <input class="form-check-input" name="active" type="checkbox" id="cbActive" />
                    </div>

                    <button type="submit" class="btn btn-primary btn-inline mb-4">Save changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection
