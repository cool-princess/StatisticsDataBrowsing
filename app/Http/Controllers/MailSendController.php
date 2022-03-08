<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;
use SendGrid;
use App\Models\User;
use App\Models\Mail;

class MailSendController extends Controller
{
    public function show()
    {
        if(Auth::guard('admin')->check())
        {
            $users = User::all();
            return view('pages.admin.mail_create', compact('users'));
        }
        else
            return redirect('/admin/login');
    }

    public function sendMail(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|email',
            'user_mail' => 'required|array',
            'user_mail.*' => 'required',
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);

        // $from = new SendGrid\Mail\From($validated['from']);

        // $tos = [];
        // foreach ($validated['user_mail'] as $user) {
        //     array_push($tos, new SendGrid\Mail\To(json_decode($user)->email, json_decode($user)->name));
        // }

        // $subject = new SendGrid\Mail\Subject($validated['subject']);

        // $htmlContent = new SendGrid\Mail\HtmlContent($validated['body']);

        // $email = new SendGrid\Mail\Mail(
        //     $from,
        //     $tos,
        //     $subject,
        //     null,
        //     $htmlContent
        // );

        $from = 'user9876123james@gmail.com';
        $to = '';
        foreach ($validated['user_mail'] as $user) {
            $to .= json_decode($user)->email;
        }

        switch ($request->input('action')) {
            case 'submit':
                dd('submit');
                /* Create instance of Sendgrid SDK */
                $sendgrid = new SendGrid(getenv('SENDGRID_API_KEY'));

                /* Send mail using sendgrid instance */
                $response = $sendgrid->send($email);
                if ($response->statusCode() == 202) {
                    return redirect()->route('/admin/mail_send')->with(['success' => "E-mails successfully sent out!!"]);
                }

                return back()->withErrors(json_decode($response->body())->errors);
    
            case 'save':
                $reserve_dt = Carbon::create($request->year, $request->month, $request->day, $request->hour, $request->minute);

                $mail = Mail::create([
                    'from_email' => $from,
                    'to_email' => $to,
                    'subject' => $request->subject,
                    'body' => $request->body,
                    'reserve_time' => $reserve_dt
                ]);

                toastr()->success('メールが保存されました。','',config('toastr.options'));
                return back();
        }
    }
}