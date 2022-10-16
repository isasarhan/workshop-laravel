@extends('layouts.app')

@section('title', 'Edit details for ' . $user->user_first_name . $user->user_last_name)
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h1>Edit Details for {{ $user->user_first_name }} {{ $user->user_last_name }}</h1></div>

                <div class="card-body">
                    <form method="POST" action="/admin/{{ $user->id }}">
                        @csrf

                        <div class="form-group row">
                            <label for="user_first_name" class="col-md-4 col-form-label text-md-right">{{ __('FirstName') }}</label>

                            <div class="col-md-6">
                                <input id="user_first_name" type="text" class="form-control @error('user_first_name') is-invalid @enderror" name="user_first_name" value="{{ old('user_first_name') }}" required autocomplete="user_first_name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_last_name" class="col-md-4 col-form-label text-md-right">{{ __('LastName') }}</label>

                            <div class="col-md-6">
                                <input id="user_last_name" type="text" class="form-control @error('user_last_name') is-invalid @enderror" name="user_last_name" value="{{ old('user_last_name') }}" required autocomplete="user_last_name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                           <label for="level" class="col-md-4 col-form-label text-md-right">{{ __('Level') }}</label>
                           <div class="col-md-6">
                               <select id="level" class="form-control @error('level') is-invalid @enderror" name="level" required>
                               <option value="monitor">Monitor</option>
                               <option value="participant">Participant</option>
                               </select>

                               @if($errors->has('level'))
                                  <span class="help-block">
                                     <strong>{{ $errors->first('level') }}</strong>
                                  </span>
                               @endif
                           </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
