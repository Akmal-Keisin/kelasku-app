<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#">Admin Dashboard</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{ (Request::is('kelasku*')) ? 'active' : '' }}" href="{{ env('APP_URL') }}/kelasku">User List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ (Request::is('admin')) ? 'active' : '' }}" href="{{ env('APP_URL') }}/admin">Admin List</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <form action="{{ env('APP_URL') }}/auth/logout" method="POST" class="nav-item">
                @csrf
                <button type="submit" class="btn nav-link nav-item">Logout</button>
            </form>
        </ul>
      </div>
    </div>
  </nav>
