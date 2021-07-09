<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Theme;
use DB;
use Auth;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\SchoolCourse;

use Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SuperAdminController extends Controller
{



    public function SchoolRequestList(Request $request)
    {
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["avatar_img" => ''];
        return $theme->scope('school_list_requested', $data)->render();
    }
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
    //saveUserEdit
    public function saveUserEdit(Request $request)
    {

        $affected = DB::table('users')
            ->where('id', $request->txtSID)
            ->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'location_address' => $request->location,

            ]);

        $data = array(
            'msg' => 'Data saved Successfully',
            'status' => 1
        );
        return response()->json($data);
    }
    //saveUserEdit

    public function saveSportIntrest(Request $request)
    {
        if ($request->txtAction == 1) {
            DB::table('sports')->insert([
                'name' => $request->txtSport

            ]);
            $data = array(
                'msg' => 'Data saved Successfully',
                'status' => 1
            );
        } else {
            DB::table('interest')->insert([
                'name' => $request->txtInterest

            ]);
            $data = array(
                'msg' => 'Data saved Successfully',
                'status' => 1
            );
        }
        return response()->json($data);
    }
    public function basicSettings()
    {


        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["data" => ''];
        return $theme->scope('basic_settings', $data)->render();
    }
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

    public function useractionSchoolAccount(Request $request)
    {
        $txtSID = $request->txtSID;
        $statusAction = $request->statusAction;
        if ($statusAction == 1) {
            $affected = DB::table('schools')
                ->where('id', $request->txtSID)
                ->update(['status' => 1]);
            $data = array(
                'msg' => 'Activated Successfully',
                'status' => 1
            );
            return response()->json($data);
        } else {
            $affected = DB::table('schools')
                ->where('id', $request->txtSID)
                ->update(['status' => 2]);
            $data = array(
                'msg' => 'De-Activated Successfully',
                'status' => 1
            );
            return response()->json($data);
        }
    }
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
    public function editStaticContent($id)
    {
        $users = DB::table('cms_contents')->where('id', $id)->first();

        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["data" => $users];
        return $theme->scope('edit_static_content', $data)->render();
    }

    public function addStaticContent()
    {
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["avatar_img" => ''];
        return $theme->scope('add_static_content', $data)->render();
    }
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
    public function uploadSchoolSlider(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $request->txtSID . "_logo_" . rand(10, 1000) . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
            // save to local/uploads/photo/ as the new $filename
            $path = $file->storeAs('doc', $filename);

            DB::table('schools_slider_img')->insert([
                'sid' => $request->txtSID,
                'slider_img' => $filename

            ]);
        }
        $data = array(
            'msg' => 'Uploaded Successfully',
            'status' => 1
        );
        return response()->json($data);
    }

    //uploadSchoolSlider

    //=======================================
    public function uploadSchoolLogo(Request $request)
    {
        //upload avator phone
        if ($request->action == 11) {
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
        //upload avator phone
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $request->txtSID . "_logo_" . rand(10, 1000) . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
            // save to local/uploads/photo/ as the new $filename
            $path = $file->storeAs('doc', $filename);
            $affected = DB::table('schools')
                ->where('id', $request->txtSID)
                ->update(['school_logo' => $filename]);
        }
        $data = array(
            'msg' => 'Uploaded Successfully',
            'status' => 1
        );
        return response()->json($data);
    }
    public function uploadSchoolDoc(Request $request)
    {
        if ($request->action_upload == "_upload_Avatar") {

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = $request->txtSID . "_doc_" . rand(10, 1000) . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
                // save to local/uploads/photo/ as the new $filename
                $path = $file->storeAs('doc', $filename);
                $affected = DB::table('users')
                    ->where('id', $request->txtSID)
                    ->update(['avatar' => $filename]);
            }
        }
        //  print_r($request->all());
        DB::table('school_documents')->insert([
            'sid' => $request->txtSID,
            'doc_info' => $request->doc_info
        ]);
        $lid = DB::getPdo()->lastInsertId();


        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $request->txtSID . "_doc_" . rand(10, 1000) . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
            // save to local/uploads/photo/ as the new $filename
            $path = $file->storeAs('doc', $filename);
            $affected = DB::table('school_documents')
                ->where('id', $lid)
                ->update(['doc_name' => $filename]);
        }
    }

    //schoolAcceptedRejectAction
    public function schoolAcceptedRejectAction(Request $request)
    {
        if ($request->action == 1) {  //static detete conted 
            $affected = DB::table('schools')
                ->where('id', $request->rowid)
                ->update(['added_from_status' => 1, 'is_approved' => 1]);

            $data = array(
                'msg' => 'Deleted Successfullyy',
                'status' => 1
            );
        }
        if ($request->action == 2) {  //static detete conted 
            $affected = DB::table('schools')
                ->where('id', $request->rowid)
                ->update(['added_from_status' => 2, 'is_approved' => 2, 'action_remarks' => $request->msg]);
            //send email
            $schArr = DB::table('schools')
                ->where('id', $request->rowid)
                ->first();


            Mail::send('auth.rejectSchoool', ['token' => $request->msg], function ($message) use ($request, $schArr) {
                $message->to($schArr->email);
                $message->subject('School Rejectioion');
            });

            //send email
            $data = array(
                'msg' => 'Deleted Successfullyy',
                'status' => 1
            );
        }
        return response()->json($data);
    }
    //schoolAcceptedRejectAction

    //deletebyAction
    public function deletebyAction(Request $request)
    {
        if ($request->action == 1) {  //static detete conted 
            $affected = DB::table('cms_contents')
                ->where('id', $request->rowid)
                ->update(['is_deleted' => 1]);

            $data = array(
                'msg' => 'Deleted Successfullyy',
                'status' => 1
            );
        }
        return response()->json($data);
    }
    //deletebyAction

    public function deleteSportInterst(Request $request)
    {
        if ($request->action == 1) {
            $affected = DB::table('sports')
                ->where('id', $request->rowid)
                ->update(['is_deleted' => 1]);

            $data = array(
                'msg' => 'Deleted Successfully',
                'status' => 1
            );
        } else {
            $affected = DB::table('interest')
                ->where('id', $request->rowid)
                ->update(['is_deleted' => 1]);

            $data = array(
                'msg' => 'Deleted Successfully',
                'status' => 1
            );
        }

        return response()->json($data);
    }

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
    public function deleteSchool(Request $request)
    {
        $affected = DB::table('schools')
            ->where('id', $request->rowid)
            ->update(['is_deleted' => 1]);

        $data = array(
            'msg' => 'Deleted Successfully',
            'status' => 1
        );
        return response()->json($data);
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
                'name' => $value->name,
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

    //getSchoolRatingCommentsBySchool
    public function getSchoolRatingCommentsBySchool(Request $request)
    {


        if($request->starRadioVal==6){
            $scArr_arr = DB::table('school_user_rating')->where('sid',$request->sid)->get();

        }else{
            $scArr_arr = DB::table('school_user_rating')->where('rating_val',$request->starRadioVal)->where('sid',$request->sid)->get();

        }

        


        $data_arr = array();
        $i = 0;
        foreach ($scArr_arr as $key => $value) {
            $i++;
            $schorArrData = DB::table('schools')->where('id', $value->sid)->first();
            $schorUserArrData = DB::table('users')->where('id', $value->user_id)->first();

            $schoolArr = DB::table('users')->where('id', $value->user_id)->whereNotNull('avatar')->first();
            if ($schoolArr == null) {
                $schLogo = NoImage();
            } else {
                $schLogo = asset('/local/storage/app/doc/') . "/" . $schoolArr->avatar;
            }



            //---------------------------------------

            $data_arr[] = array(
                'RecordID' => $value->id,
                'IndexID' => $i,                
                'user_name' => $schorUserArrData->name,
                'user_pic' => $schLogo,
                'user_id' => $schoolArr->id,
                'rating' => $value->rating_val,
                'comment' => $value->comment,
                'created_at' => date('Y-m-d H:iA',strtotime($value->created_at)),
                'Actions' => ''

            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'  => true,
            'IndexID' => true,
            
            'user_name'    => true,
            'user_pic'     => true,
            'user_id'=>true,
            'rating'       => true,
            'comment'      => true,
            'created_at'   => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    //getSchoolRatingCommentsBySchool

    //getSchoolRatingComments
    public function getSchoolRatingComments(Request $request)
    {


        $scArr_arr = DB::table('school_user_rating')->where('sid',$request->sid)->get();


        $data_arr = array();
        $i = 0;
        foreach ($scArr_arr as $key => $value) {
            $i++;
            $schorArrData = DB::table('schools')->where('id', $value->sid)->first();
            $schorUserArrData = DB::table('users')->where('id', $value->user_id)->first();

            $schoolArr = DB::table('users')->where('id', $value->user_id)->whereNotNull('avatar')->first();
            if ($schoolArr == null) {
                $schLogo = NoImage();
            } else {
                $schLogo = asset('/local/storage/app/doc/') . "/" . $schoolArr->avatar;
            }



            //---------------------------------------

            $data_arr[] = array(
                'RecordID' => $value->id,
                'IndexID' => $i,                
                'user_name' => $schorUserArrData->name,
                'user_pic' => $schLogo,
                'user_id' => $schoolArr->id,
                'rating' => $value->rating_val,
                'comment' => $value->comment,
                'created_at' => date('Y-m-d H:iA',strtotime($value->created_at)),
                'Actions' => ''

            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'  => true,
            'IndexID' => true,
            
            'user_name'    => true,
            'user_pic'     => true,
            'user_id'=>true,
            'rating'       => true,
            'comment'      => true,
            'created_at'   => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }
    //getSchoolRatingComments

    //getSchoolPerformanceFilterTop
    public function getSchoolPerformanceFilterTop(Request $request)
    {

        if ($request->starRadioVal == 1) {
            $scArr_arr = DB::table('school_rating')->where('is_deleted', 0)->orderBy('avg_rating', 'asc')->get();

            $data_arr = array();
            $i = 0;
            foreach ($scArr_arr as $key => $value) {
                $i++;
                $schorArrData = DB::table('schools')->where('id', $value->sid)->first();

                //---------------------------------------

                $data_arr[] = array(
                    'RecordID' => $value->id,
                    'IndexID' => $i,
                    'school_title' => $schorArrData->title,
                    'rating' => $value->rating,
                    'avg_rating' => $value->avg_rating,
                    'country_name' => 'India',
                    'Actions' => ''

                );
            }

            $JSON_Data = json_encode($data_arr);
            $columnsDefault = [
                'RecordID'  => true,
                'IndexID' => true,
                'school_title'  => true,
                'rating'      => true,
                'avg_rating'      => true,
                'country_name'      => true,

                'Actions'      => true,
            ];
        }
        if ($request->starRadioVal == 2) {
            $scArr_arr = DB::table('school_rating')->where('is_deleted', 0)->orderBy('avg_rating', 'desc')->get();

            $data_arr = array();
            $i = 0;
            foreach ($scArr_arr as $key => $value) {
                $i++;
                $schorArrData = DB::table('schools')->where('id', $value->sid)->first();

                //---------------------------------------

                $data_arr[] = array(
                    'RecordID' => $value->id,
                    'IndexID' => $i,
                    'school_title' => $schorArrData->title,
                    'rating' => $value->rating,
                    'avg_rating' => $value->avg_rating,
                    'country_name' => 'India',
                    'Actions' => ''

                );
            }

            $JSON_Data = json_encode($data_arr);
            $columnsDefault = [
                'RecordID'  => true,
                'IndexID' => true,
                'school_title'  => true,
                'rating'      => true,
                'avg_rating'      => true,
                'country_name'      => true,

                'Actions'      => true,
            ];
        }





        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    //getSchoolPerformanceFilterTop

    //getSchoolPerformanceFilter
    public function getSchoolPerformanceA(Request $request)
    {


        $scArr_arr = DB::table('school_rating')->where('rating', $request->starRadioVal)->where('is_deleted', 0)->get();


        $data_arr = array();
        $i = 0;
        foreach ($scArr_arr as $key => $value) {
            $i++;
            $schorArrData = DB::table('schools')->where('id', $value->sid)->first();

            //---------------------------------------

            $data_arr[] = array(
                'RecordID' => $value->id,
                'IndexID' => $i,
                'school_title' => $schorArrData->title,
                'rating' => $value->rating,
                'avg_rating' => $value->avg_rating,
                'country_name' => 'India',
                'Actions' => ''

            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'  => true,
            'IndexID' => true,
            'school_title'  => true,
            'rating'      => true,
            'avg_rating'      => true,
            'country_name'      => true,

            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    //getSchoolPerformanceFilter
    public function calcAverageRating($ratings)
    {

        $totalWeight = 0;
        $totalReviews = 0;

        foreach ($ratings as $weight => $numberofReviews) {
            $WeightMultipliedByNumber = $weight * $numberofReviews;
            $totalWeight += $WeightMultipliedByNumber;
            $totalReviews += $numberofReviews;
        }

        //divide the total weight by total number of reviews
        $averageRating = $totalWeight / $totalReviews;

        return intVal($averageRating);
    }


    //getSchoolPerformanceFilterCountry
    public function getSchoolPerformanceFilterCountry(Request $request)
    {
        
        if($request->starRadioTOPVal==1){ //top //desc
            if($request->starRadioVal==6){
                if(empty($request->countryID)){
                    $scArr_arr = DB::table('school_rating')->where('is_deleted', 0)->orderBy('avg_rating','desc')->get();
                }else{
                    $scArr_arr = DB::table('school_rating')->where('country_id', $request->countryID)->where('is_deleted', 0)->orderBy('avg_rating','desc')->get();

                }
               


            }else{
                if(empty($request->countryID)){
                    $scArr_arr = DB::table('school_rating')->where('avg_rating', $request->starRadioVal)->where('is_deleted', 0)->orderBy('avg_rating','desc')->get();

                }else{
                    $scArr_arr = DB::table('school_rating')->where('country_id', $request->countryID)->where('avg_rating', $request->starRadioVal)->where('is_deleted', 0)->orderBy('avg_rating','desc')->get();
                }

                
            }
            
        }
        if($request->starRadioTOPVal==2){ //worst //asc
            if($request->starRadioVal==6){
                if(empty($request->countryID)){
                    $scArr_arr = DB::table('school_rating')->where('is_deleted', 0)->orderBy('avg_rating','asc')->get();

                }else{
                    $scArr_arr = DB::table('school_rating')->where('country_id', $request->countryID)->where('is_deleted', 0)->orderBy('avg_rating','asc')->get();

                 }

               
            }else{
                if(empty($request->countryID)){
                    $scArr_arr = DB::table('school_rating')->where('avg_rating', $request->starRadioVal)->where('is_deleted', 0)->orderBy('avg_rating','asc')->get();

                }else{
                    $scArr_arr = DB::table('school_rating')->where('country_id', $request->countryID)->where('avg_rating', $request->starRadioVal)->where('is_deleted', 0)->orderBy('avg_rating','asc')->get();
                }

                
            }
            

        }
        if($request->starRadioTOPVal==3){ //all with out asc and desc
            if($request->starRadioVal==6){
                if(empty($request->countryID)){
                    $scArr_arr = DB::table('school_rating')->where('is_deleted', 0)->orderBy('school_name','asc')->get();

                }else{
                    $scArr_arr = DB::table('school_rating')->where('country_id', $request->countryID)->where('is_deleted', 0)->orderBy('school_name','asc')->get();

                }

                

            }else{
                if(empty($request->countryID)){
                    $scArr_arr = DB::table('school_rating')->where('avg_rating', $request->starRadioVal)->where('is_deleted', 0)->orderBy('school_name','asc')->get();

                }else{
                    $scArr_arr = DB::table('school_rating')->where('country_id', $request->countryID)->where('avg_rating', $request->starRadioVal)->where('is_deleted', 0)->orderBy('school_name','asc')->get();
                }

                
            }
            
        }


       // $scArr_arr = DB::table('school_rating')->where('is_deleted', 0)->get();
        $data_arr = array();
        $i = 0;
        foreach ($scArr_arr as $key => $value) {
            $schorArrData = DB::table('schools')->where('id', $value->sid)->first();
            $scArr_arrcount = DB::table('school_user_rating')->where('sid', $value->sid)->count();
            $schorArrDataCountry = DB::table('countries')->where('id', $schorArrData->country_id)->first();

            $scArr_arrAVG_1 = DB::table('school_user_rating')->where('id', $value->sid)->where('is_deleted', 0)->where('rating_val', 1)->count();
            $scArr_arrAVG_2 = DB::table('school_user_rating')->where('id', $value->sid)->where('is_deleted', 0)->where('rating_val', 2)->count();
            $scArr_arrAVG_3 = DB::table('school_user_rating')->where('id', $value->sid)->where('is_deleted', 0)->where('rating_val', 3)->count();
            $scArr_arrAVG_4 = DB::table('school_user_rating')->where('id', $value->sid)->where('is_deleted', 0)->where('rating_val', 4)->count();
            $scArr_arrAVG_5 = DB::table('school_user_rating')->where('id', $value->sid)->where('is_deleted', 0)->where('rating_val', 5)->count();
    
    
    
            $ratings = array(
                5 => $scArr_arrAVG_5,
                4 => $scArr_arrAVG_4,
                3 => $scArr_arrAVG_3,
                2 => $scArr_arrAVG_2,
                1 => $scArr_arrAVG_1,
            );

            $avgRating = $this->calcAverageRating($ratings);

            $affected = DB::table('school_rating')
              ->where('sid', $value->sid)
              ->update([
                  'total_rating' => $scArr_arrcount,
                  'avg_rating' => $avgRating
                  ]);

                  $i++;

            $data_arr[] = array(
                'RecordID' => $value->sid,
                'IndexID' => $i,
                'school_title' => $schorArrData->title,
                'rating' => $scArr_arrcount,
                'avg_rating' => $avgRating,
                'country_name' => @$schorArrDataCountry->name,
                'Actions' => ''

            );

        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'  => true,
            'IndexID' => true,
            'school_title'  => true,
            'rating'      => true,
            'avg_rating'      => true,
            'country_name'      => true,

            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);


    }

    //getSchoolPerformanceFilterCountry

    public function getSchoolPerformance(Request $request)
    {
        $scArr_arr = DB::table('school_rating')->where('is_deleted', 0)->orderBy('school_name','asc')->get();
        $data_arr = array();
        $i = 0;
        foreach ($scArr_arr as $key => $value) {

            $schorArrData = DB::table('schools')->where('id', $value->sid)->first();
            $scArr_arrcount = DB::table('school_user_rating')->where('sid', $value->sid)->count();
            $schorArrDataCountry = DB::table('countries')->where('id', $schorArrData->country_id)->first();

            $scArr_arrAVG_1 = DB::table('school_user_rating')->where('id', $value->sid)->where('is_deleted', 0)->where('rating_val', 1)->count();
            $scArr_arrAVG_2 = DB::table('school_user_rating')->where('id', $value->sid)->where('is_deleted', 0)->where('rating_val', 2)->count();
            $scArr_arrAVG_3 = DB::table('school_user_rating')->where('id', $value->sid)->where('is_deleted', 0)->where('rating_val', 3)->count();
            $scArr_arrAVG_4 = DB::table('school_user_rating')->where('id', $value->sid)->where('is_deleted', 0)->where('rating_val', 4)->count();
            $scArr_arrAVG_5 = DB::table('school_user_rating')->where('id', $value->sid)->where('is_deleted', 0)->where('rating_val', 5)->count();
    
    
    
            $ratings = array(
                5 => $scArr_arrAVG_5,
                4 => $scArr_arrAVG_4,
                3 => $scArr_arrAVG_3,
                2 => $scArr_arrAVG_2,
                1 => $scArr_arrAVG_1,
            );

            $avgRating = $this->calcAverageRating($ratings);
            $affected = DB::table('school_rating')
              ->where('sid', $value->sid)
              ->update([
                  'total_rating' => $scArr_arrcount,
                  'avg_rating' => $avgRating,
                  'country_id' => $schorArrData->country_id,
                  'school_name' => $schorArrData->title,
                  ]);

                $i++;
            $data_arr[] = array(
                'RecordID' => $value->sid,
                'IndexID' => $i,
                'school_title' => $schorArrData->title,
                'rating' => $scArr_arrcount,
                'avg_rating' => $avgRating,
                'country_name' => @$schorArrDataCountry->name,
                'Actions' => ''

            );

        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'  => true,
            'IndexID' => true,
            'school_title'  => true,
            'rating'      => true,
            'avg_rating'      => true,
            'country_name'      => true,

            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);


    }

    

    //getCousePaymentByFilterThisWeek
    public function getCousePaymentByFilterThisWeek(Request $request)
    {
        $selectVal = $request->optN;
        $data = explode('@', $selectVal);
        $now = \Carbon\Carbon::now();
        $isd = $data[1];
        $selectVal = $request->payOPT;
        $dataPay = explode('@', $selectVal);
        $dataPayOption = $dataPay[0];
        switch ($dataPayOption) {
            case 1:
                # code...
                break;

            default:
                # code...
                break;
        }


        if ($data[0] == 1) {
            $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d');
            $schoolCourse = DB::table('school_course_student')
                ->where('is_deleted', 0)
                ->where('is_active', 1)
                ->where('course_id', $isd)
                ->whereBetween('created_at', [$weekStartDate, $weekEndDate])
                ->get();
            // echo "<pre>";
            // print_r($schoolCourse);
            // die;
        }
        if ($data[0] == 2) {
            $weekStartDate = $now->startOfMonth()->format('Y-m-d');
            $weekEndDate = $now->endOfMonth()->format('Y-m-d');

            $schoolCourse = DB::table('school_course_student')
                ->where('is_deleted', 0)
                ->where('is_active', 1)
                ->where('course_id', $isd)
                ->whereBetween('created_at', [$weekStartDate, $weekEndDate])
                ->get();
        }
        if ($data[0] == 3) {
            $myDate = '01/01/' . date('Y');
            $myDateA = '12/31/' . date('Y');

            $weekStartDate = Carbon::createFromFormat('m/d/Y', $myDate)
                ->startOfMonth()
                ->format('Y-m-d');
            $weekEndDate = Carbon::createFromFormat('m/d/Y', $myDateA)
                ->endOfMonth()
                ->format('Y-m-d');

            $schoolCourse = DB::table('school_course_student')
                ->where('is_deleted', 0)
                ->where('is_active', 1)
                ->where('course_id', $isd)
                ->whereBetween('created_at', [$weekStartDate, $weekEndDate])
                ->get();
        }
        $HTML = '';



        $i = 0;
        foreach ($schoolCourse as $key => $rowData) {
            $student_id = $rowData->student_id;
            $course_id = $rowData->course_id;
            $CourseArr = DB::table('school_course')
                ->where('id', $course_id)
                ->first();

            $users_arrArr = DB::table('users')->where('id', $student_id)->first();


            $schoolArr = DB::table('users')->where('id', $student_id)->whereNotNull('avatar')->first();
            if ($schoolArr == null) {
                $schLogo = NoImage();
            } else {
                $schLogo = asset('/local/storage/app/doc/') . "/" . $schoolArr->avatar;
            }

            switch ($rowData->payment_status) {
                case 1:
                    $paym = "Done";
                    break;
                case 1:
                    $paym = "downpayment";
                    break;

                default:
                    $paym = "NA";
                    break;
            }





            $i++;
            $uURL = getBaseURL() . '/view-user/' . $users_arrArr->id;
            $cdate = date('Y-m-d H:iA', strtotime($rowData->created_at));

            $HTML .= '<tr>
                        <td>' . $i . '</td>
                        <td>
                            <div class="symbol symbol-circle symbol-lg-50">
                                <img src="' . $schLogo . '" alt="image">
                            </div>
                        </td>
                        <td><a href="' . $uURL . '">' . $users_arrArr->name . '</a></td>
                        <td>' . $CourseArr->certificate_title . '</td>
                        <td>' . $cdate . '</td>
                        <td>' . $paym . '</td>
                        </tr>';
        }
        echo $HTML;
    }

    //getCousePaymentByFilterThisWeek
    //getCousePaymentByFilter
    public function getCousePaymentByFilter(Request $request)
    {
        $selectVal = $request->optN;
        $data = explode('@', $selectVal);

        $isd = $data[1];



        if ($data[0] == 1) {
            $schoolCourse = DB::table('school_course_student')
                ->where('is_deleted', 0)
                ->where('is_active', 1)
                ->where('course_id', $isd)
                ->where('payment_status', 1)
                ->get();
            // echo "<pre>";
            // print_r($schoolCourse);
            // die;
        }
        if ($data[0] == 2) {
            $schoolCourse = DB::table('school_course_student')
                ->where('is_deleted', 0)
                ->where('is_active', 1)
                ->where('course_id', $isd)
                ->where('payment_status', 2)
                ->get();
        }
        if ($data[0] == 3) {
            $schoolCourse = DB::table('school_course_student')
                ->where('is_deleted', 0)
                ->where('is_active', 1)
                ->where('course_id', $isd)
                ->get();
        }
        $HTML = '';



        $i = 0;
        foreach ($schoolCourse as $key => $rowData) {
            $student_id = $rowData->student_id;
            $course_id = $rowData->course_id;
            $CourseArr = DB::table('school_course')
                ->where('id', $course_id)
                ->first();

            $users_arrArr = DB::table('users')->where('id', $student_id)->first();


            $schoolArr = DB::table('users')->where('id', $student_id)->whereNotNull('avatar')->first();
            if ($schoolArr == null) {
                $schLogo = NoImage();
            } else {
                $schLogo = asset('/local/storage/app/doc/') . "/" . $schoolArr->avatar;
            }

            switch ($rowData->payment_status) {
                case 1:
                    $paym = "Done";
                    break;
                case 1:
                    $paym = "downpayment";
                    break;

                default:
                    $paym = "NA";
                    break;
            }





            $i++;
            $uURL = getBaseURL() . '/view-user/' . $users_arrArr->id;
            $cdate = date('Y-m-d H:iA', strtotime($rowData->created_at));

            $HTML .= '<tr>
                        <td>' . $i . '</td>
                        <td>
                            <div class="symbol symbol-circle symbol-lg-50">
                                <img src="' . $schLogo . '" alt="image">
                            </div>
                        </td>
                        <td><a href="' . $uURL . '">' . $users_arrArr->name . '</a></td>
                        <td>' . $CourseArr->certificate_title . '</td>
                        <td>' . $cdate . '</td>
                        <td>' . $paym . '</td>
                        </tr>';
        }
        echo $HTML;
    }
    //getCousePaymentByFilter

    public function getSchoolCertificatesByWeek(Request $request)
    {


        $now = \Carbon\Carbon::now();
        if ($request->selectedVal == 1) {
            $weekStartDate = $now->startOfWeek()->format('m/d/Y');
            $weekEndDate = $now->endOfWeek()->format('m/d/Y');
        }
        if ($request->selectedVal == 2) {
            $weekStartDate = $now->startOfMonth()->format('m/d/Y');
            $weekEndDate = $now->endOfMonth()->format('m/d/Y');
        }
        if ($request->selectedVal == 3) {
            $myDate = '01/01/' . date('Y');
            $myDateA = '12/31/' . date('Y');

            $weekStartDate = Carbon::createFromFormat('m/d/Y', $myDate)
                ->startOfMonth()
                ->format('m/d/Y');
            $weekEndDate = Carbon::createFromFormat('m/d/Y', $myDateA)
                ->endOfMonth()
                ->format('m/d/Y');
        }
        $dataArr=array(
            'start_date'=>$weekStartDate,
            'end_date'=>$weekEndDate,            
        );

        $data = array(
            'data' => $dataArr,
            'status' => 1
        );
    


    return response()->json($data);

        
    }
    //getSchoolCertificatesByWeek
    public function getSchoolCertificatesByWeekA(Request $request)
    {


        $now = \Carbon\Carbon::now();
        if ($request->selectedVal == 1) {
            $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d');
        }
        if ($request->selectedVal == 2) {
            $weekStartDate = $now->startOfMonth()->format('Y-m-d');
            $weekEndDate = $now->endOfMonth()->format('Y-m-d');
        }
        if ($request->selectedVal == 3) {
            $myDate = '01/01/' . date('Y');
            $myDateA = '12/31/' . date('Y');

            $weekStartDate = Carbon::createFromFormat('m/d/Y', $myDate)
                ->startOfMonth()
                ->format('Y-m-d');
            $weekEndDate = Carbon::createFromFormat('m/d/Y', $myDateA)
                ->endOfMonth()
                ->format('Y-m-d');
        }
        if ($request->selectedVal == 4) {
            $myDate = $request->startDate;
            $myDateA = $request->endDate;

            $weekStartDate = Carbon::createFromFormat('m/d/Y', $myDate)
                ->format('Y-m-d');
            $weekEndDate = Carbon::createFromFormat('m/d/Y', $myDateA)
                ->format('Y-m-d');
        }





        $contentArr = DB::table('school_course')
            ->where('is_deleted', 0)
            ->orderBy('id', 'desc')
            ->whereBetween('course_date', [$weekStartDate, $weekEndDate])
            ->get();
        $data_arr = array();
        $i = 0;
        foreach ($contentArr as $key => $rowData) {
            $i++;
            $schoolArr = DB::table('schools')
                ->where('id', $rowData->sid)
                ->first();
            $URL = getBaseURL() . "/view-school-details/" . $rowData->sid;
            $cid = $rowData->id;
            $stuCount = DB::table('school_course_student')
                ->where('course_id', $cid)
                ->count();

            $data_arr[] = array(
                'RecordID' => $rowData->id,
                'IndexID' => $i,
                'school_title' => $schoolArr->title,
                'certificate_title' => $rowData->certificate_title,
                'total_student' => $stuCount,
                'course_date' => $rowData->course_date,
                'Actions' => ''

            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'  => true,
            'IndexID' => true,
            'school_title'  => true,
            'certificate_title'      => true,
            'total_student'      => true,
            'course_date'      => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    //getSchoolCertificatesByWeek
    //getSchoolCertificatesBYFilter
    public function getSchoolCertificatesBYFilter(Request $request )
    {
        $startDate=date('Y-m-d',strtotime($request->startDate));
        $endDate=date('Y-m-d',strtotime($request->endDate));
       $sid=$request->sid;
       $endDate=$request->course;
 $now = \Carbon\Carbon::now();


      
 
 //->whereBetween('created_at', [$weekStartDate, $weekEndDate])

        $dcontentArr = DB::table('school_course')
            ->where('is_deleted', 0)
            ->orderBy('school_name', 'asc')
            ->where('is_deleted', 0)
          
            ->get();

            $contentArr=SchoolCourse::where('is_deleted',0);

            $contentArr->get();

        $data_arr = array();
        $i = 0;
        foreach ($contentArr as $key => $rowData) {
            $i++;
            $schoolArr = DB::table('schools')
                ->where('id', $rowData->sid)
                ->first();
            $URL = getBaseURL() . "/view-school-details/" . $rowData->sid;
            $cid = $rowData->id;
            $stuCount = DB::table('school_course_student')
                ->where('course_id', $cid)
                ->count();


                $affected = DB::table('school_course')
                ->where('sid', $rowData->sid)
                ->update([
                    'school_name' => $schoolArr->title                  


                ]);

            $data_arr[] = array(
                'RecordID' => $rowData->id,
                'IndexID' => $i,
                'school_title' => $schoolArr->title,
                'certificate_title' => $rowData->certificate_title,
                'total_student' => $stuCount,
                'course_date' => $rowData->course_date,
                'Actions' => ''

            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'  => true,
            'IndexID' => true,
            'school_title'  => true,
            'certificate_title'      => true,
            'total_student'      => true,
            'course_date'      => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    //getSchoolCertificatesBYFilter

    //getSchoolCertificates
    public function getSchoolCertificates(Request $request)
    {


        $contentArr = DB::table('school_course')
            ->where('is_deleted', 0)
            ->orderBy('school_name', 'asc')
            ->get();
        $data_arr = array();
        $i = 0;
        foreach ($contentArr as $key => $rowData) {
            $i++;
            $schoolArr = DB::table('schools')
                ->where('id', $rowData->sid)
                ->first();
            $URL = getBaseURL() . "/view-school-details/" . $rowData->sid;
            $cid = $rowData->id;
            $stuCount = DB::table('school_course_student')
                ->where('course_id', $cid)
                ->count();


                $affected = DB::table('school_course')
                ->where('sid', $rowData->sid)
                ->update([
                    'school_name' => $schoolArr->title                  


                ]);

            $data_arr[] = array(
                'RecordID' => $rowData->id,
                'IndexID' => $i,
                'school_title' => $schoolArr->title,
                'certificate_title' => $rowData->certificate_title,
                'total_student' => $stuCount,
                'course_date' => $rowData->course_date,
                'Actions' => ''

            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'  => true,
            'IndexID' => true,
            'school_title'  => true,
            'certificate_title'      => true,
            'total_student'      => true,
            'course_date'      => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    //getSchoolCertificates
    //getDatatableSchoolListData
    public function getDatatableSchoolListData(Request $request)
    {

        if ($request->schoolListFrom == 1) {
            $users_arr = DB::table('schools')->where('is_deleted', 0)->where('added_from_status', 1)->orderBy('id', 'DESC')->get();
        } else {
            $users_arr = DB::table('schools')->where('is_deleted', 0)->where('added_from_status', 2)->orderBy('id', 'DESC')->get();
        }


        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
            $i++;

            //---------------------------------------
            $proVal = is_school_completed($value->id);
            if ($proVal == 7) {
                $profile_status = 1;
            } else {
                $profile_status = 2;
            }
            $data_arr[] = array(
                'RecordID' => $value->id,
                'IndexID' => $i,
                'school_title' => $value->title,
                'rating' => $value->rating,
                'city' => optional(getCityData($value->city_id))->name,
                'email' => $value->email,
                'status' => $value->status,
                'profile_status' => $profile_status,
                'is_approved' => $value->is_approved,
                'Actions' => ''

            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'  => true,
            'IndexID' => true,
            'school_title'  => true,
            'rating'      => true,
            'email'      => true,
            'phone'      => true,
            'status'      => true,
            'profile_status'      => true,
            'is_approved' => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    //getDatatableSchoolListData
    public function getDatatableSchoolList(Request $request)
    {

        if ($request->schoolListFrom == 1) {
            $users_arr = DB::table('schools')->where('is_deleted', 0)->where('added_from_status', 1)->orderBy('id', 'DESC')->get();
        } else {
            $users_arr = DB::table('schools')->where('is_deleted', 0)->where('added_from_status', 2)->orderBy('id', 'DESC')->get();
        }


        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
            $i++;

            //---------------------------------------
            $proVal = is_school_completed($value->id);
            if ($proVal == 7) {
                $profile_status = 1;
            } else {
                $profile_status = 2;
            }
            $data_arr[] = array(
                'RecordID' => $value->id,
                'IndexID' => $i,
                'school_title' => $value->title,
                'rating' => $value->rating,
                'city' => optional(getCityData($value->city_id))->name,
                'email' => $value->email,
                'status' => $value->status,
                'profile_status' => $profile_status,
                'is_approved' => $value->is_approved,
                'Actions' => ''

            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'  => true,
            'IndexID' => true,
            'school_title'  => true,
            'rating'      => true,
            'email'      => true,
            'phone'      => true,
            'status'      => true,
            'profile_status'      => true,
            'is_approved' => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }
    //getSchoolCourse
    public function getSchoolCourse(Request $request)
    {

        $selectedSchool = $request->selectedSchool;
        $schArr = DB::table('schools')->where('id', $selectedSchool)->first();

        $schArrData = DB::table('school_course')->where('sid', $schArr->id)->get();
        $HTML = '<option value="">-SELECT-</option>';

        foreach ($schArrData as $key => $row) {

            $HTML .= '<option value="' . $row->certificate_title . '">' . $row->certificate_title . '</option>';
        }

        echo $HTML;



        //school_course

    }
    //getSchoolCourse
    //getMoreCertificate
    public function getMoreCertificate(Request $request)
    {
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["avatar_img" => ''];
        return $theme->scope('get_more_certificate', $data)->render();
    }

    //getMoreCertificate
    //getEnrollSchool
    public function getEnrollSchool($id)
    {
        $users = DB::table('school_course_student')->where('course_id', $id)->get();

        $theme = Theme::uses('adminsuper')->layout('layout');
        $data = ["data" => $users];
        return $theme->scope('get_coursewiseAllStudent', $data)->render();
    }

    //getEnrollSchool

    // updateSchoolInstructor
    public function updateSchoolInstructor(Request $request)
    {
        //print_r($request->all());
        $schoolHistoryArr = $request->instructor;
        $sid = $request->txtSValue;
        DB::table('school_instructor')->where('sid', $sid)->delete();
        foreach ($schoolHistoryArr as $key => $rowData) {
            DB::table('school_instructor')->insert([
                'sid' => $sid,
                'name' => $schoolHistoryArr[$key]['txtInstName'],
                'profile_url' => $schoolHistoryArr[$key]['txtInstProfileURL']


            ]);
        }
        $data = array(
            'msg' => 'Data saved Successfully',
            'status' => 1
        );
    }
    //updateUserInterest
    public function updateUserInterest(Request $request)
    {
        //print_r($request->all());
        $user_inerestArr = $request->user_inerest;
        $uid = $request->uid;
        DB::table('app_users_interest')->where('user_id', $uid)->delete();
        foreach ($user_inerestArr as $key => $rowData) {
            DB::table('app_users_interest')->insert([
                'user_id' => $uid,
                'interest_id' => $user_inerestArr[$key]


            ]);
        }
        $data = array(
            'msg' => 'Data saved Successfully',
            'status' => 1
        );
    }
    public function updateUserSport(Request $request)
    {
        //print_r($request->all());
        $user_inerestArr = $request->user_sport;
        $uid = $request->uid;
        DB::table('app_users_sports')->where('user_id', $uid)->delete();
        foreach ($user_inerestArr as $key => $rowData) {
            DB::table('app_users_sports')->insert([
                'user_id' => $uid,
                'sport_id' => $user_inerestArr[$key]


            ]);
        }
        $data = array(
            'msg' => 'Data saved Successfully',
            'status' => 1
        );
    }

    //updateUserInterest
    //updateSchoolInstructor
    public function updateSchoolHistory(Request $request)
    {
        //print_r($request->all());
        $schoolHistoryArr = $request->schoolHistory;
        $sid = $request->txtSIDValue;
        DB::table('school_history')->where('sid', $sid)->delete();
        foreach ($schoolHistoryArr as $key => $rowData) {
            DB::table('school_history')->insert([
                'sid' => $sid,
                'school_year' => $schoolHistoryArr[$key]['txtSchoolYear'],
                'school_students' => $schoolHistoryArr[$key]['txtSchoolStudent'],
                'school_notes' => $schoolHistoryArr[$key]['txtSchoolNotes'],

            ]);
        }
        $data = array(
            'msg' => 'Data saved Successfully',
            'status' => 1
        );
    }
    public function saveStaticContent(Request $request)
    {
        if ($request->staticAction == "_add") {
            DB::table('cms_contents')->insert([
                'title' => $request->title,
                'content' => $request->content,
                'is_active' => $request->isactive,

            ]);
            $data = array(
                'msg' => 'Data Saved Successfully',
                'status' => 1
            );
        }
        if ($request->staticAction == '_edit') {

            $affected = DB::table('cms_contents')
                ->where('id', $request->txtStaticID)
                ->update([
                    'title' => $request->title,
                    'content' => $request->content,
                    'is_active' => $request->isactive,


                ]);

            $data = array(
                'msg' => 'Data saved Successfully',
                'status' => 1
            );
        }


        return response()->json($data);
    }
    public function saveSchool(Request $request)
    {
        if ($request->txtAction == '_edit') {

            $affected = DB::table('schools')
                ->where('id', $request->txtSID)
                ->update([
                    'title' => $request->title,
                    'reg_no' => $request->regno,
                    // 'email' => $request->email,
                    'city_id' => $request->city,
                    'country_id' => $request->country,
                    'state_id' => $request->state,
                    'website' => $request->website,
                    'phone_code' => $request->phone_code,
                    'phone' => $request->phone,
                    'facebook' => $request->facebook,
                    'twitter' => $request->twitter,
                    'linkedin' => $request->linkedin,
                    'admin_comm' => $request->admin_comm,


                    'about' => $request->about,


                ]);

            $data = array(
                'msg' => 'Data saved Successfully',
                'status' => 1
            );
        }
        if ($request->txtAction == '_add') {
            $schoolsArr = DB::table('schools')
                ->where('email', $request->email)
                ->first();
            if ($schoolsArr != null) {
                $data = array(
                    'msg' => 'Already Created',
                    'status' => 0
                );
            } else {
                DB::table('schools')->insert([
                    'sid' => getSchoolCode(),
                    'title' => $request->title,
                    'reg_no' => $request->reg_no,
                    'email' => $request->email,
                    'city_id' => $request->city,
                    'country_id' => $request->country,
                    'state_id' => $request->state,
                    'phone_code' => $request->phone_code,
                    'phone' => $request->phone,

                ]);
                $data = array(
                    'msg' => 'Data Saved Successfully',
                    'status' => 1
                );
            }
        }




        return response()->json($data);
    }


    public function getSchoolCommentRating()
    {
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["avatar_img" => ''];
        return $theme->scope('school_comment_rating_list', $data)->render();
    }



    public function schoolPerformanceList()
    {
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["avatar_img" => ''];
        return $theme->scope('school_performance_list', $data)->render();
    }
    public function schoolCertificateList()
    {
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["avatar_img" => ''];
        return $theme->scope('school_certificate_list', $data)->render();
    }
    public function staticContentList()
    {
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["avatar_img" => ''];
        return $theme->scope('static_content_list', $data)->render();
    }
    public function add_school()
    {
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["avatar_img" => ''];
        return $theme->scope('add_school', $data)->render();
    }
    public function viewSchoolDetails($id)
    {
        $schoolsArr = DB::table('schools')
            ->where('id', $id)
            ->first();
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["data" => $schoolsArr];
        return $theme->scope('view_school_enroll_details', $data)->render();
    }
    //
    public function view_school_requested($id)
    {
        $schoolsArr = DB::table('schools')
            ->where('id', $id)
            ->first();
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["data" => $schoolsArr];
        return $theme->scope('view_school_requested', $data)->render();
    }


    public function view_school($id)
    {
        $schoolsArr = DB::table('schools')
            ->where('id', $id)
            ->first();
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["data" => $schoolsArr];
        return $theme->scope('view_school', $data)->render();
    }
    public function edit_school($id)
    {
        $schoolsArr = DB::table('schools')
            ->where('id', $id)
            ->first();
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["data" => $schoolsArr];
        return $theme->scope('edit_school', $data)->render();
    }


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


    public function schoolList()
    {
        $theme = Theme::uses('adminsuper')->layout('layout');

        $data = ["avatar_img" => ''];
        return $theme->scope('school_list', $data)->render();
    }
}
