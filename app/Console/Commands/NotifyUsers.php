<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Message;
use Carbon\Carbon;
use App\Jobs\MailSend;
use App\Models\User;
use App\Mail\SendGrid;

class NotifyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = date("Y-m-d H:i", strtotime(Carbon::now()->addMinutes(1)));
        logger($now);

        $messages = Message::get();
        if($messages !== null){
            $messages->where('reserve_time',  $now)->each(function($message) {
                if($message->delivered == '予')
                {
                    foreach($messages as $message) {
                        $from = getenv('MAIL_FROM_ADDRESS');
                        $to = $message->to_email;
                        $subject = $message->title;
                        $htmlContent = new SendGrid\Mail\HtmlContent($message->body);
                        $email = new SendGrid\Mail\Mail(
                            $from,
                            $to,
                            $subject,
                            null,
                            $htmlContent
                        );

                        dispatch(new MailSend($email));
                        toastr()->success('メールが正常に送信されました。','',config('toastr.options'));
                    }
                    $message->delivered = '送';
                    $message->send_date = Carbon::now();
                    $message->save();   
                }
            });
        }
    }
}
