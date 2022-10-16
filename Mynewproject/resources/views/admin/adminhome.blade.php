@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 mb-5">
        <div class="title m-b-md">
            <h1><center>25/10 Crowd Sourcing<center></h1>
        </div>
    </div>
</div>
<div class="container mt-5">

    <div class="form-group row">
       <div class="mx-auto"></div>
       <a href="{{ route('approving') }}" class="btn btn-lg btn-warning mr-5 mb-3 mt-2">  
            @if($setting->setting_auto_approve == true)
                {{'Approve'}}
            @else
                {{'Auto Approve'}}
            @endif
        </a>
    </div>

    <div class="card">
    <div class="card-header"><h3>Users</h3></div>
    @if(session()->has('message'))
        <p class="alert alert-success">
            {{session()->get('message')}}
        </p>
    @endif
    <table class="table tabel-bordered">
        <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Approved</th>
            <th>Role</th>
        </tr>
        @foreach($users as $key => $user)
            @if($user->user_level_id !=1)
            <tr>
                <td>{{++$key}}</td>
                <td>{{$user->user_first_name}}</td>
                <td>{{$user->user_last_name}}</td>
                <td>{{$user->email}}</td>
                <td><a href="{{ route('astatus', ['id'=>$user->id]) }}">  
                @if($user->user_status_id ==1)
                    {{'Disapprove'}}
                @else
                    {{'Approve'}}
                @endif
                </a></td>
                <td>
                @if($user->user_level_id ==2)
                    {{'Monitor'}}
                @else
                    {{'Participant'}}
                @endif
                </td>
            </tr>
            @endif
        @endforeach
    </table>
    </div>
</div>
@endsection