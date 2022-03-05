<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;
use App\Models\Admin;

class AdminManageController extends Controller
{
    public function show()
    {
        $admins = Admin::paginate($perPage = 5);
        return view('pages.admin.admin_manage', compact('admins'));
    }

    public function create()
    {
        $users = User::paginate($perPage = 5);
        return view('pages.admin.user_manage', compact('users'));
    }

    public function getInfo($id)
    {
        $data = Admin::where('admin_id', $id)->get();
        return view('auth.admin.update', compact('data'));
    }

    public function updateInfo(Request $request, $admin_id)
    {
        $this->validate($request, [
            'admin_id'=> 'required'
        ]);

        Admin::where('admin_id', $request->input('admin_id'))->update(array('department_name' => $request->input('department_name')));
        Admin::where('admin_id', $request->input('admin_id'))->update(array('job_title' => $request->input('job_title')));
        Admin::where('admin_id', $request->input('admin_id'))->update(array('name' => $request->input('name')));
        Admin::where('admin_id', $request->input('admin_id'))->update(array('furi_name' => $request->input('furi_name')));
        Admin::where('admin_id', $request->input('admin_id'))->update(array('email' => $request->input('email')));
        Admin::where('admin_id', $request->input('admin_id'))->update(array('phone' => $request->input('phone')));
        Admin::where('admin_id', $request->input('admin_id'))->update(array('break' => $request->input('break')));
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