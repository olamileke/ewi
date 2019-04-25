<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;

use Session;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Hash;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function credentials(Request $request)
    {
        $credentials=$request->only($this->username(), 'password');

        $credentials=array_add($credentials, 'is_activated', 1);

        return $credentials;
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $error='Username or Password is not correct';

        $user=User::where($this->username(), $request->{$this->username()})->first();

        if($user && Hash::check($request->password, $user->password) && $user->is_activated == 0)
        {
            $error='Please activate your account';
        }


        return redirect()->back()->
                withError($error)->
                withInput($request->only('email'));
    }
}
