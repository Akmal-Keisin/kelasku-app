@extends("Auth.Layout.index")
@section("title")
    Login
@endsection
@section("content")
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card p-5 m-3">
                    <h1 class="text-center">Login</h1>
                    @if ($msg = Session::get("failed"))
                        <div class="alert alert-danger">
                            {{ $msg }}
                        </div>
                    @endif
                    <form action="{{ env('APP_URL') }}/auth/login" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email :</label>
                            <input type="text" class="form-control" name="email" placeholder="Your Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password :</label>
                            <input type="password" class="form-control" name="password" placeholder="Your Email" required>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
