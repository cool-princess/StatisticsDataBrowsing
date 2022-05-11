<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Jobs\MailSend;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\SendGrid;

class MessageController extends Controller
{
    public function sendMail(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|email',
            'user_mail' => 'required|array',
            'user_mail.*' => 'required',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);
        $reserve_dt = Carbon::create($request->year, $request->month, $request->day, $request->hour, $request->minute, Carbon::now()->second);
        $users = [];
        foreach ($validated['user_mail'] as $user) {
            array_push($users, $user);
        }

        $message = new Message();
        $message->title = $request->title;
        $message->body = $request->body;
        $message->save();

        if($reserve_dt->toDateTimeString() == Carbon::now()->toDateTimeString()) {
            $message->delivered = 'YES';
            $message->send_date = Carbon::now();
            $message->save();   

            foreach($users as $user) {
                dispatch(new MailSend(json_decode($user)->email, new SendGrid(json_decode($user), $message)));
            }
            toastr()->success('メールが正常に送信されました。','',config('toastr.options'));
            return redirect()->route('mailCreate')->with(['success' => "メールが正常に送信されました。"]);

        } else { 

            $message->date_string = $reserve_dt;

            $message->save();   

            toastr()->success('メールが保存されました。','',config('toastr.options'));
            return redirect()->route('mailCreate')->with(['success' => "メールが保存されました。"]);
        }
    }
}