@extends('layouts.app')

@section('content')

    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col"></th>
            <th scope="col">Full Name</th>
            <th scope="col">Username</th>
            <th scope="col">Edit</th>
        </tr>
        </thead>
        <tbody>
        @foreach($user as $user)
        <tr>
            <th scope="row"></th>
            <td>{{$user->full_name}}</td>
            <td>{{$user->username}}</td>
            <td>
                <form  action="{{url('/admin/edit')}}" method="get">
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <button class="btn btn-sm btn-warning" type="submit" name="submit">Edit</button>
                </form>
            </td>
        </tr>
            @endforeach
        </tbody>
    </table>
    @endsection
