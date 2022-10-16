<?php

namespace App\Http\Middleware;

use Closure;
use App\Setting;
use Illuminate\Support\Facades\Auth;

class ApprovalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            $setting = Setting::first();

            if(Auth::user()->user_status_id == 2)
            {
                if($setting->setting_auto_approve == false){
                    Auth::logout();
                    return redirect('login')->with('message', 'Your account needs an administrator approval in order to login');
                }
                else{
                    $user = Auth::user();
    
                    $user->user_status_id =1;
                    $user->save();
    
                    Auth::logout();
                    return redirect('login')->with('message', 'Your account is approved.');
                }
            }
        }

        return $next($request);
        
    }
}