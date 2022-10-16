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
                <div class="card-header"><h3>{{ __('Enter a question.') }}</h3></div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('storequestion', ['wid' => $workshop->id, 'mid' => $monitor->id] ) }}">
                        @csrf
                        
                        <div class="form-group row">
                            <div class="col-md-9">
                                <input id="workshop_question" type="text" class="form-control @error('workshop_question') is-invalid @enderror" name="workshop_question" value="{{ old('workshop_question') }}" required autocomplete="workshop_question" autofocus>

                                @error('workshop_question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    {{ __('Enter') }}
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
