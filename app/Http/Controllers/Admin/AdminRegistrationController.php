<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\MessageBag;
use App\Models\Admin;

class AdminRegistrationController extends Controller
{
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
            
            $data = Admin::max('id') + 1;
            return view('auth.admin.register', ['admin_no' => $data]);
        }
        else
            return redirect('/admin/login');
    }

    public function store(Request $request)
    {
        $rules = [
            'admin_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'email_confirm' => 'required|same:email|email',
            'password'=> 'required|min:8, max:8'
        ];
        
        $messages = [
            'admin_id.required' => 'The email is required.',
            'name.required' => 'お名前を入力する必要があります。',
            'email.email' => 'メールは有効な形式である必要があります。',
            'email_confirm.email' => 'メールは有効な形式である必要があります。',
            'email_confirm.same:email' => '確認メールが正しくありません。',
            'password.max:8' => 'パスワードは8文字以上である必要があります。'
        ];
        
        $this->validate($request, $rules, $messages);

        $admin_id = DB::table('admin')->select('admin_id')->get();
        $custom_id = $request->admin_id;
        loop:
        foreach ($admin_id as $value) {
            if($value->admin_id == $custom_id) {
                $custom_id = "GD9".str_pad(rand(0, pow(10, 4)-1), 4, '0', STR_PAD_LEFT);
                goto loop;
            }
        }

        $user = Admin::create([
            'admin_id' => $custom_id,
            'password' => bcrypt($request->password),
            'department_name' => $request->department_name,
            'job_title' => $request->job_title,
            'name' => $request->name,
            'furi_name' => $request->furi_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'break' => $request->break,
            'pwd_store' => $request->password
        ]);
        
        toastr()->success('管理者情報が保存されました。','',config('toastr.options'));
        return redirect('/admin/manage');
    }
}