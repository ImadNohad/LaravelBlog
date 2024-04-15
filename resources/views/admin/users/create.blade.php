@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Add User</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/admin/users/" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-outline mb-4">
                        <h3 class="form-label">Type</h3>
                        <select name="type" class="form-control">
                            <option value="">Select category</option>
                            <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="auteur" {{ old('type') == 'auteur' ? 'selected' : '' }}>Author</option>
                            <option value="visiteur" {{ old('type') == 'visiteur' ? 'selected' : '' }}>Visitor</option>
                        </select>
                    </div>

                    <div class="form-outline mb-4">
                        <h3 class="form-label" for="txtName">Name</h3>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                    </div>

                    <div class="form-outline mb-4">
                        <h3 class="form-label" for="txtEmail">Email</h3>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" />
                    </div>

                    <div class="form-outline mb-4">
                        <h3 class="form-label" for="txtContent">User Bio</h3>
                        <textarea class="form-control" name="bio" rows="10">{{ old('bio') }}</textarea>
                    </div>

                    <div class="form-outline mb-4">
                        <h3 class="form-label" for="fImage">User Image</h3><br>
                        {{-- <img width="200" src="{{ asset('storage/images/' . $user->imageURL) }}" alt=""> --}}
                        <input type="file" name="image" class="form-control" />
                    </div>

                    <div class="form-outline mb-4">
                        <h3 class="form-label" for="txtPassword">Password</h3>
                        <input class="form-control" type="password" name="password" />
                    </div>

                    <div class="form-outline mb-4">
                        <h3 class="form-label" for="txtPassword2">Confirm Password</h3>
                        <input class="form-control" type="password" name="password_confirmation" />
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mb-4">Save changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection
