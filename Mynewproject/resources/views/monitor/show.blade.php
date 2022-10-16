@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="form-group row">
                <a href="{{ route('monitor', $monitor->id) }}" class="btn btn-lg btn-warning ml-5 mb-3 mt-2">back</a>
                <div class="mx-auto"></div>
                <a href="{{ route('switch', ['wid' => $workshop->id, 'mid' => $monitor->id]) }}" class="btn btn-lg btn-warning mr-5 mb-3 mt-2">  
                @if($workshop->workshop_switch ==1)
                    {{'Off'}}
                @else
                    {{'On'}}
                @endif
                </a>
            </div>

            <div class="card mb-3">
                <div class="card-header"><h4 class="mt-2">{{ __('Workshop Details') }}</h4></div>
                
                <div class="card-body">
                        <div class="form-group offset-md-2 row">
                            <label for="workshop_title" class="col-md-2 col-form-label text-md-right">{{ __('Title:') }}</label>

                            <div class="col-md-3 mt-2">
                                <strong>{{$workshop->workshop_title}}</strong>
                            </div>

                            <label for="workshop_key" class="col-md-2 col-form-label text-md-right">{{ __('Key:') }}</label>

                            <div class="col-md-3 mt-2">
                                <strong>{{$workshop->workshop_key}}</strong>
                            </div>
                        </div>

                        <div class="form-group offset-md-2 row">
                            <label for="workshop_nb_of_participants" class="col-md-3 col-form-label text-md-right">{{ __('Participants\' Nb:') }}</label>

                            <div class="col-md-2 mt-2">
                                <strong>{{$workshop->workshop_nb_of_participants}}</strong>
                            </div>

                            <label for="workshop_status" class="col-md-2 col-form-label text-md-right">{{ __('Status:') }}</label>

                            <div class="col-md-3 mt-2">
                                <strong>{{$workshop->workshop_status}}</strong>
                            </div>
                        </div>

                        <div class="form-group offset-md-2 row">
                            <label for="workshop_stage" class="col-md-2 col-form-label text-md-right">{{ __('Stage:') }}</label>

                            <div class="col-md-3 mt-2">
                                <strong>{{$workshop->workshop_stage}}</strong>
                            </div>

                            <label for="created" class="col-md-2 col-form-label text-md-right">{{ __('Created at:') }}</label>

                            <div class="col-md-4 mt-2">
                                <strong>{{$workshop->created_at}}</strong>
                            </div>
                        </div>
                </div>
            </div>


            <div class="card mb-3">
            
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9 pt-2">
                            <h4 class="mt-2">{{ __('Participants') }}</h4>
                        </div>
                        <div class="col-md-3 pl-5">
                            <a href="{{ route('show', ['wid' => $workshop->id, 'mid' => $monitor->id]) }}" class="btn btn-lg btn-success">Refresh</a>
                        </div>
                    </div>
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


            @if(session()->has('message1'))
                <p class="alert alert-success">
                    {{session()->get('message1')}}
                </p>
            @elseif(session()->has('message2'))
                <p class="alert alert-danger">
                    {{session()->get('message2')}}
                </p>
            @endif

            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9 pt-2">
                            <h4 class="mt-2">{{ __('Question') }}</h4>
                        </div>
                        <div class="col-md-3 pl-5">
                            @if(!($workshop->workshop_question))
                                <a href="{{ route('createquestion', ['wid' => $workshop->id, 'mid' => $monitor->id]) }}" class="btn btn-lg btn-success">Add a Question</a>
                            @endif
                        </div>
                    </div> 
                </div>
                
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-8">
                            @if($workshop->workshop_question)
                                <h2>{{$workshop->workshop_question}}</h2>
                            @else
                                <h2>There is no question yet.</h2>
                            @endif
                        </div>
                        @if($workshop->workshop_question)
                        <div class="col-md-4">
                            <form action="{{ route('deletequestion', ['wid' => $workshop->id, 'mid' => $monitor->id]) }}" method="post">
                        
                                <button type="submit" class="btn btn-danger">Delete</button>
                                @method('DELETE')
                                @csrf

                                <a href="{{ route('sendquestion', ['wid' => $workshop->id, 'mid' => $monitor->id]) }}" class="btn btn-warning">Send to Participants</a>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>


            @if(session()->has('message5'))
                <p class="alert alert-success">
                    {{session()->get('message5')}}
                </p>
            @endif
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-7 pt-2">
                            <h4 class="mt-2">{{ __('Ideas') }}</h4>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group row">
                                <h5 class="mt-4">stage : {{$workshop->workshop_stage}}</h5>
                                @if($workshop->workshop_stage < 5)
                                    <a href="{{ route('shuffleandsend', ['wid' => $workshop->id, 'mid' => $monitor->id]) }}" class="btn btn-lg btn-primary mt-3 ml-3">Shuffle and send</a>
                                @endif
                                <a href="{{ route('show', ['wid' => $workshop->id, 'mid' => $monitor->id]) }}" class="btn btn-lg btn-success mt-3 ml-2">Refresh</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table tabel-bordered">
                        <tr class="text-danger">
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Voting</th>
                            <th>Total</th>
                            <th>Choose to work on</th>
                        </tr>

                        @foreach($ideas as $key => $idea)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$idea->idea_title}}</td>
                                <td>{{$idea->idea_description}}</td>
                                <td>
                                @foreach($ideagrades as $ideagrade)
                                    @if($ideagrade->ideagrade_idea_id == $idea->id)
                                       {{$ideagrade->ideagrade_grade_value }} |
                                    @endif
                                @endforeach
                                </td>
                                <td>
                                @foreach($ideastotalArray as $key => $ideatotalArray)
                                    @if($idea->id == $key)
                                       @if($ideatotalArray>15)
                                            <h4 class="text-danger">{{ $ideatotalArray }}</h4>
                                        @else
                                            {{ $ideatotalArray }}
                                       @endif
                                    @endif
                                @endforeach
                                </td>
                                <td>
                                @foreach($ideastotalArray as $key => $ideatotalArray)
                                    @if($idea->id == $key)
                                       @if($ideatotalArray>15)
                                            <a href="{{ route('chooseidea', ['wid' =>$workshop->id,'mid' =>$monitor->id, 'iid' => $idea->id]) }}">  
                                                @if($idea->idea_chosen ==1)
                                                    {{'chosen'}}
                                                @else
                                                    {{'choose'}}
                                                @endif
                                            </a>
                                        @else
                                            {{'Can\'t be chosen.'}}
                                       @endif
                                    @endif
                                @endforeach
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                        <td></td><td></td><td></td><td></td><td></td>
                        <td>
                            <a href="{{ route('storegroup', ['wid' => $workshop->id, 'mid' => $monitor->id]) }}" class="btn btn-success mt-4 ml-1">create Group(s)</a>
                        </td>
                        </tr>
                    
                    </table>
                    </div>
                </div>
            </div>


            @if(session()->has('message6'))
                <p class="alert alert-danger">
                    {{session()->get('message6')}}
                </p>
            @elseif(session()->has('message7'))
                <p class="alert alert-success">
                    {{session()->get('message7')}}
                </p>
            @endif
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9 pt-2">
                            <h4 class="mt-2">{{ __('Groups') }}</h4>
                        </div>
                        <div class="col-md-3 pl-5">
                            <a href="{{ route('show', ['wid' => $workshop->id, 'mid' => $monitor->id]) }}" class="btn btn-lg btn-success">Refresh</a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tabel-bordered">
                            <tr class="text-danger">
                                <th>#</th>
                                <th>Name</th>
                                <th>Idea Title</th>
                                <th>Participants</th>
                                <th></th>
                            </tr>

                            @foreach($groups as $key => $group)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$group->group_name}}</td>
                                    @foreach($ideas as $idea)
                                        @if($idea->id == $group->group_idea_id)
                                            <td>{{$idea->idea_title}}</td>
                                        @endif
                                    @endforeach
                                    <td>
                                        @foreach($usersgroup as $usergroup)
                                            @if($usergroup->groupuser_group_id == $group->id)
                                                {{ $usergroup->email }}<br>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <form action="{{ route('destroygroup', ['gid' => $group->id, 'wid' => $workshop->id, 'mid' => $monitor->id]) }}" method="post">
                        
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                            @method('DELETE')
                                            @csrf
                                            <a href="{{ route('showgroup', ['gid' => $group->id, 'wid' => $workshop->id, 'mid' => $monitor->id]) }}" class="btn btn-warning">Show</a>
                                            <a href="{{ route('editgroup', ['gid' => $group->id, 'wid' => $workshop->id, 'mid' => $monitor->id]) }}" class="btn btn-info">Edit</a>
                                        </form>
                                    </td>
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
