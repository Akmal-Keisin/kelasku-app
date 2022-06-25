@extends('Auth.Layout.index')
@section('title')
    Login
@endsection
@section('content')
    <div class="container">
        <div class="card p-5 m-5 w-50 mx-auto">
            <h1 class="mb-3">Login</h1>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                       <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @elseif($msg = Session::get('failed'))
            <div class="alert alert-danger">
                {{ $msg }}
            </div>
            @endif
            <form action="{{ env("APP_URL") }}/auth/login" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Your Email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password :</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Your Password">
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection
