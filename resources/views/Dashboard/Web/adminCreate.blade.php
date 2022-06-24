@extends('BaseLayout.index')
@section('title') Create @endsection
@include('Dashboard.Layout.navbar')
@section('container')
<div class="container">
    <div class="card p-5 m-5">
        <h1 class="mb-3">Tambah Data</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ env('APP_URL') }}/admin" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
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
                <button class="btn btn-primary" type="submit">Add</button>
            </div>
        </form>
    </div>
</div>
@endsection
