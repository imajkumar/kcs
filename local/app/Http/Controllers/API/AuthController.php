<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Arr;

class AuthController extends Controller
{
    //getCompletedCouserByEmpID
    public function getCompletedCouserByEmpID(Request $request)
    {
        $emp_id=$request->emp_id;

        $usersArr = DB::table('course_progress')
            ->where('user_id',$emp_id)
            ->where('point',100)
            ->get();
            $users = DB::table('users')
            ->where('id',$emp_id)          
            ->first();

            $data=array();
            foreach ($usersArr as $key => $value) {

            $courseArr = DB::table('course_list')
            ->where('id',$value->course_id)          
            ->first();
            $user_coursecatArr = DB::table('user_coursecat_list')
            ->where('course_id',$value->course_id)          
            ->where('user_id',$value->user_id)          
            ->first();
            $sub_cat_id=$user_coursecatArr->sub_cat_id;
            $courseSubcatArr = DB::table('coursecat_list')
            ->where('id',$sub_cat_id)          
            ->first();

               $data[]=array(
                   'user_id'=>$value->user_id,
                   'user_name'=>$users->firstname."".$users->lastname,
                   'course_name'=>$courseArr->name,
                   'sub_cate_name'=>$courseSubcatArr->name_cat,
                   'point'=>$value->point,
                   'completed_at'=>$user_coursecatArr->created_at
               );
            }



            if(count($usersArr)>0){
                $accessToken = '';
                $message = strtoupper('SUCCESS-CATEGORY');
                $message_action = "Auth:setCategorywithEmpID-001";
    
                return $this->setSuccessResponse($data, $message, "Auth:setCategorywithEmpID", $accessToken, $message_action);
    
            }else{
                $message = strtoupper('Not found');
                $message_action = "Auth:setCategorywithEmpID-002";
                return $this->setWarningResponse([], $message, $message_action, "", $message_action);
            }

            
           


    }
    //getCompletedCouserByEmpID


    //setSubCategorywithEmpIDwithSubCatIDCouserID
    public function setSubCategorywithEmpIDwithSubCatIDCouserID(Request $request)
    {
         $course_id = $request->course_id;
         $emp_id = $request->emp_id;
         $sub_cat_id = $request->sub_cat_id;
        $courseArr = DB::table('user_coursecat_list')
            ->where('course_id', $course_id)
            ->where('sub_cat_id', $sub_cat_id)
            ->where('user_id', $emp_id)
            ->first();
        if ($courseArr == null) {

            DB::table('user_coursecat_list')->insert([
                'course_id' => $course_id,
                'sub_cat_id' => $sub_cat_id,
                'user_id' => $emp_id,
                'created_at' => date('Y-m-d H:i:s'),

            ]);

            DB::table('course_progress')
            ->updateOrInsert(
                ['user_id' => $emp_id, 'course_id' => $course_id],
                ['point' => '100']
            );

            $data = DB::table('user_coursecat_list')
                ->join('course_list', 'user_coursecat_list.course_id', '=', 'course_list.id')
                ->join('coursecat_list', 'user_coursecat_list.sub_cat_id', '=', 'coursecat_list.id')
                ->where('user_coursecat_list.user_id', $emp_id)

                ->select('course_list.id as course_id', 'course_list.name', 'course_list.photo as coursePhoto', 'course_list.base_path','coursecat_list.name_cat as sub_cat_name','coursecat_list.photo as cousercat_photo')
                ->get();



            $accessToken = '';

            $message = strtoupper('SUCCESS-CATEGORY');
            $message_action = "Auth:setCategorywithEmpID-001";

            return $this->setSuccessResponse($data, $message, "Auth:setCategorywithEmpID", $accessToken, $message_action);

        }else{
            $data = DB::table('user_coursecat_list')
            ->join('course_list', 'user_coursecat_list.course_id', '=', 'course_list.id')
            ->join('coursecat_list', 'user_coursecat_list.sub_cat_id', '=', 'coursecat_list.id')
            ->where('user_coursecat_list.user_id', $emp_id)

            ->select('course_list.id as course_id', 'course_list.name', 'course_list.photo as coursePhoto', 'course_list.base_path','coursecat_list.name_cat as sub_cat_name','coursecat_list.photo as cousercat_photo')
            ->get();


            $message = strtoupper('Already added');
            $message_action = "Auth:setSubCategorywithEmpIDwithSubCatIDCouserID-002";
            return $this->setWarningResponse($data, $message, $message_action, "", $message_action);

        }
    }
    //setSubCategorywithEmpIDwithSubCatIDCouserID
    //setCategorywithEmpID
    public function setCategorywithEmpID(Request $request)
    {
        $course_id = $request->course_id;
        $emp_id = $request->emp_id;
        $courseArr = DB::table('user_course_list')
            ->where('course_id', $course_id)
            ->first();
        if ($courseArr == null) {
            DB::table('user_course_list')->insert([
                'course_id' => $course_id,
                'user_id' => $emp_id,
                'created_at' => date('Y-m-d H:i:s'),

            ]);

            DB::table('course_progress')
            ->updateOrInsert(
                ['user_id' => $emp_id, 'course_id' => $course_id],
                ['point' => '0']
            );

            $data = DB::table('user_course_list')
                ->join('course_list', 'user_course_list.course_id', '=', 'course_list.id')
                ->where('user_course_list.user_id', $emp_id)

                ->select('course_list.id as course_id', 'course_list.name', 'course_list.photo', 'course_list.base_path')
                ->get();



            $accessToken = '';

            $message = strtoupper('SUCCESS-CATEGORY');
            $message_action = "Auth:setCategorywithEmpID-001";

            return $this->setSuccessResponse($data, $message, "Auth:setCategorywithEmpID", $accessToken, $message_action);
        } else {
            $data = DB::table('user_course_list')
            ->join('course_list', 'user_course_list.course_id', '=', 'course_list.id')
            ->where('user_course_list.user_id', $emp_id)

            ->select('course_list.id as course_id', 'course_list.name', 'course_list.photo', 'course_list.base_path')
            ->get();

            $message = strtoupper('Already added');
            $message_action = "Auth:setCategorywithEmpID-002";
            return $this->setWarningResponse($data, $message, $message_action, "", $message_action);
        }
    }
    //setCategorywithEmpID

