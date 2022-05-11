<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Admin;
use App\Jobs\MailSend;
use Validator;
use SendGrid;
use App\Models\User;
use App\Models\Message;

class MailSendController extends Controller
{
    use ValidatesRequests;
    public function index ()
    {
        if(Auth::guard('admin')->check())
        {
            $admin_id = Auth::guard('admin')->user()->admin_id;
            $admin_break = Admin::select('break')->where('admin_id', '=', $admin_id)->get();
            if($admin_break[0]->break == 0) {
                Auth::guard('admin')->logout();
                $errors = new MessageBag(['admin_id' => ['許可が一時停止されました。']]);
                return view('auth.admin.login')->withErrors($errors);
            }
            
            $mails = Message::orderBy('created_at', 'desc')->paginate($perPage = 5);
            return view('pages.admin.mail_send', compact('mails'));
        }
        else
            return redirect('/admin/login');
    }

    public function show()
    {
        if(Auth::guard('admin')->check())
        {
            $admin_id = Auth::guard('admin')->user()->admin_id;
            $admin_break = Admin::select('break')->where('admin_id', '=', $admin_id)->get();
            if($admin_break[0]->break == 0) {
                Auth::guard('admin')->logout();
                $errors = new MessageBag(['admin_id' => ['許可が一時停止されました。']]);
                return view('auth.admin.login')->withErrors($errors);
            }
            
            $users = User::orderBy('created_at', 'desc')->get();
            $mail_count = Message::max('id') + 1;
            $all_user_count = User::count();
            $searched_user_count = 0;
            return view('pages.admin.mail_create', compact('users', 'mail_count', 'all_user_count', 'searched_user_count'));
        }
        else
            return redirect('/admin/login');
    }

    public function resendmail($id)
    {
        if(Auth::guard('admin')->check())
        {
            $admin_id = Auth::guard('admin')->user()->admin_id;
            $admin_break = Admin::select('break')->where('admin_id', '=', $admin_id)->get();
            if($admin_break[0]->break == 0) {
                Auth::guard('admin')->logout();
                $errors = new MessageBag(['admin_id' => ['許可が一時停止されました。']]);
                return view('auth.admin.login')->withErrors($errors);
            }

            $users = User::orderBy('created_at', 'desc')->get();
            $mails = Message::where('id', $id)->get();
            $mail_count = Message::max('id') + 1;
            $all_user_count = User::count();
            $searched_user_count = 0;
            return view('pages.admin.mail_resend', compact('users', 'mails', 'mail_count', 'all_user_count', 'searched_user_count'));
        }
        else
            return redirect('/admin/login');
    }

    public function mailSearch(Request $request)
    {
        $filters = [
            'keyword' => $request->keyword
        ];
        $mails = Message::where(function ($query) use ($filters) {
            if ($filters['keyword']) {
                $query->where('reserve_date', 'like', '%'.$filters['keyword'].'%')
                ->orwhere('delivered', 'like', '%'.$filters['keyword'].'%')
                ->orwhere('title', 'like', '%'.$filters['keyword'].'%')
                ->orwhere('body', 'like', '%'.$filters['keyword'].'%')
                ->orwhere('to_email', 'like', '%'.$filters['keyword'].'%')
                ->orwhere('send_date', 'like', '%'.$filters['keyword'].'%');
            }
        })->paginate(5);
        return view('pages.admin.mail_send', compact('mails'));
    }

    public function userMailSearch(Request $request , $id)
    {
        $filters = [
            'address1' => $request->prefecture,
            'sectors' => $request->industry,
            'free_word' => $request->free_word
        ];
        $users = User::where(function ($query) use ($filters) {
            if ($filters['address1']) {
                $query->where('address1', '=', $filters['address1']);
            }
            if ($filters['sectors']) {
                $query->where('sectors', '=', $filters['sectors']);
            }
        })->where(function ($query) use ($filters) {
            if ($filters['free_word']) {
                $query->where('user_id', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('company_name', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('department_name', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('job_title', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('name', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('email', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('phone', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('address2', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('address3', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('address4', 'like', '%'.$filters['free_word'].'%');
            }
        })->paginate(5);
        $all_user_count = User::count();
        $searched_user_count = $users->count();
        $mails = Message::where('id', $id)->get();
        $mail_count = Message::max('id') + 1;
        return view('pages.admin.mail_resend', compact('users', 'mail_count', 'all_user_count', 'searched_user_count', 'mails'));
    }

    public function userMailCreateSearch(Request $request)
    {
        $filters = [
            'address1' => $request->prefecture,
            'sectors' => $request->industry,
            'free_word' => $request->free_word
        ];
        $users = User::where(function ($query) use ($filters) {
            if ($filters['address1']) {
                $query->where('address1', '=', $filters['address1']);
            }
            if ($filters['sectors']) {
                $query->where('sectors', '=', $filters['sectors']);
            }
        })->where(function ($query) use ($filters) {
            if ($filters['free_word']) {
                $query->where('user_id', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('company_name', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('department_name', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('job_title', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('name', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('email', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('phone', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('address2', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('address3', 'like', '%'.$filters['free_word'].'%')
                ->orwhere('address4', 'like', '%'.$filters['free_word'].'%');
            }
        })->paginate(5);
        $all_user_count = User::count();
        $searched_user_count = $users->count();
        $mail_count = Message::max('id') + 1;
        return view('pages.admin.mail_create', compact('users', 'mail_count', 'all_user_count', 'searched_user_count'));
    }

    public function sendMail(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|email',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $reserve_dt = date("Y-m-d H:i", strtotime(Carbon::create($request->year, $request->month, $request->day, $request->hour, $request->minute)));

        $now = date("Y-m-d H:i", strtotime(Carbon::now()));

        $from = new SendGrid\Mail\From($validated['from']);
        if(!is_null($request->user_mail)) {
            $to = [];
            foreach ($request->user_mail as $user) {
                array_push($to, new SendGrid\Mail\To(json_decode($user)->email, json_decode($user)->name));
            }
        }
        else {
            $to =[];
        }
        $message = new Message();
        $message->title = $request->title;
        $message->body = $request->body;
        $message->to_email = json_encode($to);
        $message->save();

        switch ($request->input('action')) {
            case 'submit':

                if(is_null($request->user_mail)) {
                    toastr()->warning('配信先を選択してください。','',config('toastr.options'));
                    return back();
                }
                $subject = new SendGrid\Mail\Subject($validated['title']);
                $htmlContent = new SendGrid\Mail\HtmlContent($validated['body']);

                $email = new SendGrid\Mail\Mail(
                    $from,
                    $to,
                    $subject,
                    null,
                    $htmlContent
                );

                if($reserve_dt <= $now) {
                    $message->delivered = '送';
                    $message->send_date = Carbon::now();
                    $message->save();   
                    dispatch(new MailSend($email));
                    toastr()->success('メールが正常に送信されました。','',config('toastr.options'));
                    return redirect()->route('mailCreate')->with(['success' => "メールが正常に送信されました。"]);
        
                }else { 
                    $message->reserve_date = $reserve_dt;
                    $message->delivered = '予';
                    $message->save();   
                    toastr()->success('メールが予約されました。','',config('toastr.options'));
                    $mails = Message::paginate($perPage = 5);
                    return view('pages.admin.mail_send', compact('mails'));
                }    
            case 'save':
                $message->delivered = '保';
                $message->save();  
                $mails = Message::paginate($perPage = 5);
                toastr()->success('メールが保存されました。','',config('toastr.options'));
                return view('pages.admin.mail_send', compact('mails'));
        }

    }

    public function contactMail(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'surname' => 'required|string',
            'address1' => 'required|string',
            'address2' => 'required|string',
            'comment' => 'required|string'
        ];

        $messages = [
            'surname.required' => '姓を入力する必要があります。',
            'email.email' => 'メールは有効な形式である必要があります。',
            'email.required' => 'メールを入力する必要があります。',
            'address2.required' => '市町村を入力する必要があります。',
            'address1.required' => '県を選択する必要があります。',
            'comment.required' => 'お問い合わせ内容を入力する必要があります。'
        ];
        $this->validate($request, $rules, $messages);

        $from = new SendGrid\Mail\From($request->email);
        $to = new SendGrid\Mail\To($request->to);
        $subject = new SendGrid\Mail\Subject($request->subject);

        $data = "お名前 : ".$request['surname'].$request['name']."<br><br>法人名 :".$request['company_name']."<br><br>担当部署名: ".$request['department_name']."<br><br>ご住所: ".$request['address1'].$request['address2'].$request['address3'].$request['address4']."<br><br>電話番号: ".$request['phone']."<br><br>お問い合わせ内容:<br> ".$request['comment'];

        $htmlContent = $htmlContent = new SendGrid\Mail\HtmlContent($data);

        $email = new SendGrid\Mail\Mail(
            $from,
            $to,
            $subject,
            null,
            $htmlContent
        );

        $sendgrid = new SendGrid(getenv('MAIL_PASSWORD'));
        $response = $sendgrid->send($email);
        toastr()->success('お問い合わせフォームを正常に送信しました。','',config('toastr.options'));
        return redirect()->back()->with(['success' => 'Contact Form Submit Successfully']);

    }
}