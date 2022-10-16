@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Edit Group') }}</div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('updategroup', [ 'gid' => $group->id, 'wid' => $workshop->id, 'mid' => $monitor->id]) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group row">
                            <label for="group_name" class="col-md-3 col-form-label text-md-right">{{ __('Name:') }}</label>

                            <div class="col-md-6">
                                <input id="group_name" type="text" class="form-control @error('group_name') is-invalid @enderror" name="group_name" value="{{ $group->group_name }}" required autocomplete="group_name" autofocus>

                                @error('group_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="group_name" class="col-md-3 mt-3 col-form-label text-md-right">{{ __('Participants:') }}</label>

                            <div class="col-md-6 mt-3">
                                <div class="table-responsive">
                                <table class="table tabel-bordered">
                                    <tr class="text-danger">
                                        <th>#</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                
                                    @foreach($users as $key => $user)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$user->email}}</td>
                                        <td> 
                                            <a href="{{ route('destroyparticipant', [ 'uid' => $user->id ,'gid' => $group->id, 'wid' => $workshop->id, 'mid' => $monitor->id]) }}" type="submit" class="btn btn-danger">Remove</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <div class="form-group">
                                <div class="col-md-9 mt-3 offset-md-4">
                                    <a href="{{ route('show', ['wid' => $workshop->id, 'mid' => $monitor->id]) }}" class="btn btn-lg btn-warning ml-5">back</a>
                                    <button type="submit" class="btn btn-lg btn-primary">
                                        {{ __('Update') }}
                                    </button> 
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
