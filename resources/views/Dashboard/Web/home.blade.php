@extends('BaseLayout.index')
@section('title') Home @endsection
@include('Dashboard.Layout.navbar')
@section('container')
<div class="container">
    <div class="card p-5 m-5">
        <div class="d-flex align-items-center justify-content-between">
            <h1 class="mb-3">User List</h1>
            @if ($msg = Session::get('success'))
                <div class="alert alert-success">{{ $msg }}</div>
            @endif
            <div class="mb-3">
                <a href="kelasku/create" class="btn btn-primary">Add+</a>
            </div>
        </div>
        <table class="table table-responsive table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Phone Number</th>
                    <th>Total Like</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->class }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->liked_total }}</td>
                    <td>
                        <a href="kelasku/{{ $user->id }}" class="btn btn-success">Lihat</a>
                        <a href="kelasku/{{ $user->id }}/edit" class="btn btn-warning">Edit</a>
                        <form action="/admin/{{ $user->id }}" method="POST" class="d-inline-block">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger" onclick="return confirm('Are You Sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
