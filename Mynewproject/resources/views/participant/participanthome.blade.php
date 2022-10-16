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
            @if(session()->has('message1'))
                <p class="alert alert-info">
                    {{session()->get('message1')}}
                </p>
            @elseif(session()->has('message2'))
                <p class="alert alert-danger">
                    {{session()->get('message2')}}
                </p>
            @elseif(session()->has('message3'))
                <p class="alert alert-danger">
                    {{session()->get('message3')}}
                </p>
            @endif
            <div class="card mt-5">
                <div class="card-header"><h3>{{ __('Enter the workshop key.') }}</h3></div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('enter', $participant->id ) }}">
                        @csrf
                        
                        <div class="form-group row">
                            <div class="col-md-9">
                                <input id="workshop_key" type="text" class="form-control @error('workshop_key') is-invalid @enderror" name="workshop_key" value="{{ old('workshop_key') }}" required autocomplete="workshop_key" autofocus>

                                @error('workshop_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                @if(session()->has('message2'))
                                    <button type="submit" class="btn btn-lg btn-primary disabled">
                                        {{ __('Enter') }}
                                    </button> 
                                @else
                                    <button type="submit" class="btn btn-lg btn-primary">
                                        {{ __('Enter') }}
                                    </button> 
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection