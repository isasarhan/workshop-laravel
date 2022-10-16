@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Edit Workshop') }}</div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('update', $workshop->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="workshop_title" class="col-md-3 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="workshop_title" type="text" class="form-control @error('workshop_title') is-invalid @enderror" name="workshop_title" value="{{ $workshop->workshop_title }}" required autocomplete="workshop_title" autofocus>

                                @error('workshop_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="workshop_nb_of_participants" class="col-md-3 col-form-label text-md-right">{{ __('Participants\' Nb') }}</label>

                            <div class="col-md-6">
                                <input id="workshop_nb_of_participants" type="text" class="form-control @error('workshop_nb_of_participants') is-invalid @enderror" name="workshop_nb_of_participants" value="{{ $workshop->workshop_nb_of_participants }}" required autocomplete="workshop_nb_of_participants">

                                @error('workshop_nb_of_participants')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-9 offset-md-4">
                                <a href="{{ route('monitor', $workshop->id) }}" class="btn btn-lg btn-warning ml-5">back</a>
                                <button type="submit" class="btn btn-lg btn-primary">
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
