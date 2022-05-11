<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\MessageBag;
use App\Models\File;
use App\Models\User;
use App\Models\Admin;

class UserRegistrationController extends Controller
{
    
    public function index()
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

            $data = User::max('id') + 1;
            return view('auth.user.register', ['user_no' => $data]);
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

            $users = User::orderBy('created_at', 'desc')->paginate($perPage = 5);
            return view('pages.admin.user_manage', compact('users'));
        }
        else
            return redirect('/admin/login');
    }

    public function store(Request $request)
    {
        $rules = [
            'user_id' => ['required'],
            'name' => ['required'],
            'email' => 'required|email',
            'email_confirm' => 'required|same:email|email',
            'password'=> ['required', 'max:8', 'min:8']
        ];

        $messages = [
            'name.required' => 'お名前を入力する必要があります。',
            'email.email' => 'メールは有効な形式である必要があります。',
            'email_confirm.email' => 'メールは有効な形式である必要があります。',
            'email_confirm.same:email' => '確認メールが正しくありません。',
            'password.max:8' => 'パスワードは8文字以上である必要があります。'
        ];
        
        $this->validate($request, $rules, $messages);

        $user_id = DB::table('users')->select('user_id')->get();
        $custom_id = $request->user_id;
        loop:
        foreach ($user_id as $value) {
            if($value->user_id == $custom_id) {
                $custom_id = "GD9".str_pad(rand(0, pow(10, 4)-1), 4, '0', STR_PAD_LEFT);
                goto loop;
            }
        }

        $user = User::create([
            'user_id' => $custom_id,
            'password' => bcrypt($request->password),
            'company_name' => $request->company_name,
            'furi_company_name' => $request->furi_company_name,
            'department_name' => $request->department_name,
            'job_title' => $request->job_title,
            'name' => $request->name,
            'furi_name' => $request->furi_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'zipcode' => $request->zipcode,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'address3' => $request->address3,
            'address4' => $request->address4,
            'sectors' => $request->sectors,
            'break' => $request->break,
            'pwd_store' => $request->password
        ]);
        
        toastr()->success('会員情報が保存されました。','',config('toastr.options'));
        return redirect('/admin/user_manage');
    }

    public function getInfo($id)
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
            
            $data = User::where('user_id', $id)->get();
            return view('auth.user.update', compact('data'));
        }
        else
            return redirect('/admin/login');
    }

    public function userSearch(Request $request)
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
        return view('pages.admin.user_manage', compact('users'));
    }

    public function updateInfo(Request $request, $user_id)
    {
        $rules = [
            'user_id' => ['required'],
            'name' => ['required'],
            'email' => 'required|email',
            'email_confirm' => 'required|same:email|email',
            'password'=> ['required', 'max:8', 'min:8']
        ];

        $messages = [
            'name.required' => 'お名前を入力する必要があります。',
            'email.email' => 'メールは有効な形式である必要があります。',
            'email_confirm.email' => 'メールは有効な形式である必要があります。',
            'email_confirm.same:email' => '確認メールが正しくありません。',
            'password.max:8' => 'パスワードは8文字以上である必要があります。'
        ];
        
        $this->validate($request, $rules, $messages);

        User::where('user_id', $request->input('user_id'))->update(array('password' => bcrypt($request->input('password'))));
        User::where('user_id', $request->input('user_id'))->update(array('company_name' => $request->input('company_name')));
        User::where('user_id', $request->input('user_id'))->update(array('furi_company_name' => $request->input('furi_company_name')));
        User::where('user_id', $request->input('user_id'))->update(array('department_name' => $request->input('department_name')));
        User::where('user_id', $request->input('user_id'))->update(array('job_title' => $request->input('job_title')));
        User::where('user_id', $request->input('user_id'))->update(array('name' => $request->input('name')));
        User::where('user_id', $request->input('user_id'))->update(array('furi_name' => $request->input('furi_name')));
        User::where('user_id', $request->input('user_id'))->update(array('email' => $request->input('email')));
        User::where('user_id', $request->input('user_id'))->update(array('phone' => $request->input('phone')));
        User::where('user_id', $request->input('user_id'))->update(array('zipcode' => $request->input('zipcode')));
        User::where('user_id', $request->input('user_id'))->update(array('address1' => $request->input('address1')));
        User::where('user_id', $request->input('user_id'))->update(array('address2' => $request->input('address2')));
        User::where('user_id', $request->input('user_id'))->update(array('address3' => $request->input('address3')));
        User::where('user_id', $request->input('user_id'))->update(array('address4' => $request->input('address4')));
        User::where('user_id', $request->input('user_id'))->update(array('sectors' => $request->input('sectors')));
        User::where('user_id', $request->input('user_id'))->update(array('break' => $request->input('break')));
        User::where('user_id', $request->input('user_id'))->update(array('pwd_store' => $request->input('password')));
        $users = User::orderBy('created_at', 'desc')->paginate($perPage = 5);
        toastr()->success('会員情報が更新されました。','',config('toastr.options'));
        return view('pages.admin.user_manage', compact('users'));
    }

    public function delete($user_id)
    {
        User::where('user_id', $user_id)->delete();
        $users = User::orderBy('created_at', 'desc')->paginate($perPage = 5);
        toastr()->success('会員情報が削除されました。','',config('toastr.options'));
        return view('pages.admin.user_manage', compact('users'));
    }
}