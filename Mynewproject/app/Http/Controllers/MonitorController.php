<?php

namespace App\Http\Controllers;

use App\Workshop;
use App\Workshopuser;
use App\User;
use App\Idea;
use App\Ideauser;
use App\Ideagrade;
use App\Group;
use App\Groupuser;
use App\Notifications\SendQuestionNotification;
use App\Notifications\SendShuffledIdeasNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    public $switch;

    public function index($id)
    {
        $monitor = User::findOrfail($id);

        $workshops = Workshop::all();

        return view('monitor.monitorhome', compact('monitor', 'workshops'));
    }



    public function create($id)
    {
        $monitor = User::findOrfail($id);

        return view('monitor.create', compact('monitor'));
    }



    public function store(Request $request, $id)
    {
        $random = Str::random(4);
        $request->validate([
            'workshop_title' => 'required',
            'workshop_nb_of_participants' => 'required',
        ]);
        
        $workshop = array(
            'workshop_title' => $request->workshop_title,
            'workshop_key' => $random,
            'workshop_nb_of_participants' => $request->workshop_nb_of_participants,
            'workshop_user_id' => $id
        );
        Workshop::create($workshop);
        return redirect()->route('monitor', $id);
    }



    public function show($wid, $mid)
    {
        $monitor = User::findOrfail($mid);

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

        return view('monitor.show', compact('monitor', 'workshop', 'users', 'ideas', 'ideagrades','ideastotalArray', 'groups', 'usersgroup'));
    }



    public function edit($id)
    {
        $workshop = Workshop::findOrfail($id);

        return view('monitor.edit', compact('workshop'));
    }



    public function update(Request $request,$id)
    {
        $request->validate([
            'workshop_title' => 'required',
            'workshop_nb_of_participants' => 'required',
        ]);

        $workshop = array(
            'workshop_title' => $request->workshop_title,
            'workshop_nb_of_participants' => $request->workshop_nb_of_participants,
        );

        Workshop::whereId($id)->update($workshop);

        return redirect()->route('monitor', $id)->with('message1', 'The workshop was successfully updated.');
    }



    public function destroy($wid)
    {
        $workshop = Workshop::findOrfail($wid);
        $workshop->delete();

        return redirect()->route('monitor', $wid)->with('message1', 'The workshop was successfully deleted!');
    }



    public function mstatus(Request $request, $id)
    {
        $workshops = Workshop::all();
        $workshopopenclose = Workshop::find($id);
        
        if($workshopopenclose->workshop_status == 1)
        {
            $workshopopenclose->workshop_status = 0;
        }
        else{
            foreach($workshops as $workshop)
            {
                if($workshop->workshop_status == 1)
                {
                    return redirect()->route('monitor', $id)->with('message2', 'Only one workshop can be opened at a time.');
                }
            }
            $workshopopenclose->workshop_status = 1;
        }

        $workshopopenclose->save();
        return redirect()->route('monitor', $id);
    }



    public function stage(Request $request, $id)
    {
        $workshop = Workshop::find($id);
        $stagecounter = $workshop->workshop_stage;
        $workshop->workshop_stage = $stagecounter +1;
        $workshop->save();
        return redirect()->route('monitor', $id);
    }



    public function switch($wid, $mid)
    {
        $workshop = Workshop::find($wid);

        if($workshop->workshop_switch == 1)
        {
            $workshop->workshop_switch = 0;
        }
        else{
            $workshop->workshop_switch = 1;
        }
        $workshop->save();
        return redirect()->route('show', ['wid' => $wid, 'mid' => $mid]);
    }




    public function createquestion($wid, $mid)
    {
        $workshop = Workshop::findOrfail($wid);
        $monitor = User::findOrfail($mid);

        return view('monitor.createquestion',compact('workshop', 'monitor'));
    }



    public function storequestion(Request $request, $wid, $mid)
    {
        $request->validate([
            'workshop_question' => 'required',
        ]);

        $workshop = array(
            'workshop_question' => $request->workshop_question,
        );

        Workshop::whereId($wid)->update($workshop);

        return redirect()->route('show', ['wid' => $wid, 'mid' => $mid]);
    }



    public function deletequestion($wid, $mid)
    {
        $workshop = Workshop::findOrfail($wid);

        $workshop = array(
            'workshop_question' => null,
        );

        Workshop::whereId($wid)->update($workshop);

        return redirect()->route('show', ['wid' => $wid, 'mid' => $mid]);
    }



    public function sendquestion($wid, $mid)
    {
        $collection = collect([]);
        $workshop = Workshop::findOrfail($wid);
        
        $workshopusers = Workshopuser::where('workshopuser_workshop_id', '=', $wid)->get();
        foreach($workshopusers as $key => $workshopuser)
        {
            $workshopusersArrayIds = $workshopuser->workshopuser_user_id;
            $collection->push($workshopusersArrayIds);
            $workshopusersArray = $collection->all();
        }

        $users = User::whereIn('id', $workshopusersArray)->get();

        if($workshop->workshop_status == 0)
        {
            return redirect()->route('monitor', $wid)->with('message2','You must open the workshop before.');
        }

        foreach($users as $key => $user)
        {
            if(!$workshop->workshop_switch)
            {
                $user->notify(new SendQuestionNotification($workshop, $user));
            }
            else{
                return redirect()->route('show', ['wid' => $wid, 'mid' => $mid])->with('message2','The workshop is still receiving participants.');
            }
        }
        return redirect()->route('show', ['wid' => $wid, 'mid' => $mid])->with('message1','The question is sent to all participants successfully.');
    }

    
    public function shuffleandsend($wid, $mid)
    {
        $workshopusersArray = array();
        $ideasIdsArray = array();
        $ideasIdstakenbeforeArray = array();
        $collection1 = collect([]);
        $collection2 = collect([]);
        

        $workshop = Workshop::findOrfail($wid);

        //$workshop->workshop_stage =0;
        $workshop->workshop_stage = $workshop->workshop_stage +1;
        $workshop->save();

        $workshopusers = Workshopuser::where('workshopuser_workshop_id', '=', $wid)->get();
        foreach($workshopusers as $key => $workshopuser)
        {
            $workshopusersArrayIds = $workshopuser->workshopuser_user_id;
            $collection1->push($workshopusersArrayIds);
            $workshopusersArray = $collection1->all();
        }

        $users = User::whereIn('id', $workshopusersArray)->get();

        $ideas = Idea::where('idea_workshop_id','=', $wid)->get();

        foreach($ideas as $idea)
        {
            $collection2->push($idea->id);
            $ideasIdsArray = $collection2->all();
        }

        foreach($users as $user)
        {
            $idea = Idea::where('idea_user_id','=', $user->id)->first();
            
            $collection3 = collect([]);
            $ideausersforthisuser = Ideauser::where('ideauser_user_id', '=', $user->id)->get();
            foreach($ideausersforthisuser as $ideauserforthisuser)
            {
                $collection3->push($ideauserforthisuser->ideauser_idea_id);
                $ideasIdstakenbeforeArray = $collection3->all();
            }
            
            if( $v1 = $collection2->contains($idea->id))
            {
                $key1 = $collection2->search($idea->id);
                $collection2->forget($key1);
                $ideasIdsArray = $collection2->all();
                
            }

            $collection4 = collect([]);
            foreach($ideasIdstakenbeforeArray as $value1)
            {
                if( $collection2->contains($value1))
                {
                    $collection4->push($value1);
                    $key2 = $collection2->search($value1);
                    $collection2->forget($key2);
                    $ideasIdsArray = $collection2->all();
                }
            }

            
            //$collection2->shuffle();
            $ideasIdsArray = $collection2->all();

            $value2 = $collection2->shift();
            $ideasIdsArray = $collection2->all();
            
            $ideatosend = Idea::where('id','=', $value2)->first();

            if($ideatosend)
            {
                $user->notify(new SendShuffledIdeasNotification($ideatosend));

                $ideauser = array(
                    'ideauser_user_id' => $user->id,
                    'ideauser_idea_id' => $value2,
                );
                Ideauser::create($ideauser);
            }
            
            if($v1)
            {
                $collection2->push($idea->id);
                $ideasIdsArray = $collection2->all();
            }
            
            $arraytoadd= $collection4->all();
            foreach($arraytoadd as $value)
            {   
                $collection2->push($value);
                $ideasIdsArray = $collection2->all();
                
            }
        }
        
        return redirect()->route('show', ['wid' => $wid, 'mid' => $mid])->with('message5', 'The ideas were successfully sent.');
    }


    public function chooseidea($wid, $mid, $iid)
    {
        $idea = Idea::where([['idea_workshop_id', '=', $wid], ['id', '=', $iid ]])->first();
        
        if($idea->idea_chosen == 1)
        {
            $idea->idea_chosen = 0;
        }
        else{
            $idea->idea_chosen = 1;
        }

        $idea->save();
        return redirect()->route('show', ['wid' => $wid, 'mid' => $mid]);
    }



    public function storegroup(Request $request, $wid, $mid)
    {
        $ideas = Idea::where('idea_workshop_id', '=', $wid)->get();
        $groups = Group::all();
        

        foreach($ideas as $idea)
        {
            $flag =0;
            if($idea->idea_chosen)
            {
                foreach($groups as $group){
                    if($group->group_idea_id == $idea->id)
                    {  
                        $flag =1;
                    break;
                    }
                }
                if($flag == 0)
                {

                    $group = array(
                        'group_name' => $idea->idea_title,
                        'group_idea_id' => $idea->id,
                    );
                    Group::create($group);
                }
            }
            
        }

        return redirect()->route('show', ['wid' => $wid, 'mid' => $mid]);
    }


    public function showgroup($gid, $wid, $mid)
    {
        $monitor = User::findOrfail($mid);
        $group = Group::findOrfail($gid);

        $workshop = Workshop::findOrfail($wid);

        $idea = Idea::where('id', '=', $group->group_idea_id)->first();

        $users = DB::table('users')
                     ->join('groupusers', 'users.id', '=', 'groupusers.groupuser_user_id')
                     ->join('groups', 'groupusers.groupuser_group_id', '=', 'groups.id')
                     ->join('ideas', 'groups.group_idea_id', '=', 'ideas.id')
                     ->join('workshops', 'ideas.idea_workshop_id', '=', 'workshops.id')
                     ->select('users.*', 'groupusers.*')
                     ->where('groupuser_group_id', '=', $gid)
                     ->get();

        return view('monitor.showgroup', compact('group', 'workshop','idea', 'users', 'monitor'));
    }



    public function editgroup($gid, $wid, $mid)
    {
        $monitor = User::findOrfail($mid);
        $workshop = Workshop::findOrfail($wid);
        $group = Group::findOrfail($gid);

        $users = DB::table('users')
                     ->join('groupusers', 'users.id', '=', 'groupusers.groupuser_user_id')
                     ->join('groups', 'groupusers.groupuser_group_id', '=', 'groups.id')
                     ->join('ideas', 'groups.group_idea_id', '=', 'ideas.id')
                     ->join('workshops', 'ideas.idea_workshop_id', '=', 'workshops.id')
                     ->select('users.*', 'groupusers.*')
                     ->where('groupuser_group_id', '=', $gid)
                     ->get();

        return view('monitor.editgroup', compact('group','users', 'workshop', 'monitor'));
    }



    public function updategroup(Request $request, $gid, $wid, $mid)
    {
        $request->validate([
            'group_name' => 'required',
        ]);

        $group = array(
            'group_name' => $request->group_name,
        );

        Group::whereId($gid)->update($group);

        return redirect()->route('show', ['wid' => $wid, 'mid' => $mid])->with('message7', 'The group was successfully updated.');
    }



    public function destroygroup($gid, $wid, $mid)
    {
        $group = Group::findOrfail($gid);
        
        $idea = array(
            'idea_chosen' => 0,
        );
        Idea::whereId($group->group_idea_id)->update($idea);

        $groupusers = Groupuser::all();
        foreach($groupusers as $groupuser)
        {
            if($groupuser->groupuser_group_id == $gid){
                $user = User::where('id','=', $groupuser->groupuser_user_id)->first();
                $user->user_chosen = 0;
                $user->save();
                Groupuser::where('groupuser_group_id', '=', $gid)->delete();
            }
        }

        $group->delete();
        
        return redirect()->route('show', ['wid' => $wid, 'mid' => $mid])->with('message6', 'The group was successfully deleted!');
    }


    public function destroyparticipant($uid, $gid, $wid, $mid)
    {
        Groupuser::where([['groupuser_group_id', '=', $gid], ['groupuser_user_id', '=', $uid]])->delete();

        $monitor = User::findOrfail($mid);
        $workshop = Workshop::findOrfail($wid);
        $group = Group::findOrfail($gid);

        $users = DB::table('users')
                     ->join('groupusers', 'users.id', '=', 'groupusers.groupuser_user_id')
                     ->join('groups', 'groupusers.groupuser_group_id', '=', 'groups.id')
                     ->join('ideas', 'groups.group_idea_id', '=', 'ideas.id')
                     ->join('workshops', 'ideas.idea_workshop_id', '=', 'workshops.id')
                     ->select('users.*', 'groupusers.*')
                     ->where('groupuser_group_id', '=', $gid)
                     ->get();

        return view('monitor.editgroup', compact('group','users', 'workshop', 'monitor'));
    }
    
}
