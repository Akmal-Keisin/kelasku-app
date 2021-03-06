@extends('BaseLayout.index')
@section('container')
<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="{{ env("APP_URL") }}">{{ (Request::is('login')) ? 'Login' : 'Register' }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('auth/login') ? 'active' : '' }}" aria-current="page" href="{{ env('APP_URL') }}}}/auth/login">Login</a>
          </li>
        </ul>
      </div>
    </div>
</nav>
@yield('content')
@endsection
