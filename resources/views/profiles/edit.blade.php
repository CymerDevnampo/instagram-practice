@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="/profile/{{ $user->id }}" enctype="multipart/form-data" method="post">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-8 offset-2">

                    <div class="row">
                        <h1>Edit Profile</h1>
                    </div>

                    <div class="row">
                        <label for="image" class="col-md-4 col-form-label">Profile Image</label>
                        <input class="form-control-file" type="file" id="image" name="image">

                        @error('image')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label">Name</label>

                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') ?? $user->name }}" name="name"  autocomplete="name"
                            autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label">Title</label>

                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') ?? $user->profile->title }}" name="title" required autocomplete="title"
                            autofocus>

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label">Description</label>

                        <input id="description" type="text"
                            class="form-control @error('description') is-invalid @enderror"
                            value="{{ old('description') ?? $user->profile->description }}" name="description" required
                            autocomplete="description" autofocus>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="url" class="col-md-4 col-form-label">Url</label>

                        <input id="url" type="text" class="form-control @error('url') is-invalid @enderror"
                            value="{{ old('url') ?? $user->profile->url }}" name="url" required autocomplete="url"
                            autofocus>

                        @error('url')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row pt-4">
                        <button class="btn btn-primary">Save Profile</button>
                        <a href="/profile/{{ $user->profile->id }}" class="btn btn-primary ml-2">Cancel</a>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
