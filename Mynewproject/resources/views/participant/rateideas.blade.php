@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header"><h4 class="mt-2">{{ __('Idea') }}</h4></div>
                
                <div class="card-body">
                    <div class="form-group offset-md-1 row">
                            <label for="idea_title" class="col-md-3 col-form-label text-md-right">{{ __('Title: ') }}</label>

                            <div class="col-md-6 mt-2">
                                <strong>{{$idea->idea_title}}</strong>
                            </div>
                    </div>

                    <div class="form-group offset-md-1 row">
                            <label for="idea_description" class="col-md-3 col-form-label text-md-right">{{ __('Description: ') }}</label>

                            <div class="col-md-5 mt-2">
                                <strong>{{$idea->idea_description}}</strong>
                            </div>
                    </div>
                </div>
            </div>

            @if(session()->has('message1'))
                <p class="alert alert-danger">
                    {{session()->get('message1')}}
                </p>
            @endif
            <div class="card mt-5">
                <div class="card-header"><h3>Rate the idea from <b>1</b> to <b>5</b>.</h3></div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('storerate', $idea->id ) }}">
                        @csrf
                        
                        <div class="form-group row">
                            <div class="col-md-9">
                                <input id="ideagrade_grade_value" type="text" class="form-control @error('ideagrade_grade_value') is-invalid @enderror" name="ideagrade_grade_value" value="{{ old('ideagrade_grade_value') }}" required autocomplete="ideagrade_grade_value" autofocus>

                                @error('ideagrade_grade_value')
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
