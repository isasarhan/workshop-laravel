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
       <a href="{{ route('history', ['uid' => $user->id , 'wid' => $workshop->id]) }}" class="btn btn-lg btn-warning mr-3 my-2 pl-5 pr-5">History</a>
</div>

@if(session()->has('message1'))
    <p class="alert alert-success">
        {{session()->get('message1')}}
    </p>
@elseif(session()->has('message2'))
    <p class="alert alert-danger">
        {{session()->get('message2')}}
    </p>
@endif
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Groups</h3>
    </div>
    <div class="card-body">
    <div class="table-responsive">
    <table class="table tabel-bordered">
        <tr class="text-danger">
            <th>#</th>
            <th>Name</th>
            <th>Idea Title</th>
            <th></th>
        </tr>

        @foreach($groups as $key => $group)
            <tr>
                <td>{{++$key}}</td>
                <td>{{$group->group_name}}</td>
                <td>
                    @foreach($ideas as $idea)
                       @if($idea->id == $group->group_idea_id)
                          {{$idea->idea_title}}
                       @endif
                    @endforeach
                </td>
                <td>
                   <a href="{{ route('joingroup', ['uid' => $user->id, 'gid' => $group->id, 'wid' => $workshop->id]) }}">  
                   @if($groupuser && $groupuser->groupuser_user_id == $user->id && $groupuser->groupuser_group_id == $group->id)
                    {{'leave'}}
                   @else
                    {{'join'}}
                   @endif
                   </a>
                </td>
            </tr>
        @endforeach
    </table>
    </div>
    </div>
    </div>
</div>
@endsection