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
        <div class="row">
            <div class="col-md-9 pt-2">
                <h3 class="card-title">Workshops</h3>
            </div>
            <div class="col-md-3 pl-5">
                <a href="{{ route('create', ['id' => $monitor->id]) }}" class="btn btn-lg btn-success">Add New Workshop</a>
            </div>
        </div> 
    </div>
    <div class="card-body">
    <div class="table-responsive">
    <table class="table tabel-bordered">
        <tr class="text-danger">
            <th>#</th>
            <th>Title</th>
            <th>Key</th>
            <th>Participants' Nb</th>
            <th>Stage</th>
            <th>Status</th>
            <th>Created at</th>
            <th></th>
        </tr>

        @foreach($workshops as $key => $workshop)
            <tr>
                <td>{{++$key}}</td>
                <td>{{$workshop->workshop_title}}</td>
                <td>{{$workshop->workshop_key}}</td>
                <td>{{$workshop->workshop_nb_of_participants}}</td>
                <td>{{$workshop->workshop_stage}}
                <!--@if($workshop->workshop_stage < 5)
                    <a href="{{ route('stage', ['id'=>$workshop->id]) }}" class="btn btn-warning">+</a>
                @endif-->
                </td>
                <td><a href="{{ route('mstatus', $workshop->id) }}">  
                @if($workshop->workshop_status ==1)
                    {{'close'}}
                @else
                    {{'open'}}
                @endif
                </a></td>
                <td>{{$workshop->created_at}}</td>
                <td>
                   <form action="{{ route('destroy', $workshop->id) }}" method="post">
                        
                        <button type="submit" class="btn btn-danger">Delete</button>
                        @method('DELETE')
                        @csrf
                        <a href="{{ route('show', ['wid' => $workshop->id, 'mid' => $monitor->id] ) }}" class="btn btn-warning">Show</a>
                        <a href="{{ route('edit', $workshop->id) }}" class="btn btn-info">Edit</a>
                   </form>
                </td>
            </tr>
        @endforeach
    </table>
    </div>
    </div>
    </div>
</div>
@endsection