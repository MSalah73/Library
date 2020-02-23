@extends('layouts.app')

@section('content')
<div class="container">
     <form method="POST" action="/book/{{ $book->id }}"enctype="multipart/form-data" >
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-8 offset-2">
                <div class='row'>
                    <h1>Edit Book's author</h1>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label">Title</label>

                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $book->title }}" required autocomplete="title" autofocus disabled>

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="author" class="col-md-4 col-form-label">Author</label>

                        <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') ?? $book->author }}" required autocomplete="author" autofocus>

                        @error('author')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>                  
                    <div class="row pt-4">
                        <button class="btn btn-primary">Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection