@extends('BaseLayout.index')
@section('title') Detail User @endsection
@include('Dashboard.Layout.navbar')
@section('container')
<style>
    td {
        max-width: 400px;
    }
</style>
    <div class="container">
        <div class="card p-5 m-5 mb-5">
            <h1 class="mb-3">Detail User</h1>
            <table class="table-responsive table table-striped">
                <thead>
                    <tr>
                        <th>Row</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>photo</th>
                        <td><img style="max-width : 200px" src="{{ asset($user->photo) }}" alt="{{ $user->name }}"></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ $user->class }}</td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td>{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <th>Bio</th>
                        <td>{{ $user->bio }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
