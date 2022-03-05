<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;
use App\Models\Admin;

class AdminRegistrationController extends Controller
{
    public function show()
    {
        $data = Admin::max('id') + 1;
        return view('auth.admin.register', ['admin_no' => $data]);
    }

    public function store(Request $request)
    {
        $rules = [
            'admin_id' => 'required',
            'name' => 'required',
            'email_confirm' => 'confirmed',
            'password'=> 'required|min:8'
        ];
        
        $messages = [
            'admin_id.required' => 'The email is required.',
            'name.required' => 'お名前を入力する必要があります。',
            'email.email' => 'メールは有効な形式である必要があります。',
            'email_confirm.email' => 'メールは有効な形式である必要があります。',
            'email_confirm.confirmed' => '確認メールが正しくありません。',
            'password.min' => 'パスワードは8文字以上である必要があります。',
            'password.required' => 'パスワードを入力する必要があります。',
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
            'password' => $request->password,
            'department_name' => $request->department_name,
            'job_title' => $request->job_title,
            'name' => $request->name,
            'furi_name' => $request->furi_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'break' => $request->break
        ]);

        // event(new Registered($user));

        // auth()->login($user);
        toastr()->success('管理者情報が保存されました。','',config('toastr.options'));
        return redirect('/admin/manage');
    }
}