<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
if (!function_exists('convertLocalToUTC')) {
    function convertLocalToUTC($time)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $time, 'Asia/Kolkata')->setTimezone('UTC');
    }
}

if (!function_exists('convertUTCToLocal')) {
    function convertUTCToLocal($time)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $time, 'UTC')->setTimezone('Asia/Kolkata');
    }
}
if (!function_exists('getBaseURL')) {
    function getBaseURL()
    {
        return URL::to('/');
    }
}
if (!function_exists('getCurrentURL')) {
    function getCurrentURL()
    {
        return URL::current();
    }
}
if (!function_exists('getProjectTitle')) {
    function getProjectTitle()
    {
        return 'KCS Guide';
    }
}
if (!function_exists('Ayra')) {
    function Ayra()
    {
        echo  '<pre>';
    }
}

if (!function_exists('applogo')) {
    function applogo()
    {
          return URL::to('/')."/"."svg_logo/logo vector file1.svg";
    }
}

if (!function_exists('applogopng')) {
    function applogopng()
    {
          return URL::to('/')."/"."svg_logo/logo.png";
    }
}
if (!function_exists('NoImage')) {
    function NoImage()
    {
          return URL::to('/')."/"."NoIcon.webp";
    }
}

if (!function_exists('getMaxID')) {
    function getMaxID()
    {
        //return Auth::user()->max;
        
        $max_id=DB::table('users')->max('id')+1;

        return $max_id;
    }
}

if (!function_exists('user_email')) {
    function user_email()
    {
        return Auth::user()->email;
    }
}
if (!function_exists('changeDateFormate')) {
    function changeDateFormate($date, $date_format)
    {

        return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);
    }
}
if (!function_exists('productImagePath')) {
    function productImagePath($image_name)
    {
        return public_path('images/products/' . $image_name);
    }
}

if (!function_exists('getUserRole')) {
    function getUserRole()
    {
        $user = auth()->user();
        // echo $user->id;
        $roles = DB::table('users_roles')            
            ->where('user_id',$user->id)
            ->first();
            $role_id=$roles->role_id;

        $roleArr=Role::find($role_id)->slug;
       
        return $roleArr;
    }
}






//composer dump-autoload
