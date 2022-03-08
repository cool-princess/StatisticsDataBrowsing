<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\MessageBag;
use App\Models\Statistics;
use App\Models\User;
use App\Models\Admin;
use App\Models\News;
use App\Models\Ticket;
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
            $tickets = Ticket::all();
            $age = array_fill(0, 8, 0);
            $age_rate = array_fill(0, 8, 0);
            $sex_rate = 0;
            $man_count = 0;
            $adult_ticket_rate = array_fill(0, 7, 0);
            $adult_ticket_count = array_fill(0, 7, 0);
            $young_ticket_rate = array_fill(0, 7, 0);
            $young_ticket_count = array_fill(0, 7, 0);
            $i = 0;
            foreach ($tickets as $key => $value) {
                $i++;
                $year = Carbon::createFromFormat('Y-m-d', $value->birthday)->format('Y');
                $ages = Carbon::now()->format('Y') - $year;
                $sex = $value->sex;
                $adult_ticket = $value->adult_ticket;
                $young_ticket = $value->young_ticket;
                if($ages < 20)
                    $age[0]++;
                elseif((30 > $ages) && (20 <= $ages))
                    $age[1]++;
                elseif((40 > $ages) && (30 <= $ages))
                    $age[2]++;
                elseif((50 > $ages) && (40 <= $ages))
                    $age[3]++;
                elseif((60 > $ages) && (50 <= $ages))
                    $age[4]++;
                elseif((70 > $ages) && (60 <= $ages))
                    $age[5]++;
                elseif((80 > $ages) && (70 <= $ages))
                    $age[6]++;
                elseif((90 > $ages) && (80 <= $ages))
                    $age[7]++;
                if($sex == "男性")
                    $man_count++;
                if($adult_ticket == 0)
                    $adult_ticket_count[0]++;
                elseif($adult_ticket == 1)
                    $adult_ticket_count[1]++;
                elseif($adult_ticket == 2)
                    $adult_ticket_count[2]++;
                elseif($adult_ticket == 3)
                    $adult_ticket_count[3]++;
                elseif($adult_ticket == 4)
                    $adult_ticket_count[4]++;
                elseif($adult_ticket == 5)
                    $adult_ticket_count[5]++;
                elseif($adult_ticket == 6)
                    $adult_ticket_count[6]++;
                if($young_ticket == 0)
                    $young_ticket_count[0]++;
                elseif($young_ticket == 1)
                    $young_ticket_count[1]++;
                elseif($young_ticket == 2)
                    $young_ticket_count[2]++;
                elseif($young_ticket == 3)
                    $young_ticket_count[3]++;
                elseif($young_ticket == 4)
                    $young_ticket_count[4]++;
                elseif($young_ticket == 5)
                    $young_ticket_count[5]++;
                elseif($young_ticket == 6)
                    $young_ticket_count[6]++;
            }
            for($j = 0; $j < 8; $j++) {
                $age_rate[$j] = ($age[$j] / $i) * 100;
            }
            for($j = 0; $j < 7; $j++) {
                $adult_ticket_rate[$j] = ($adult_ticket_count[$j] / $i) * 100;
            }
            for($j = 0; $j < 7; $j++) {
                $young_ticket_rate[$j] = ($young_ticket_count[$j] / $i) * 100;
            }
            $sex_rate = ($man_count / $i) * 100;
            $tabValue = 0;
            return view('pages.user.home', compact('files', 'news', 'tabValue', 'age_rate', 'sex_rate', 'adult_ticket_rate', 'young_ticket_rate'));
        }else{
            $errors = new MessageBag(['user_id' => ['ログイン情報が正しくありません。']]);
            return back()->withErrors($errors)->withInput($request->only('user_id', 'remember'));
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
