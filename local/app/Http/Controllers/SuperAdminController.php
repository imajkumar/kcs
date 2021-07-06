<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Theme;
use DB;
use Auth;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SuperAdminController extends Controller
{

   

    //getAnnoucedList
    //getAnnoucedList
    public function getAnnoucedList()
    {
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["avatar_img" => ''];
        return $theme->scope('get_annused_list', $data)->render();
    }


    //getHighcartUsersAddedMonthly
    public function getHighcartUsersAddedMonthly(Request $request)
    {
        $monthlyVal = array();
    $monthName = array();
    $year_digit = "2021";

    for ($x = 1; $x <= 12; $x++) {


     

      $data_output = 13;

      $monthlyVal[] = (float)$data_output;

      $month = $x;


      $month = substr($month, -2, 2);
      $mN = date('M-' . $year_digit, strtotime(date('Y-' . $month . '-d')));
      $monthName[] = $mN;
    }


    



    $resp = array(
      'monthlyValue' => $monthlyVal,
      'MonthName' => $monthName,

    );
    return response()->json($resp);


    }
    //getHighcartUsersAddedMonthly


    //uploadFile
    public function uploadFile(Request $request)
    {
        if($request->action==1){
           
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = $request->txtSID . "_user_" . rand(10, 1000) . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
                // save to local/public/uploads/photo/ as the new $filename
                //var/www/larachat/local/public/storage/users-avatar
                $path = $file->storeAs('doc', $filename);
        
        
                $affected = DB::table('users')
                    ->where('id', $request->txtSID,)
                    ->update(['avatar' => $filename]);
            }
            $data = array(
                'msg' => 'Uploaded Successfully',
                'status' => 1
            );
        }
   
      return response()->json($data);
   
    }
     //uploadFile


    public function UserResetPassword(Request $request)
    {

        if (!(Hash::check($request->get('current'), Auth::user()->password))) {
            // The passwords matches
            $res_arr = array(
                'status' => 2,
                'Message' => 'Your current password does not matches with the password you provided. Please try again..',
            );
            return response()->json($res_arr);
        }
        if (strcmp($request->get('current'), $request->get('password')) == 0) {
            //Current password and new password are same
            $res_arr = array(
                'status' => 3,
                'Message' => 'New Password cannot be same as your current password. Please choose a different password..',
            );
            return response()->json($res_arr);
        }

        //  $id = $request->user_id;
        // $user = User::find($id);
        // $this->validate($request, [
        //   'password' => 'required'
        // ]);

        // $input = $request->only(['password']);
        // $user->fill($input)->save();
        User::find(auth()->user()->id)->update(['password' => bcrypt($request->get('password'))]);

        Auth::logout();

        $res_arr = array(
            'status' => 1,
            'Message' => 'Password saved successfully.',
        );
        return response()->json($res_arr);
    }

    public function saveAdminProfile(Request $request)
    {

        $affected = DB::table('users')
            ->where('id', $request->txtSID)
            ->update([
                'name' => $request->name,
                //   'phone' => $request->phone,
                //   'gender' => $request->gender,
                //   'location_address' => $request->location,

            ]);

        $data = array(
            'msg' => 'Data saved Successfully',
            'status' => 1
        );
        return response()->json($data);
    }
    //saveUserData
    public function saveUserData(Request $request)
    {


        

          

            $users = DB::table('users')
                ->where('email', $request->email)
                ->first();

            if ($users == null) {
                $dev_role = Role::where('slug', 'user')->first();
                $dev_perm = Permission::where('slug', 'create-tasks')->first();
                $developer = new User();
                $developer->firstname = $request->firstname;
                $developer->lastname = $request->lastname;
                $developer->email = $request->email;
                $developer->phone = $request->phone;
                $developer->user_type = 3;
                $developer->gender = $request->gender;
                $developer->user_position = $request->user_position;
                $developer->password = bcrypt('123456');
                $developer->save();
                $developer->roles()->attach($dev_role);
                $developer->permissions()->attach($dev_perm);
                //send email to user
                $sent_to = $request->email;
                $subLine = "Login credential of KCS Guide";

                $data = array(
                    'title' => $request->firstname,
                    'email' => $request->email,
                    'password' => '123456',


                );

                Mail::send('mail_school', $data, function ($message) use ($sent_to,  $subLine) {

                    $message->to($sent_to, 'Bo')->subject($subLine);
                    //$message->cc($use_data->email, $use_data->name = null);
                    //$message->bcc('udita.bointl@gmail.com', 'UDITA');
                    $message->from('codexage@gmail.com', 'KCS Guide');
                });

                //send email to user
                $data = array(
                    'msg' => 'Submitted Successfully',
                    'status' => 1
                );
                return response()->json($data);
            } else {
                $data = array(
                    'msg' => 'Already Added ',
                    'status' => 1
                );
                return response()->json($data);
            }
        
    }
    //saveUserData

    //saveUserEdit
    public function saveUserEdit(Request $request)
    {

        $affected = DB::table('users')
            ->where('id', $request->txtSID)
            ->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'user_position' => $request->user_position,

            ]);

        $data = array(
            'msg' => 'Data saved Successfully',
            'status' => 1
        );
        return response()->json($data);
    }
    //saveUserEdit



    public function deletImage(Request $request)
    {
        switch ($request->action) {
            case 1:
                $affected = DB::table('schools')
                    ->where('id', $request->rowid)
                    ->update(['school_logo' => NULL]);

                $data = array(
                    'msg' => 'Submitted Successfully ..',
                    'status' => 1
                );
                return response()->json($data);

                break;
            case 2:
                DB::table('schools_slider_img')->where('id', $request->rowid)->delete();

                $data = array(
                    'msg' => 'Submitted Successfully',
                    'status' => 1
                );
                return response()->json($data);

                break;


            default:
                # code...
                break;
        }
    }
    //useractionUserIsActive
    public function useractionUserIsActive(Request $request)
    {
        $txtSID = $request->txtSID;
        $statusAction = $request->statusAction;
        if ($statusAction == 1) {
            $affected = DB::table('users')
                ->where('id', $request->txtSID)
                ->update(['is_active' => 1]);
            $data = array(
                'msg' => 'Activated Successfully',
                'status' => 1
            );
            return response()->json($data);
        } else {
            $affected = DB::table('users')
                ->where('id', $request->txtSID)
                ->update(['is_active' => 2]);
            $data = array(
                'msg' => 'De-Activated Successfully',
                'status' => 1
            );
            return response()->json($data);
        }
    }

    //useractionUserIsActive


    public function createOrSentSchoolAccount(Request $request)
    {

        $txtSID = $request->txtSID;
        $statusAction = $request->statusAction;
        if ($statusAction == 1) {

            $schoolArr = DB::table('schools')
                ->where('id', $txtSID)
                ->first();

            $users = DB::table('users')
                ->where('email', $schoolArr->email)
                ->first();

            if ($users == null) {
                $dev_role = Role::where('slug', 'admin')->first();
                $dev_perm = Permission::where('slug', 'create-tasks')->first();
                $developer = new User();
                $developer->name = $schoolArr->title;
                $developer->email = $schoolArr->email;
                $developer->password = bcrypt('123456');
                $developer->save();
                $developer->roles()->attach($dev_role);
                $developer->permissions()->attach($dev_perm);
                //send email to user
                $sent_to = $schoolArr->email;
                $subLine = "Login credential of KCS Guide";

                $data = array(
                    'title' => $schoolArr->title,
                    'email' => $schoolArr->email,
                    'password' => '123456',


                );

                Mail::send('mail_school', $data, function ($message) use ($sent_to,  $subLine) {

                    $message->to($sent_to, 'Bo')->subject($subLine);
                    //$message->cc($use_data->email, $use_data->name = null);
                    //$message->bcc('udita.bointl@gmail.com', 'UDITA');
                    $message->from('codexage@gmail.com', 'KCS Guide');
                });

                //send email to user
                $data = array(
                    'msg' => 'Submitted Successfully999',
                    'status' => 1
                );
                return response()->json($data);
            } else {
                $data = array(
                    'msg' => 'Submitted Successfully ..',
                    'status' => 1
                );
                return response()->json($data);
            }
        } else {
            $data = array(
                'msg' => 'Its okey',
                'status' => 1
            );
            return response()->json($data);
        }
    }



    //addUser
    public function addUser()
    {
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["avatar_img" => ''];
        return $theme->scope('add_user', $data)->render();
    }
    //addUser

    public function userList()
    {
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["avatar_img" => ''];
        return $theme->scope('userList', $data)->render();
    }

    //uploadUserPhoto
    public function uploadUserPhoto(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $request->txtSID . "_user_" . rand(10, 1000) . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
            // save to local/public/uploads/photo/ as the new $filename
            //var/www/larachat/local/public/storage/users-avatar
            $path = $file->storeAs('doc', $filename);


            $affected = DB::table('users')
                ->where('id', $request->txtSID,)
                ->update(['avatar' => $filename]);
        }
        $data = array(
            'msg' => 'Uploaded Successfully',
            'status' => 1
        );
        return response()->json($data);
    }

    //uploadUserPhoto



    //uploadSchoolSlider








    //deleteUser
    public function deleteUser(Request $request)
    {
        $affected = DB::table('users')
            ->where('id', $request->rowid)
            ->update(['is_deleted' => 1]);

        $data = array(
            'msg' => 'Deleted Successfully',
            'status' => 1
        );
        return response()->json($data);
    }
    //deleteUser




















    public function admin_profile()
    {
        $schoolsArr = DB::table('users')
            ->where('id', Auth::user()->id)
            ->first();
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["data" => $schoolsArr];
        return $theme->scope('view_adminprofile', $data)->render();
    }

    public function view_user($id)
    {
        $schoolsArr = DB::table('users')
            ->where('id', $id)
            ->first();
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["data" => $schoolsArr];
        return $theme->scope('view_user', $data)->render();
    }

    public function edit_user($id)
    {
        $schoolsArr = DB::table('users')
            ->where('id', $id)
            ->first();
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["data" => $schoolsArr];
        return $theme->scope('edit_user', $data)->render();
    }

    public function getDatatableUserList(Request $request)
    {
        $data_arr = array();

        $users_arrArr = DB::table('users')->where('user_type', 3)->where('is_deleted', 0)->orderBy('id', 'DESC')->get();


        $i = 0;
        foreach ($users_arrArr as $key => $value) {
            $i++;

            $schoolArr = DB::table('users')->where('id', $value->id)->whereNotNull('avatar')->first();
            if ($schoolArr == null) {
                $schLogo = NoImage();
            } else {
                $schLogo = asset('/local/storage/app/doc/') . "/" . $schoolArr->avatar;
            }

            //---------------------------------------

            $data_arr[] = array(
                'RecordID' => $value->id,
                'IndexID' => $i,
                'photo' => $schLogo,
                'name' => $value->firstname,
                'email' =>  $value->email,
                'phone' => $value->phone,
                'gender' => $value->gender,
                'status' => $value->is_active,
                'Actions' => ''

            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'  => true,
            'IndexID' => true,
            'photo'  => true,
            'name'      => true,
            'email'      => true,
            'phone'      => true,
            'gender'      => true,
            'status'      => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    
}
