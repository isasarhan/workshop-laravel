<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Notifications\AdminNewUserNotification;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_first_name' => ['required', 'string', 'max:255'],
            'user_last_name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if($data['level'] == 'monitor'){
            $level = DB::table('levels')->where('level_name', 'monitor')->first();
        }
        else{
            $level = DB::table('levels')->where('level_name', 'participant')->first();
        }
        $status = DB::table('statuses')->where('status_name', 'disapproved')->first();
        
        $user= User::create([
            'user_first_name' => $data['user_first_name'],
            'user_last_name' => $data['user_last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_level_id' => $level->id,
            'user_status_id'=> $status->id
        ]);

        $adminlevel = DB::table('levels')->where('level_name', 'admin')->first();
        $admin = User::where('user_level_id', '=', $adminlevel->id)->first();
        $admin->notify(new AdminNewUserNotification($user));

        return $user;
    }
}