    //getCategoryByEmpID
    public function getCategoryByEmpID(Request $request)
    {
        $emp_id = $request->emp_id;
        $data = DB::table('user_course_list')
        ->join('course_list', 'user_course_list.course_id', '=', 'course_list.id')
        ->join('course_progress', 'user_course_list.course_id', '=', 'course_progress.course_id')

        ->where('user_course_list.user_id', $emp_id)

        ->select('course_list.id as course_id', 'course_list.name', 'course_list.photo', 'course_list.base_path','course_progress.point')
        ->get();

       

        $accessToken = '';

        $message = strtoupper('SUCCESS-CATEGORY');
        $message_action = "Auth:CATEGORY-001";

        return $this->setSuccessResponse($data, $message, "Auth:Login", $accessToken, $message_action);
    }

    //getCategoryByEmpID

    //getProgressByEmpID
    public function getProgressByEmpID(Request $request)
    {
        $emp_id = $request->emp_id;

        $data = DB::table('course_progress')
            ->join('course_list', 'course_progress.course_id', '=', 'course_list.id')
            ->where('course_progress.user_id', $emp_id)

            ->select('course_list.name as course_name', 'course_list.photo', 'course_list.base_path', 'course_progress.point', 'course_progress.id')
            ->get();


        $accessToken = '';

        $message = strtoupper('SUCCESS-CATEGORY');
        $message_action = "Auth:CATEGORY-001";

        return $this->setSuccessResponse($data, $message, "Auth:Login", $accessToken, $message_action);
    }

    //getSubCategoryByCateID
    //getSubCategoryByEmpID
    public function getSubCategoryByEmpID(Request $request)
    {
        $emp_id = $request->emp_id;

        $data = DB::table('user_coursecat_list')
                ->join('course_list', 'user_coursecat_list.course_id', '=', 'course_list.id')
                ->join('coursecat_list', 'user_coursecat_list.sub_cat_id', '=', 'coursecat_list.id')
                ->join('course_progress', 'user_coursecat_list.course_id', '=', 'course_progress.course_id')
                ->where('user_coursecat_list.user_id', $emp_id)
                ->select('course_list.id as course_id', 'course_list.name', 'course_list.photo as coursePhoto', 'course_list.base_path','coursecat_list.name_cat as sub_cat_name','coursecat_list.photo as cousercat_photo','course_progress.point')
                ->get();


        $accessToken = '';

        $message = strtoupper('SUCCESS-CATEGORY');
        $message_action = "Auth:CATEGORY-001";

        return $this->setSuccessResponse($data, $message, "Auth:Login", $accessToken, $message_action);
    }

