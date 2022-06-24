@extends('BaseLayout.index')
@section('title') Edit @endsection
@include('Dashboard.Layout.navbar')
@section('container')
<div class="container">
    <div class="card p-5 m-5">
        <h1 class="mb-3">Edit Data</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="/kelasku/{{ $user->id }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama :</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Class :</label>
                <input type="text" class="form-control" name="class" value="{{ old('class', $user->class) }}">
            </div>
            <div class="mb-3">
                <label class="form-label" for="photo">Photo :</label>
                <input type="file" name="photo" class="form-control">
            </div>
            <div class="mb-3">
                <label for="bio" class="form-label">Bio :</label>
                <textarea name="bio" id="bio" cols="30" rows="10" class="form-control">{{ old('class', $user->bio) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone :</label>
                <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password :</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Pasword Confirmation :</label>
                <input type="password" class="form-control" name="password_confirmation">
            </div>
            <div class="mb-3">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
