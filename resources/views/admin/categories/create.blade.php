@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-12">
                <h1>Add Article</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/admin/articles" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-outline mb-4">
                        <label class="form-label" for="txtTitle">Title</label>
                        <input type="text" name="title" id="txtTitle" class="form-control"
                            value="{{ old("title") }}" />
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="txtContent">Article Body</label>
                        <textarea class="form-control" name="content" id="txtcontent" rows="20">{{ old("title") }}</textarea>
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="fImage">Article Image</label><br>
                        <input type="file" name="image" id="fImage" class="form-control" />
                    </div>

                    <input type="hidden" name="user" value="{{ auth()->user()->id }}">

                    <button type="submit" class="btn btn-primary btn-block mb-4">Save changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection
