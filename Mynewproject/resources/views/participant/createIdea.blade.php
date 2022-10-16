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
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h3>{{ __('Send your idea.') }}</h3></div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('storeIdea',['wid' => $workshop->id, 'uid' => $user->id] ) }}">
                        @csrf
                        
                        <div class="form-group row">
                            <label for="idea_title" class="col-md-3 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="idea_title" type="text" class="form-control @error('idea_title') is-invalid @enderror" name="idea_title" value="{{ old('idea_title') }}" required autocomplete="idea_title" autofocus>

                                @error('idea_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="idea_description" class="col-md-3 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <input id="idea_description" type="text" class="form-control @error('idea_description') is-invalid @enderror" name="idea_description" value="{{ old('idea_description') }}" required autocomplete="idea_description">

                                @error('idea_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-9 offset-md-4">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    {{ __('Send') }}
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
