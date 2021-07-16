<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Hash;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function customLogin(Request $request){
        $model = User::where('email', $request->email)->where('user_type',1)->first();
        if($model==null){
            $data = array(
                'login_token' => '',
                'status' => 0
            );
        }else{
            if (Hash::check($request->password, $model->password, [])) {
                Auth::loginUsingId($model->id, true);
                $data = array(
                    'login_token' => '',
                    'status' => 1
                );
            }else{
                $data = array(
                    'login_token' => '',
                    'status' => 0
                );
            }
        }

        

        return response()->json($data);

    }
    public function authenticated(Request $request, $user) {
        $user->last_login = Carbon::now()->toDateTimeString();
        $user->last_login_ip = $request->getClientIp();
        
        $user->save();
    }
}
