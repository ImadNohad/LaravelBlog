@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Edit Categorie</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/admin/categories/{{ $category->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-outline mb-4">
                        <label class="form-label" for="txtNom">Nom</label>
                        <input type="text" name="nom" id="txtNom" class="form-control"
                            value="{{ $category->nom }}" />
                    </div>

                    {{-- <div class="form-outline mb-4">
                        <input type="checkbox" name="active" id="cbActive" checked="{{ $category->active }}" />
                    </div> --}}

                    <div class="form-check">
                        <label class="form-label" for="cbActive">Active</label>
                        <input class="form-check-input" name="active" type="checkbox" id="cbActive"
                            {{ $category->active ? 'checked' : ''}}>
                    </div>

                    <button type="submit" class="btn btn-primary btn-inline mb-4">Save changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection
