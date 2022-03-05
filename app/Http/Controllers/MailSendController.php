<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Mail\SendGrid;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailSendController extends Controller
{
    public function sendMail()
    {
        $user = User::find(1)->toArray();
        $input = ['message' => 'This is a test!'];
        Mail::to($user['email'])->send(new SendGrid($input));
        dd('Mail Send Successfully');
    }

    public function show()
    {
        $users = User::all();
        return view('pages.admin.mail_create', compact('users'));
    }
}