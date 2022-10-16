<?php

namespace App\Http\Controllers;

use App\User;
use App\Setting;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        $users = User::where('id', '!=', 1)->get();

        return view('admin.adminhome', compact('users', 'setting'));
    }

    public function astatus(Request $request, $id)
    {
        $user = User::find($id);
        if($user->user_status_id == 1)
        {
            $user->user_status_id =2;
        }
        else{
            $user->user_status_id = 1;
        }
        $user->save();
        return Redirect::to('admin')->with('message', $user->user_first_name . '\'s status has been changed successfully.');
    }

    public function approving()
    {
        $setting = Setting::first();
        if($setting->setting_auto_approve == false)
        {
            $setting->setting_auto_approve = true;
        }
        else{
            $setting->setting_auto_approve = false;
        }
        $setting->save();
        return Redirect::to('admin');
    }
    
}