    //getSubCategoryByEmpID


    //getSubCategoryByCateID
    public function getSubCategoryByCateID(Request $request)
    {
        $course_id = $request->cat_id;

        $data = DB::table('coursecat_list')
            ->rightJoin('course_list', 'coursecat_list.course_id', '=', 'course_list.id')
            ->where('coursecat_list.is_deleted', 0)
            ->where('coursecat_list.course_id', $course_id)
            ->select('course_list.id as cat_id', 'coursecat_list.id as subcat_id', 'course_list.name  as catname', 'coursecat_list.name_cat as sub_catname', 'coursecat_list.photo', 'coursecat_list.base_path')
            ->get();

        $accessToken = '';

        $message = strtoupper('SUCCESS-CATEGORY');
        $message_action = "Auth:CATEGORY-001";

        return $this->setSuccessResponse($data, $message, "Auth:Login", $accessToken, $message_action);
    }

    //getSubCategoryByCateID

    //getProgress
    public function getProgress(Request $request)
    {


        $data = DB::table('course_progress')
            ->join('course_list', 'course_progress.course_id', '=', 'course_list.id')
            ->select('course_list.name', 'course_list.photo', 'course_list.base_path', 'course_progress.point')
            ->get();


        $accessToken = '';

        $message = strtoupper('SUCCESS-CATEGORY');
        $message_action = "Auth:CATEGORY-001";

        return $this->setSuccessResponse($data, $message, "Auth:Login", $accessToken, $message_action);
    }

    //getProgress

    //getSubCategory
    public function getSubCategory(Request $request)
    {
        $data = DB::table('coursecat_list')
            ->get();

        $data = DB::table('coursecat_list')
            ->rightJoin('course_list', 'coursecat_list.course_id', '=', 'course_list.id')
            ->where('coursecat_list.is_deleted', 0)
            ->select('coursecat_list.id', 'course_list.id as catid', 'coursecat_list.name_cat', 'coursecat_list.photo', 'coursecat_list.base_path')
            ->get();

        $accessToken = '';

        $message = strtoupper('SUCCESS-CATEGORY');
        $message_action = "Auth:CATEGORY-001";

        return $this->setSuccessResponse($data, $message, "Auth:Login", $accessToken, $message_action);
    }

    //getSubCategory

    //getCategory
    public function getCategory(Request $request)
    {
        $data = DB::table('course_list')->where('is_deleted', 0)
            ->get();
        $accessToken = '';

        $message = strtoupper('SUCCESS-CATEGORY');
        $message_action = "Auth:CATEGORY-001";

        return $this->setSuccessResponse($data, $message, "Auth:Login", $accessToken, $message_action);
    }
    //getCategory



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
        $users = User::where('id', $request->emp_id)
            ->first();
        if ($users == null) {

            try {
                // attempt to verify the credentials and create a token for the user
                $message = strtoupper('Invalid Input Get Profile');
                $message_action = "Auth:Login";
                return $this->setWarningResponse([], $message, "Auth:GetProfile", "", $message_action);
            } catch (\Exception $ex) {
                return $this->setErrorResponse([], $ex->getMessage());
            }
        } else {
            $model = User::where('id', $request->emp_id)->first();

            Auth::loginUsingId($model->id, true);

            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            $userA = auth()->user();
            $data = $userA->only(['id', 'firstname', 'lastname', 'email', 'phone', 'user_position', 'address', 'created_at', 'avatar', 'base_path']);
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
        $users = User::where('id', $request->id)
            ->first();

        if ($users == null) {

            try {
                // attempt to verify the credentials and create a token for the user
                $message = strtoupper('Invalid Login credential');
                $message_action = "Auth:Login";
                return $this->setWarningResponse([], $message, "Auth:Login", "", $message_action);
            } catch (\Exception $ex) {
                return $this->setErrorResponse([], $ex->getMessage());
            }
        } else {

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

                $userA = auth()->user();
                $data = $userA->only(['id', 'firstname', 'lastname', 'email', 'phone', 'user_position', 'address', 'created_at', 'avatar', 'base_path']);

                $message = strtoupper('SUCCESS-LOGIN');
                $message_action = "Auth:Login-001";

                return $this->setSuccessResponse($data, $message, "Auth:Login", $accessToken, $message_action);
            } else {
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
