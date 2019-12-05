@extends('layouts.main')


@section('title', 'Users')


@section('body')

<style>
    table, th, td
    {
        border: 1px solid darkslateblue;
        
    }
</style>
<table align = "center">
    <tr>
        <th>Username</th>
    </tr>
        <ul>
            @foreach($users as $user)
            <tr><td><a href='/users/{{$user->id}}'>{{$user->display_name}}</a></td></tr></a>
            @endforeach
        </ul>
</table>

@endsection