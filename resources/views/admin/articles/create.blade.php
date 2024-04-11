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
                        <h3 class="form-label">Categories</h3>
                        <div class="container">
                            @php $count = 6; @endphp
                            @foreach ($categories as $cat)
                                @if ($loop->index % $count === 0 || $loop->first)
                                    <div class="row justify-content-between">
                                @endif
                                <div class="col">
                                    <input name="category[]" type="checkbox" value={{ $cat->id }} />
                                    <label class="form-label">{{ $cat->nom }}</label>
                                </div>
                                @if ($loop->index % $count === $count - 1 || $loop->last)
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="txtTitle">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" />
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="txtContent">Article Body</label>
                        <textarea class="form-control" name="contenu" rows="20">{{ old('contenu') }}</textarea>
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="fImage">Article Image</label><br>
                        <input type="file" name="image" class="form-control" />
                    </div>

                    <div class="form-outline mb-4">
                        <h3 class="form-label" for="txtTags">Tags</h3>
                        <input type="text" name="tags" class="form-control" value="{{ old('tags') }}" />
                    </div>

                    <input type="hidden" name="user" value="{{ auth()->user()->id }}">

                    <button type="submit" class="btn btn-primary btn-block mb-4">Save changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection
