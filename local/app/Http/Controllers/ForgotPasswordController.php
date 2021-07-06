<?php 

namespace App\Http\Controllers; 

use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use Mail; 
use Illuminate\Support\Str;
use App\Models\User; 
use Hash; 

class ForgotPasswordController extends Controller
{

    public function getPassword($token) { 

        return view('auth.passwords.reset', ['token' => $token]);
     }


//updatePassword
public function updatePassword(Request $request){
    //print_r($request->all());
    $token=$request->token;
    $password=$request->password;
    $password_confirmation=$request->password_confirmation;
    $updatePassword = DB::table('password_resets')
    ->where(['token' => $request->token])
    ->first();
    if(!$updatePassword){
        $data = array(
            'msg' => 'Invalid token!',
            'status' => 0
        );
    }else{
        if($password==$password_confirmation){

            $user = User::where('email',$updatePassword->email)
            ->update(['password' => Hash::make($request->password)]);

            DB::table('password_resets')->where(['token'=> $request->token])->delete();

            $data = array(
                'msg' => 'Your password has been changed!',
                'status' => 1
            );

        }else{
            $data = array(
                'msg' => 'Confirm Password does not match!',
                'status' => 0
            );
        }
       
    }
    return response()->json($data);

}
//updatePassword

 public function updatePasswordA(Request $request){

  $request->validate([
     
      'password' => 'required|string|min:6|confirmed',
      'password_confirmation' => 'required',

  ]);

  $updatePassword = DB::table('password_resets')
                      ->where(['token' => $request->token])
                      ->first();

  if(!$updatePassword)
      return back()->withInput()->with('error', 'Invalid token!');

    $user = User::where('email',$updatePassword->email)
                ->update(['password' => Hash::make($request->password)]);

    DB::table('password_resets')->where(['token'=> $request->token])->delete();

    return redirect('/login')->with('status', 'Your password has been changed!');

  }



  public function getEmail()
  {

     return view('auth.passwords.email');
  }
  public function postEmail(Request $request){
    $model = User::where('email', $request->email)->first();
        if($model==null){
            $data = array(
                'msg' => 'Invalid Credentials',
                'status' => 0
            );
        }else{
            $token =Str::random(40);
            DB::table('password_resets')->insert(
                ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
            );
      
            Mail::send('auth.authverify', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password Notification');
            });
            $data = array(
                'msg' => 'We have e-mailed your password reset link!',
                'status' => 1
            );

        }

        return response()->json($data);
  }

 public function postEmailA(Request $request)
  {
    $request->validate([
        'email' => 'required|email|exists:users',
    ]);

    $token =Str::random(40);

      DB::table('password_resets')->insert(
          ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
      );

      Mail::send('auth.authverify', ['token' => $token], function($message) use($request){
          $message->to($request->email);
          $message->subject('Reset Password Notification');
      });

      return back()->with('status', 'We have e-mailed your password reset link!');
  }
}