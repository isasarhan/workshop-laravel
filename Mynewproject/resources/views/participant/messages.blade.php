@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12 mb-5 mt-5">
        <div class="title m-b-md">
            @if(session()->has('questionmessage'))
                <h1><center>Few minutes and you will receive the question by email.<center></h1>
            @elseif(session()->has('ideamessage'))
                <h1><center>Few minutes and you will receive an email of an idea for to rate.<center></h1>
            @elseif(session()->has('rateideamessage1'))
                <h1><center>Few minutes and you will receive an email of another idea to rate.<center></h1>
            @endif
        </div>
    </div>
</div>
@endsection