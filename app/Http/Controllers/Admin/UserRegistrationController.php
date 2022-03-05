<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;
use App\Models\File;
use App\Models\User;

class UserRegistrationController extends Controller
{
    
    public function index()
    {
        $data = User::max('id') + 1;
        return view('auth.user.register', ['user_no' => $data]);
    }

    public function show()
    {
        $users = User::paginate($perPage = 5);
        return view('pages.admin.user_manage', compact('users'));
    }

    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'name' => 'required',
            'email' => 'confirmed',
            'email_confirm' => 'confirmed',
            'password'=> 'required|min:8'
        ];
        $this->validate($request, $rules);
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
            'password' => $request->password,
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
        $data = User::where('user_id', $id)->get();
        return view('auth.user.update', compact('data'));
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
        $this->validate($request, [
            'user_id'=> 'required'
        ]);

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
        $users = User::paginate($perPage = 5);
        toastr()->success('会員情報が更新されました。','',config('toastr.options'));
        return view('pages.admin.user_manage', compact('users'));
    }

    public function delete($user_id)
    {
        User::where('user_id', $user_id)->delete();
        $users = User::paginate($perPage = 5);
        toastr()->success('会員情報が削除されました。','',config('toastr.options'));
        return view('pages.admin.user_manage', compact('users'));
    }
}