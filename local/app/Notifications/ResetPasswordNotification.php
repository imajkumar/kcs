<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Mail;
class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $token;
    
    public function __construct($data)
    {
        $this->token = $data;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $sent_to= $notifiable->getEmailForPasswordReset();
        $token= $this->token;
        $data = array(
                    'token' =>$token          
               
                  );
       $use_data=$token;
       $subLine="Reset password Notification via";
       Mail::send('emails.user.reset', $data, function ($message) use ($sent_to, $use_data, $subLine) {

        $message->to($sent_to, 'AjayK')->subject($subLine);
        // $message->cc($use_data->email, $use_data->name = null);
        //$message->bcc('udita.bointl@gmail.com', 'UDITA');
        $message->from('ajayit2020@gmail.com', 'Okey');
      });


        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
    //     $url = url(config('app.url') . route('password.reset', [
    //         'token' => $this->token,
    //         'email' => $notifiable->getEmailForPasswordReset(),
    //     ], false));

    //    return (new MailMessage)->view('emails.user.reset', ['url' => $url]);
    
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
