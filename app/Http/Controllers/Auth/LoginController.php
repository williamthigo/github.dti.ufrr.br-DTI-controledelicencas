<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request){

        $groups = Adldap::search()->groups()->get();
        $pessoas = array();
        foreach ($groups as $g) {
            // limitando acesso apenas a usuarios dos grupos CSI e CSM
            if($g->gidnumber[0] == 10004 || $g->gidnumber[0] == 10005){
                foreach ($g->memberuid as $m) {
                    array_push($pessoas, $m);
                }
            }
        }
        // dd(in_array($request->user, $pessoas));

        $username = $request->user.'@ufrr.br';
        $password = $request->password;

        $ldapUser = Adldap::search()->select([
                    'uid',
                    'cn',
                    'mail',
                    ])->where('mail', $username)->first();

        $userdb = User::where('nome','=',''.$ldapUser->uid[0])->first();

        if($ldapUser && Adldap::auth()->attempt($ldapUser->getDn(), $password, $bindAsUser = true) && in_array($request->user, $pessoas)){
            if($userdb instanceof User){
                $user = $userdb;
            }else{
                $user = new User();
            }
            $user->nome = "".$ldapUser->uid[0];
            $user->email = "".$ldapUser->mail[0];
            $user->password = Hash::make($password);
            $user->save();
        }else{
            return redirect('/home');
        }
        if(isset($user)) {
            // by logging the user we create the session so there is no need to login again (in the configured time
            Auth::login($user);
            return redirect('/home');
        }

        return false;
    }

    public function logout(Request $request){
        return redirect('login')->with(Auth::logout());
    }

}
