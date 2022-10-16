@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="form-group row">
                <a href="{{ route('show', ['wid' => $workshop->id, 'mid' => $monitor->id]) }}" class="btn btn-lg btn-warning ml-5 mb-3 mt-2">back</a>
            </div>

            <div class="card mb-3">
                <div class="card-header"><h4 class="mt-2">{{ __('Group Details') }}</h4></div>
                
                <div class="card-body">
                    <div class="form-group offset-md-2 row">
                        <label for="group_name" class="col-md-2 col-form-label text-md-right">{{ __('Name:') }}</label>

                        <div class="col-md-3 mt-2">
                            <strong>{{$group->group_name}}</strong>
                        </div>

                        <label for="idea_title" class="col-md-2 col-form-label text-md-right">{{ __('Idea Title:') }}</label>

                        <div class="col-md-3 mt-2">
                            <strong>{{$idea->idea_title}}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="mt-2">{{ __('Group Participants') }}</h4>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tabel-bordered">
                        <tr class="text-danger">
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                        </tr>

                        @foreach($users as $key => $user)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$user->user_first_name}}</td>
                                <td>{{$user->user_last_name}}</td>
                                <td>{{$user->email}}</td>
                            </tr>
                        @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
