<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\MessageBag;
use App\Models\News;
use App\Models\Admin;

class AdminDashboardController extends Controller
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

            $newsInfo = News::all();
            return view('pages.admin.home', compact('newsInfo'));
        }
        else
            return redirect('/admin/login');
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
            'hour' => 'required',
            'minute' => 'required',
            'news' => 'required'
        ]);

        $dt = Carbon::create($request->year, $request->month, $request->day, $request->hour, $request->minute);
        $titleCheck = News::where('title', $request->news)->get();
        if(!$titleCheck->count()) {
            $news = News::create([
                'title' => $request->news,
                'created_at' => $dt,
                'updated_at' => $dt
            ]);
        }
      
        $newsInfo = News::all();
        toastr()->success('お知らせが保存されました。','',config('toastr.options'));
        return view('pages.admin.home', compact('newsInfo'));
    }

    public function update(Request $request, $no)
    {
        $dt = Carbon::create($request->year, $request->month, $request->day, $request->hour, $request->minute);
        News::where('id', $no)->update(array('title' => $request->input('updated_news')));
        News::where('id', $no)->update(array('created_at' => $dt));
        $newsInfo = News::all();
        toastr()->success('お知らせが更新されました。','',config('toastr.options'));
        return view('pages.admin.home', compact('newsInfo'));
    }

    public function delete($no)
    {
        News::where('id', $no)->delete();
        $newsInfo = News::all();
        toastr()->success('お知らせが削除されました。','',config('toastr.options'));
        return view('pages.admin.home', compact('newsInfo'));
    }
}