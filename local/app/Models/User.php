<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens; // include this
use App\Permissions\HasPermissionsTrait;
use Illuminate\Auth\Passwords\CanResetPassword;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $guarded = [''];
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function sendPasswordResetNotification($token)
    {

        $this->notify(new \App\Notifications\ResetPasswordNotification($token));



    //     $usersArr = DB::table('password_resets')
    //         ->where('token', $token)
    //         ->first();
    //     $data = array(
    //         'token' =>$token          
       
    //       );
    //       echo $token;

       
    //    $sent_to=$usersArr->email;
    //    $use_data=$token;
    //    $subLine="Reset password Notification via";
    //    Mail::send('mail', $data, function ($message) use ($sent_to, $use_data, $subLine) {

    //     $message->to($sent_to, 'AjayK')->subject($subLine);
    //     // $message->cc($use_data->email, $use_data->name = null);
    //     //$message->bcc('udita.bointl@gmail.com', 'UDITA');
    //     $message->from('ajayit2020@gmail.com', 'Okey');
    //   });

    }

   
}



  //send email code
