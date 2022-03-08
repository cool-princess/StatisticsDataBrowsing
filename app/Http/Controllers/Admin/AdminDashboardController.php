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
use App\Models\News;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if(Auth::guard('admin')->check())
        {
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

        $news = News::create([
            'title' => $request->news,
            'created_at' => $dt,
            'updated_at' => $dt
        ]);
        
        $newsInfo = News::all();
        toastr()->success('お知らせが保存されました。','',config('toastr.options'));
        return view('pages.admin.home', compact('newsInfo'));
    }

    public function update(Request $request, $no)
    {
        $dt = Carbon::create($request->year, $request->month, $request->day, $request->hour, $request->minute);
        News::where('id', $no)->update(array('title' => $request->input('updated_news')));
        News::where('id', $no)->update(array('updated_at' => $dt));
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