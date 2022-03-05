<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use App\Models\Statistics;
use App\Models\User;
use App\Models\Admin;
use App\Models\News;
use PDF;

class LogInController extends Controller
{
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    public function showAdminLoginForm()
    {
        return view('auth.admin.login');
    }

    public function showUserLoginForm()
    {
        return view('auth.user.login');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'admin_id'=>'required',
            'password'=>'required'
        ]);

        if (Auth::guard('admin')->attempt(['admin_id' => $request->admin_id, 'password' => $request->password], $request->get('remember'))) {
            $newsInfo = News::all();
            return view('pages.admin.home', compact('newsInfo'));
        }else{
            $errors = new MessageBag(['admin_id' => ['ログイン情報が正しくありません。']]);
            return back()->withErrors($errors)->withInput($request->only('admin_id', 'remember'));
        }
    }

    public function userLogin(Request $request)
    {
        $this->validate($request, [
            'user_id'   => 'required',
            'password' => 'required'
        ]);
 
        if (Auth::guard('user')->attempt(['user_id' => $request->user_id, 'password' => $request->password], $request->get('remember'))) {
            $files = Statistics::paginate($perPage = 10);
            $news = News::all();
            $tabValue = 0;
            return view('pages.user.home', compact('files', 'news', 'tabValue'));
        }else{
            $errors = new MessageBag(['user_id' => ['ログイン情報が正しくありません。']]);
            return back()->withInput($request->only('user_id', 'remember'));
        }
    }

    public function userHome()
    { 
        $files = Statistics::paginate($perPage = 10);
        $news = News::all();
        $tabValue = 1;
        return view('pages.user.home', compact('files', 'news', 'tabValue'));
    }
}
