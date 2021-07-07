<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    
    //getProfile
    public function getProfile(Request $request)
    {
        $validatedData = $request->only('emp_id');
        $rules = [

            'emp_id' => 'required'                

        ];
        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $message = strtoupper('Invalid Input');
            $message_action = "Auth:GetProfile-001";
            return $this->setWarningResponse([], $message, $message_action, "", $message_action);
        }
        $users = User::where('id',$request->emp_id)
        ->first();
        if($users==null){

            try {
                // attempt to verify the credentials and create a token for the user
                $message = strtoupper('Invalid Input Get Profile');
                $message_action = "Auth:Login";
                return $this->setWarningResponse([], $message, "Auth:GetProfile", "", $message_action);
    
            } catch (\Exception $ex) {
                return $this->setErrorResponse([],$ex->getMessage());
            }
    
    
           }else{
            $model = User::where('id', $request->emp_id)->first();

            Auth::loginUsingId($model->id, true);
            
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            $data = auth()->user();
            $message = strtoupper('SUCCESS-LOGIN');
            $message_action = "Auth:Login-001";

            return $this->setSuccessResponse($data, $message, "Auth:Login", $accessToken, $message_action);



           }


    }
    //getProfile


    public function login(Request $request)
    {
        $validatedData = $request->only('id', 'password');
        $rules = [

            'id' => 'required',
            'password' => 'required'            

        ];
        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $message = strtoupper('Invalid Input');
            $message_action = "Auth:Login-001";
            return $this->setWarningResponse([], $message, $message_action, "", $message_action);
        }
        //check as per provider id is exites or not if not then create if exista then do login and share token
        $users = User::where('id',$request->id)
        ->first();

       if($users==null){

        try {
            // attempt to verify the credentials and create a token for the user
            $message = strtoupper('Invalid Login credential');
            $message_action = "Auth:Login";
            return $this->setWarningResponse([], $message, "Auth:Login", "", $message_action);

        } catch (\Exception $ex) {
            return $this->setErrorResponse([],$ex->getMessage());
        }


       }else{

        $validatedData = $request->only('id', 'password');
        $rules = [

            'id' => 'required',
            'password' => 'required',            


        ];
        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $message = strtoupper('Invalid Credential');
            $message_action = "Auth:Login-002";
            return $this->setWarningResponse([], $message, "Auth:Login", "", $message_action);
        }

        $model = User::where('id', $request->id)->first();
       

        if (Hash::check($request->password, $model->password, [])) {
          

            Auth::loginUsingId($model->id, true);
           
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            $data = auth()->user();
            $message = strtoupper('SUCCESS-LOGIN');
            $message_action = "Auth:Login-001";

            return $this->setSuccessResponse($data, $message, "Auth:Login", $accessToken, $message_action);

        }else{
            $message = strtoupper('Invalid Credentials');
            $message_action = "Auth:Login-002";
            return $this->setWarningResponse([], $message, "Auth:Login", "", $message_action);

        }

        
        


       }




    }

    public function loginA(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);

    }
}
