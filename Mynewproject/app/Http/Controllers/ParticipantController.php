<?php

namespace App\Http\Controllers;

use App\Workshopuser;
use App\Workshop;
use App\User;
use App\Idea;
use App\Ideauser;
use App\Ideagrade;
use App\Groupuser;
use Illuminate\Http\Request;
use App\Notifications\SendWorkshopKeyNotification;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    public function index($id)
    {
        $participant = User::find($id);

        $workshop = Workshop::where('workshop_status', '=', 1)->first();//only one workshop will be opened at a time, and the key of this workshop will be sent to the participants.
        if($workshop)
        {
            if($workshop->workshop_stage == 5){
            return redirect()->route('availablegroups', ['uid' => $id, 'wid' => $workshop->id]);
            }
            if($workshop->workshop_switch)
            {
                $participant->notify(new SendWorkshopKeyNotification($workshop, $participant));

                return redirect()->route('participant1', $id)->with('message1', 'Check your email to get the workshop key.');
            }
            else{
                return redirect()->route('participant1', $id)->with('message2', 'The workshop stopped receiving participants.');
            }
        }
        else{
            return redirect()->route('participant1', $id)->with('message2', 'There is no workshops opened yet.');
        }
    }



    public function index2($id)
    {
        $participant = User::find($id);

        return view('participant.participanthome', compact('participant'));
    }


    
    public function enter(Request $request, $id)
    {
        $request->validate([
            'workshop_key' => 'required',
        ]);
        
        $workshop = Workshop::where('workshop_key', '=', $request->workshop_key)->first();
        if($workshop){
            $workshopuser = array(
                'workshopuser_user_id' => $id,
                'workshopuser_workshop_id' => $workshop->id,
            );
            
            Workshopuser::create($workshopuser);

            return redirect()->route('messages')->with('questionmessage','l');
        }
        else{
            return redirect()->route('participant1', $id)->with('message3', 'The key you have been entered is incorrect,retry.');
        }
    }



    public function messages()
    {
        return view('participant.messages');
    }



    public function createIdea($wid, $uid)
    {
        $workshop = Workshop::findOrfail($wid);
        $user = User::findOrfail($uid);

        return view('participant.createIdea', compact('workshop', 'user'));
    }



    public function storeIdea(Request $request, $wid, $uid)
    {
        $request->validate([
            'idea_title' => 'required',
            'idea_description' => 'required',
        ]);
        
        $idea = array(
            'idea_title' => $request->idea_title,
            'idea_description' => $request->idea_description,
            'idea_user_id' => $uid,
            'idea_workshop_id' => $wid,
        );

        Idea::create($idea);

        return redirect()->route('messages')->with('ideamessage','l');
    }



    public function rateideas($id)
    {
        $idea = Idea::findOrfail($id);

        return view('participant.rateideas', compact('idea'));
    }

    public function storerate(Request $request, $id)
    {
        if($request->ideagrade_grade_value >=1 && $request->ideagrade_grade_value <=5)
        {
            $ideagrade = array(
                'ideagrade_idea_id' => $id,
                'ideagrade_grade_value' => $request->ideagrade_grade_value,
            );
            Ideagrade::create($ideagrade);
    
            return redirect()->route('messages')->with('rateideamessage1','l');
        }
        else{
            return redirect()->route('rateideas', ['id' => $id])->with('message1','Only from 1 to 5');
        }
        
    }
    
    public function availablegroups($uid, $wid)
    {
        $user = User::findOrfail($uid);

        $groupuser = Groupuser::where('groupuser_user_id', '=', $uid)->first();

        $workshop = Workshop::where('id', '=', $wid)->first();

        $groups = DB::table('groups')
                     ->join('ideas', 'groups.group_idea_id', '=', 'ideas.id')
                     ->join('workshops', 'ideas.idea_workshop_id', '=', 'workshops.id')
                     ->select('groups.*')
                     ->get();

        $ideas = DB::table('ideas')
                     ->join('groups', 'ideas.id', '=', 'groups.group_idea_id')
                     ->select('ideas.*')
                     ->get();
        
        return view('participant.availablegroups', compact('user', 'groupuser', 'workshop', 'groups', 'ideas'));
    }


    public function joingroup(Request $request, $uid, $gid, $wid)
    {
        $user = User::findOrfail($uid);
        $groupusers = Groupuser::all();

        if($groupusers->isEmpty())
        {
            $user->user_chosen = 1;

            $groupuser = array(
                'groupuser_user_id' => $uid,
                'groupuser_group_id' => $gid,
            );
            
            Groupuser::create($groupuser);

            $user->save();
            return redirect()->route('availablegroups', ['uid' => $uid, 'wid' => $wid]);
        }
        else{
            foreach($groupusers as $groupuser)
            {
                if($groupuser->groupuser_user_id == $uid)
                {
                    if($groupuser->groupuser_group_id == $gid)
                    {
                        $user->user_chosen = 0;

                        Groupuser::where([['groupuser_user_id', '=', $uid], ['groupuser_group_id', '=', $gid]])->delete();

                        $user->save();
                        return redirect()->route('availablegroups', ['uid' => $uid, 'wid' => $wid]);
                    }
                    else{
                        Groupuser::where('groupuser_user_id', '=', $uid)->delete();

                        $groupuser = array(
                            'groupuser_user_id' => $uid,
                            'groupuser_group_id' => $gid,
                        );
                
                        Groupuser::create($groupuser);

                        return redirect()->route('availablegroups', ['uid' => $uid, 'wid' => $wid])->with('message2', 'You can join ONLY one group.');
                    }
                }
                else{
                    $user->user_chosen = 1;

                    $groupuser = array(
                        'groupuser_user_id' => $uid,
                        'groupuser_group_id' => $gid,
                    );
            
                    Groupuser::create($groupuser);

                    $user->save();
                    return redirect()->route('availablegroups', ['uid' => $uid, 'wid' => $wid]);
                }
            
            }
        }
    }



    public function history($uid, $wid)
    {
        $user = User::findOrfail($uid);
        $workshop = Workshop::findOrfail($wid);

        $users = DB::table('users')
                     ->join('workshopusers', 'users.id', '=', 'workshopusers.workshopuser_user_id')
                     ->select('users.*','workshopusers.*')
                     ->where('workshopuser_workshop_id', '=', $wid)
                     ->get();

        $ideas = Idea::where('idea_workshop_id', '=', $wid)->get();

        $ideagrades = DB::table('ideagrades')
                          ->join('ideas', 'ideagrades.ideagrade_idea_id', '=', 'ideas.id')
                          ->join('workshops', 'ideas.idea_workshop_id', '=', 'workshops.id')
                          ->select('ideagrades.*')
                          ->get();

        $collection = collect([]);

        foreach($ideas as $idea)
        {
            $collection->put($idea->id, 0);
            
        }
        $ideastotalArray = $collection->all();
        
        foreach($ideagrades as $ideagrade)
        {   
            foreach($collection->all() as $key => $ideatotalArray)
            {
                if($ideagrade->ideagrade_idea_id == $key)
                {
                    $ideatotalArray = $ideatotalArray + $ideagrade->ideagrade_grade_value;
                    $collection->forget($key);
                    $collection->put($key, $ideatotalArray);
                }
            }
        }
        $ideastotalArray = $collection->all();

        $groups = DB::table('groups')
                     ->join('ideas', 'groups.group_idea_id', '=', 'ideas.id')
                     ->select('groups.*')
                     ->get();

        $usersgroup = DB::table('users')
                         ->join('groupusers', 'users.id', '=', 'groupusers.groupuser_user_id')
                         ->join('groups', 'groupusers.groupuser_group_id', '=', 'groups.id')
                         ->join('ideas', 'groups.group_idea_id', '=', 'ideas.id')
                         ->join('workshops', 'ideas.idea_workshop_id', '=', 'workshops.id')
                         ->select('users.*', 'groupusers.*')
                         ->get();

        return view('participant.history', compact('user', 'workshop', 'users', 'ideas', 'ideagrades', 'ideastotalArray', 'groups', 'usersgroup'));
    }

}
