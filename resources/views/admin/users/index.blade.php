@extends('templates.main')

@section('content')

<div class="row">
    <div class="col-12">
        <h1 class="float-start">Users</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success float-end" role="button">Add User</a>

    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">MSISDN</th>
                <th scope="col">Email</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->msisdn }}</td>
                <td>{{ $user->email }}</td>
                <td scope="row">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary" role="button">Edit</a>

                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" id="deleteUserForm{{ $user->id }}" class="float-end">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>

                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection