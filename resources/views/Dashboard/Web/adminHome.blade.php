@extends('BaseLayout.index')
@section('title') Home @endsection
@include('Dashboard.Layout.navbar')
@section('container')
<div class="container">
    <div class="card p-5 m-5">
        <div class="d-flex align-items-center justify-content-between">
            <h1 class="mb-3">Admin List</h1>
            @if ($msg = Session::get('success'))
                <div class="alert alert-success">{{ $msg }}</div>
            @endif
            <div class="mb-3">
                <a href="admin/create" class="btn btn-primary">Add+</a>
            </div>
        </div>
        <table class="table table-responsive table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admin as $item)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        <a href="admin/{{ $item->id }}/edit" class="btn btn-warning">Edit</a>
                        <form action="/admin/{{ $item->id }}" method="POST" class="d-inline-block">
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
