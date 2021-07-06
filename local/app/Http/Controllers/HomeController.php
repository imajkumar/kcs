<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Role;
use AyraConstant;
use Theme;
use Response;
use DB;
class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    //$this->middleware('auth');
  }

  
  public function getCityByStateID(Request $request)
  {
    $state_id=$request->state_id;
    $country_id=$request->country_id;

    $users = DB::table('cities')->where('country_id',$country_id)->where('state_id',$state_id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

    return Response::json($users);

  }

  //getStateByCountryID
  public function getStateByCountryID(Request $request)
  {
    $country_id=$request->country_id;
    $users = DB::table('states')->where('country_id',$country_id)
    ->select('id', 'name')
    ->orderBy('name')
    ->get();

    $countrtyData = DB::table('countries')->where('id',$country_id)
            ->select('phonecode','emoji')
            ->first();
            $data=array(
              'stateData'=>$users,
              'countryData'=>$countrtyData,


            );

    return Response::json($data);

  }
  //getStateByCountryID

  public function index()

  {

  
    if (Auth::user()) {
      $UserRole = getUserRole();
      switch ($UserRole) {
        case 'superadmin':
          return $this->SuperAdminDashboard();
          break;
        case 'admin':
          return $this->AdminDashboard();
          break;
        default:
          return $this->FrontEnd();
          break;
      }
    } else {
      return $this->FrontEnd();
    }
    // return view('home');
  }

  public function SuperAdminDashboard()
  {

    $theme = Theme::uses('adminsuper')->layout('layout');

    $data = ["avatar_img" => ''];
    return $theme->scope('index', $data)->render();
  }
  public function AdminDashboard()
  {

    $theme = Theme::uses('admin')->layout('layout');

    $data = ["avatar_img" => ''];
    return $theme->scope('index', $data)->render();
  }
  public function FrontEnd()
  {
    $theme = Theme::uses('default')->layout('layout');
    $data = ["name" => "Ajay"];
    return $theme->scope('index', $data)->render();
  }
}

/*----------------------------------------------------------------
$user = auth()->user();
            //Ayra();
            //print_r($user);
            $roleArr=Role::find($user->id)->slug;
          //  echo $user->getRoleNames();
            //dd($roleArr);
            $timeInEuropeParisTimezone = '2021-03-25 11:00:00';
          //  echo $timeInUTC = getBaseURL();
            //echo getCurrentURL();
          echo user_email();
            //print_r($getAJ);
/*------------------------------------------------------------------------