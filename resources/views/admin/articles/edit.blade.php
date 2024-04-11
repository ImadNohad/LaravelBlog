@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-12">
                <h1>Edit Article</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/admin/articles/{{ $article->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-outline mb-4">
                        <h3 class="form-label">Categories</h3>
                        <div class="container">
                            @php $count = 6; @endphp
                            @foreach ($categories as $cat)
                                @if ($loop->index % $count === 0 || $loop->first)
                                    <div class="row justify-content-between">
                                @endif
                                <div class="col">
                                    <input name="category[]" type="checkbox" value={{ $cat->id }}
                                        {{ $article->categories->contains($cat->id) ? 'checked' : '' }} />
                                    <label class="form-label">{{ $cat->nom }}</label>
                                </div>
                                @if ($loop->index % $count === ($count - 1) || $loop->last)
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="form-outline mb-4">
                        <h3 class="form-label" for="txtTitle">Title</h3>
                        <input type="text" name="title" id="txtTitle" class="form-control" 
                        value="{{ $article->title }}" />
                    </div>

                    <div class="form-outline mb-4">
                        <h3 class="form-label" for="txtContent">Article Body</h3>
                        <textarea class="form-control" name="contenu" id="txtcontent" rows="20">{{ $article->contenu }}</textarea>
                    </div>

                    <div class="form-outline mb-4">
                        <h3 class="form-label" for="fImage">Article Image</h3><br>
                        <img width="200" src="{{ asset('storage/images/' . $article->imageURL) }}" alt="">
                        <input type="file" name="image" id="fImage" class="form-control" />
                    </div>

                    <div class="form-outline mb-4">
                        <h3 class="form-label" for="txtTags">Tags</h3>
                        <input type="text" name="tags" id="txtTags" class="form-control"
                            value="{{ $article->tags()->implode('nom', ',') }}" />
                    </div>

                    <input type="hidden" name="user" value="{{ $article->user->id }}">

                    <button type="submit" class="btn btn-primary btn-block mb-4">Save changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection
