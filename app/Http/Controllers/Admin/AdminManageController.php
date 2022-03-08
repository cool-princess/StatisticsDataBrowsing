<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;
use App\Models\Admin;

class AdminManageController extends Controller
{    
    public function show()
    {
        if(Auth::guard('admin')->check())
        {
            $admins = Admin::paginate($perPage = 5);
            return view('pages.admin.admin_manage', compact('admins'));
        }
        else
            return redirect('/admin/login');
    }

    public function getInfo($id)
    {
        if(Auth::guard('admin')->check())
        {
            $data = Admin::where('admin_id', $id)->get();
            return view('auth.admin.update', compact('data'));
        }
        else
            return redirect('/admin/login');
    }

    public function updateInfo(Request $request, $admin_id)
    {
        $rules = [
            'admin_id'=> 'required',
            'name'=> 'required',
            'email' => 'required|email',
            'email_confirm' => 'required|same:email|email',
            'password'=> 'required|max:8,min:8'
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

        Admin::where('admin_id', $request->input('admin_id'))->update(array('password' => bcrypt($request->input('password'))));
        Admin::where('admin_id', $request->input('admin_id'))->update(array('department_name' => $request->input('department_name')));
        Admin::where('admin_id', $request->input('admin_id'))->update(array('job_title' => $request->input('job_title')));
        Admin::where('admin_id', $request->input('admin_id'))->update(array('name' => $request->input('name')));
        Admin::where('admin_id', $request->input('admin_id'))->update(array('furi_name' => $request->input('furi_name')));
        Admin::where('admin_id', $request->input('admin_id'))->update(array('email' => $request->input('email')));
        Admin::where('admin_id', $request->input('admin_id'))->update(array('phone' => $request->input('phone')));
        Admin::where('admin_id', $request->input('admin_id'))->update(array('break' => $request->input('break')));
        Admin::where('admin_id', $request->input('admin_id'))->update(array('pwd_store' => $request->input('password')));
        $admins = Admin::paginate($perPage = 5);
        toastr()->success('管理者情報が更新されました。','',config('toastr.options'));
        return view('pages.admin.admin_manage', compact('admins'));
    }

    public function delete($admin_id)
    {
        Admin::where('admin_id', $admin_id)->delete();
        $admins = Admin::paginate($perPage = 5);
        toastr()->success('管理者情報が削除されました。','',config('toastr.options'));
        return view('pages.admin.admin_manage', compact('admins'));
    }
}