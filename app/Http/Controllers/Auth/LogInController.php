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
            $admin_break = Admin::select('break')->where('admin_id', '=', $request->admin_id)->get();
            if($admin_break[0]->break == 0) {
                Auth::guard('admin')->logout();
                $errors = new MessageBag(['admin_id' => ['許可が一時停止されました。']]);
                return view('auth.admin.login')->withErrors($errors)->withInput($request->only('admin_id', 'remember'));
            }
            $newsInfo = News::orderBy('created_at', 'desc')->get();
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
            $user_break = User::select('break')->where('user_id', '=', $request->user_id)->get();
            if($user_break[0]->break == 0) {
                Auth::guard('user')->logout();
                $errors = new MessageBag(['user_id' => ['許可が一時停止されました。']]);
                return view('auth.user.login')->withErrors($errors)->withInput($request->only('user_id', 'remember'));
            }
            $search_data['area'] = '';
            $search_data['from_date'] = '';
            $search_data['end_date'] = '';
            $files = Statistics::orderBy('created_at', 'desc')->paginate($perPage = 20);
            $news = News::orderBy('created_at', 'desc')->get();
            $tabValue = 0;
            $tickets = Ticket::all();
            $age = array_fill(0, 8, 0);
            $age_rate = array_fill(0, 8, 0);
            $sex_rate = 0;
            $man_count = 0;
            $all_ticket_rate = array_fill(0, 7, 0);
            $all_ticket_count = array_fill(0, 7, 0);
            $adult_young_count = 0;
            $adult_young_rate = 0;
            $location_rate = array_fill(0, 47, 0);
            $location_count = array_fill(0, 47, 0);
            $i = $tickets->count();
            if($i) {
                foreach ($tickets as $key => $value) {
                    $year = Carbon::createFromFormat('Y-m-d', $value->birthday)->format('Y');
                    $ages = Carbon::now()->format('Y') - $year;
                    $sex = $value->sex;
                    $adult_ticket = $value->adult_ticket;
                    $young_ticket = $value->young_ticket;
                    $all_ticket = $adult_ticket + $young_ticket;
                    $location_name = $value->location;
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
                    elseif(80 <= $ages)
                        $age[7]++;
                    if($sex == "男性")
                        $man_count++;
                    if($all_ticket == 0)
                        $all_ticket_count[0]++;
                    elseif($all_ticket == 1)
                        $all_ticket_count[1]++;
                    elseif($all_ticket == 2)
                        $all_ticket_count[2]++;
                    elseif($all_ticket == 3)
                        $all_ticket_count[3]++;
                    elseif($all_ticket == 4)
                        $all_ticket_count[4]++;
                    elseif($all_ticket == 5)
                        $all_ticket_count[5]++;
                    elseif($all_ticket == 6)
                        $all_ticket_count[6]++;
                    if(($adult_ticket <> 0) && ($young_ticket <> 0))
                        $adult_young_count++;
                    if($location_name == '北海道')
                        $location_count[0]++;
                    elseif($location_name == '青森県')
                        $location_count[1]++;
                    elseif($location_name == '岩手県')
                        $location_count[2]++;
                    elseif($location_name == '宮城県')
                        $location_count[3]++;
                    elseif($location_name == '秋田県')
                        $location_count[4]++;
                    elseif($location_name == '山形県')
                        $location_count[5]++;
                    elseif($location_name == '福島県')
                        $location_count[6]++;
                    elseif($location_name == '茨城県')
                        $location_count[7]++;
                    elseif($location_name == '栃木県')
                        $location_count[8]++;
                    elseif($location_name == '群馬県')
                        $location_count[9]++;
                    elseif($location_name == '埼玉県')
                        $location_count[10]++;
                    elseif($location_name == '千葉県')
                        $location_count[11]++;
                    elseif($location_name == '東京都')
                        $location_count[12]++;
                    elseif($location_name == '神奈川県')
                        $location_count[13]++;
                    elseif($location_name == '新潟県')
                        $location_count[14]++;
                    elseif($location_name == '富山県')
                        $location_count[15]++;
                    elseif($location_name == '石川県')
                        $location_count[16]++;
                    elseif($location_name == '福井県')
                        $location_count[17]++;
                    elseif($location_name == '山梨県')
                        $location_count[18]++;
                    elseif($location_name == '長野県')
                        $location_count[18]++;
                    elseif($location_name == '岐阜県')
                        $location_count[20]++;
                    elseif($location_name == '静岡県')
                        $location_count[21]++;
                    elseif($location_name == '愛知県')
                        $location_count[22]++;
                    elseif($location_name == '三重県')
                        $location_count[23]++;
                    elseif($location_name == '滋賀県')
                        $location_count[24]++;
                    elseif($location_name == '京都府')
                        $location_count[25]++;
                    elseif($location_name == '大阪府')
                        $location_count[26]++;
                    elseif($location_name == '兵庫県')
                        $location_count[27]++;
                    elseif($location_name == '奈良県')
                        $location_count[28]++;
                    elseif($location_name == '和歌山県')
                        $location_count[29]++;
                    elseif($location_name == '鳥取県')
                        $location_count[30]++;
                    elseif($location_name == '島根県')
                        $location_count[31]++;
                    elseif($location_name == '岡山県')
                        $location_count[32]++;
                    elseif($location_name == '広島県')
                        $location_count[33]++;
                    elseif($location_name == '山口県')
                        $location_count[34]++;
                    elseif($location_name == '徳島県')
                        $location_count[35]++;
                    elseif($location_name == '香川県')
                        $location_count[36]++;
                    elseif($location_name == '愛媛県')
                        $location_count[37]++;
                    elseif($location_name == '高知県')
                        $location_count[38]++;
                    elseif($location_name == '福岡県')
                        $location_count[39]++;
                    elseif($location_name == '佐賀県')
                        $location_count[40]++;
                    elseif($location_name == '長崎県')
                        $location_count[41]++;
                    elseif($location_name == '熊本県')
                        $location_count[42]++;
                    elseif($location_name == '大分県')
                        $location_count[43]++;
                    elseif($location_name == '宮崎県')
                        $location_count[44]++;
                    elseif($location_name == '鹿児島県')
                        $location_count[45]++;
                    elseif($location_name == '沖縄県')
                        $location_count[46]++;
                }
                for($j = 0; $j < 8; $j++) {
                    $age_rate[$j] = round(($age[$j] / $i) * 100, 1);
                }
                for($j = 0; $j < 7; $j++) {
                    $all_ticket_rate[$j] = round(($all_ticket_count[$j] / $i) * 100, 1);
                }
                for($j = 0; $j < 47; $j++) {
                    $location_rate[$j] = round(($location_count[$j] / $i) * 100, 1);
                }
                $sex_rate = round(($man_count / $i) * 100, 1);
                $adult_young_rate = round(($adult_young_count / $i) * 100, 1);
            }
            return view('pages.user.home', compact('files', 'news', 'tabValue', 'age_rate', 'sex_rate', 'all_ticket_rate', 'adult_young_rate', 'location_rate', 'search_data'));
        }else{
            $errors = new MessageBag(['user_id' => ['ログイン情報が正しくありません。']]);
            return back()->withErrors($errors)->withInput($request->only('user_id', 'remember'));
        }
    }

    public function userHome()
    { 
        if(Auth::guard('user')->check())
        {
            $user_id = Auth::guard('user')->user()->user_id;
            $user_break = User::select('break')->where('user_id', '=', $user_id)->get();
            if($user_break[0]->break == 0) {
                Auth::guard('user')->logout();
                $errors = new MessageBag(['user_id' => ['許可が一時停止されました。']]);
                return view('auth.user.login')->withErrors($errors);
            }
            $files = Statistics::orderBy('created_at', 'desc')->paginate($perPage = 20);
            $news = News::orderBy('created_at', 'desc')->get();
            $tabValue = 1;
            $tickets = Ticket::all();
            $age = array_fill(0, 8, 0);
            $age_rate = array_fill(0, 8, 0);
            $sex_rate = 0;
            $man_count = 0;
            $all_ticket_rate = array_fill(0, 7, 0);
            $all_ticket_count = array_fill(0, 7, 0);
            $adult_young_count = 0;
            $adult_young_rate = 0;
            $location_rate = array_fill(0, 47, 0);
            $location_count = array_fill(0, 47, 0);
            $search_data = array_fill(0, 3, 0);
            $search_data[0] = 0;
            $search_data[1] = 1;
            $search_data[2] = 2;
            $i = $tickets->count();
            if($i) {
                foreach ($tickets as $key => $value) {
                    $year = Carbon::createFromFormat('Y-m-d', $value->birthday)->format('Y');
                    $ages = Carbon::now()->format('Y') - $year;
                    $sex = $value->sex;
                    $adult_ticket = $value->adult_ticket;
                    $young_ticket = $value->young_ticket;
                    $all_ticket = $adult_ticket + $young_ticket;
                    $location_name = $value->location;
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
                    elseif(80 <= $ages)
                        $age[7]++;
                    if($sex == "男性")
                        $man_count++;
                    if($all_ticket == 0)
                        $all_ticket_count[0]++;
                    elseif($all_ticket == 1)
                        $all_ticket_count[1]++;
                    elseif($all_ticket == 2)
                        $all_ticket_count[2]++;
                    elseif($all_ticket == 3)
                        $all_ticket_count[3]++;
                    elseif($all_ticket == 4)
                        $all_ticket_count[4]++;
                    elseif($all_ticket == 5)
                        $all_ticket_count[5]++;
                    elseif($all_ticket == 6)
                        $all_ticket_count[6]++;
                    if(($adult_ticket <> 0) && ($young_ticket <> 0))
                        $adult_young_count++;
                    if($location_name == '北海道')
                        $location_count[0]++;
                    elseif($location_name == '青森県')
                        $location_count[1]++;
                    elseif($location_name == '岩手県')
                        $location_count[2]++;
                    elseif($location_name == '宮城県')
                        $location_count[3]++;
                    elseif($location_name == '秋田県')
                        $location_count[4]++;
                    elseif($location_name == '山形県')
                        $location_count[5]++;
                    elseif($location_name == '福島県')
                        $location_count[6]++;
                    elseif($location_name == '茨城県')
                        $location_count[7]++;
                    elseif($location_name == '栃木県')
                        $location_count[8]++;
                    elseif($location_name == '群馬県')
                        $location_count[9]++;
                    elseif($location_name == '埼玉県')
                        $location_count[10]++;
                    elseif($location_name == '千葉県')
                        $location_count[11]++;
                    elseif($location_name == '東京都')
                        $location_count[12]++;
                    elseif($location_name == '神奈川県')
                        $location_count[13]++;
                    elseif($location_name == '新潟県')
                        $location_count[14]++;
                    elseif($location_name == '富山県')
                        $location_count[15]++;
                    elseif($location_name == '石川県')
                        $location_count[16]++;
                    elseif($location_name == '福井県')
                        $location_count[17]++;
                    elseif($location_name == '山梨県')
                        $location_count[18]++;
                    elseif($location_name == '長野県')
                        $location_count[18]++;
                    elseif($location_name == '岐阜県')
                        $location_count[20]++;
                    elseif($location_name == '静岡県')
                        $location_count[21]++;
                    elseif($location_name == '愛知県')
                        $location_count[22]++;
                    elseif($location_name == '三重県')
                        $location_count[23]++;
                    elseif($location_name == '滋賀県')
                        $location_count[24]++;
                    elseif($location_name == '京都府')
                        $location_count[25]++;
                    elseif($location_name == '大阪府')
                        $location_count[26]++;
                    elseif($location_name == '兵庫県')
                        $location_count[27]++;
                    elseif($location_name == '奈良県')
                        $location_count[28]++;
                    elseif($location_name == '和歌山県')
                        $location_count[29]++;
                    elseif($location_name == '鳥取県')
                        $location_count[30]++;
                    elseif($location_name == '島根県')
                        $location_count[31]++;
                    elseif($location_name == '岡山県')
                        $location_count[32]++;
                    elseif($location_name == '広島県')
                        $location_count[33]++;
                    elseif($location_name == '山口県')
                        $location_count[34]++;
                    elseif($location_name == '徳島県')
                        $location_count[35]++;
                    elseif($location_name == '香川県')
                        $location_count[36]++;
                    elseif($location_name == '愛媛県')
                        $location_count[37]++;
                    elseif($location_name == '高知県')
                        $location_count[38]++;
                    elseif($location_name == '福岡県')
                        $location_count[39]++;
                    elseif($location_name == '佐賀県')
                        $location_count[40]++;
                    elseif($location_name == '長崎県')
                        $location_count[41]++;
                    elseif($location_name == '熊本県')
                        $location_count[42]++;
                    elseif($location_name == '大分県')
                        $location_count[43]++;
                    elseif($location_name == '宮崎県')
                        $location_count[44]++;
                    elseif($location_name == '鹿児島県')
                        $location_count[45]++;
                    elseif($location_name == '沖縄県')
                        $location_count[46]++;
                }
                for($j = 0; $j < 8; $j++) {
                    $age_rate[$j] = round(($age[$j] / $i) * 100, 1);
                }
                for($j = 0; $j < 7; $j++) {
                    $all_ticket_rate[$j] = round(($all_ticket_count[$j] / $i) * 100, 1);
                }
                for($j = 0; $j < 47; $j++) {
                    $location_rate[$j] = round(($location_count[$j] / $i) * 100, 1);
                }
                $sex_rate = round(($man_count / $i) * 100, 1);
                $adult_young_rate = round(($adult_young_count / $i) * 100, 1);
            }
            return view('pages.user.home', compact('files', 'news', 'tabValue', 'age_rate', 'sex_rate', 'all_ticket_rate', 'adult_young_rate', 'location_rate', 'search_data'));
        }
        else
            return redirect('/user/login');
    }

    public function dataSearch(Request $request)
    {
        if($request->start_year && $request->end_year)
        {
            $start_date = Carbon::create($request->start_year, $request->start_month, "1");
            $end_date = Carbon::create($request->end_year, $request->end_month, "31");
        }
        elseif($request->start_year && !$request->end_year)
        {
            $start_date = Carbon::create($request->start_year, $request->start_month, "1");
            $end_date = Carbon::now();
        }
        elseif(!$request->start_year && $request->end_year)
        {
            $start_date = Carbon::create("2022", "1", "1");
            $end_date = Carbon::create($request->end_year, $request->end_month, "31");
        }
        elseif(!$request->start_year && !$request->end_year)
        {
            $start_date = Carbon::create("2022", "1", "1");
            $end_date = Carbon::now();
        }
        $filters = [
            'area' => $request->select_area,
            'from_date' => $start_date,
            'end_date' => $end_date
        ];
        $tickets = Ticket::where(function ($query) use ($filters) {
            if ($filters['area']) {
                $query->whereIn('area', $filters['area']);
            }
            if ($filters['from_date'] || $filters['end_date']) {
                $query->whereBetween('ticketing_date', [$filters['from_date'], $filters['end_date']]);
            }
        })->get();
        
        $files = Statistics::orderBy('created_at', 'desc')->paginate($perPage = 20);
        $news = News::orderBy('created_at', 'desc')->get();
        $tabValue = 1;
        $age = array_fill(0, 8, 0);
        $age_rate = array_fill(0, 8, 0);
        $sex_rate = 0;
        $man_count = 0;
        $all_ticket_rate = array_fill(0, 7, 0);
        $all_ticket_count = array_fill(0, 7, 0);
        $adult_young_count = 0;
        $adult_young_rate = 0;
        $location_rate = array_fill(0, 47, 0);
        $location_count = array_fill(0, 47, 0);
        $i = $tickets->count();
        if($i) {
            foreach ($tickets as $key => $value) {
                $year = Carbon::createFromFormat('Y-m-d', $value->birthday)->format('Y');
                $ages = Carbon::now()->format('Y') - $year;
                $sex = $value->sex;
                $adult_ticket = $value->adult_ticket;
                $young_ticket = $value->young_ticket;
                $all_ticket = $adult_ticket + $young_ticket;
                $location_name = $value->location;
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
                elseif(80 <= $ages)
                    $age[7]++;
                if($sex == "男性")
                    $man_count++;
                if($all_ticket == 0)
                    $all_ticket_count[0]++;
                elseif($all_ticket == 1)
                    $all_ticket_count[1]++;
                elseif($all_ticket == 2)
                    $all_ticket_count[2]++;
                elseif($all_ticket == 3)
                    $all_ticket_count[3]++;
                elseif($all_ticket == 4)
                    $all_ticket_count[4]++;
                elseif($all_ticket == 5)
                    $all_ticket_count[5]++;
                elseif($all_ticket == 6)
                    $all_ticket_count[6]++;
                if(($adult_ticket <> 0) && ($young_ticket <> 0))
                    $adult_young_count++;
                if($location_name == '北海道')
                    $location_count[0]++;
                elseif($location_name == '青森県')
                    $location_count[1]++;
                elseif($location_name == '岩手県')
                    $location_count[2]++;
                elseif($location_name == '宮城県')
                    $location_count[3]++;
                elseif($location_name == '秋田県')
                    $location_count[4]++;
                elseif($location_name == '山形県')
                    $location_count[5]++;
                elseif($location_name == '福島県')
                    $location_count[6]++;
                elseif($location_name == '茨城県')
                    $location_count[7]++;
                elseif($location_name == '栃木県')
                    $location_count[8]++;
                elseif($location_name == '群馬県')
                    $location_count[9]++;
                elseif($location_name == '埼玉県')
                    $location_count[10]++;
                elseif($location_name == '千葉県')
                    $location_count[11]++;
                elseif($location_name == '東京都')
                    $location_count[12]++;
                elseif($location_name == '神奈川県')
                    $location_count[13]++;
                elseif($location_name == '新潟県')
                    $location_count[14]++;
                elseif($location_name == '富山県')
                    $location_count[15]++;
                elseif($location_name == '石川県')
                    $location_count[16]++;
                elseif($location_name == '福井県')
                    $location_count[17]++;
                elseif($location_name == '山梨県')
                    $location_count[18]++;
                elseif($location_name == '長野県')
                    $location_count[18]++;
                elseif($location_name == '岐阜県')
                    $location_count[20]++;
                elseif($location_name == '静岡県')
                    $location_count[21]++;
                elseif($location_name == '愛知県')
                    $location_count[22]++;
                elseif($location_name == '三重県')
                    $location_count[23]++;
                elseif($location_name == '滋賀県')
                    $location_count[24]++;
                elseif($location_name == '京都府')
                    $location_count[25]++;
                elseif($location_name == '大阪府')
                    $location_count[26]++;
                elseif($location_name == '兵庫県')
                    $location_count[27]++;
                elseif($location_name == '奈良県')
                    $location_count[28]++;
                elseif($location_name == '和歌山県')
                    $location_count[29]++;
                elseif($location_name == '鳥取県')
                    $location_count[30]++;
                elseif($location_name == '島根県')
                    $location_count[31]++;
                elseif($location_name == '岡山県')
                    $location_count[32]++;
                elseif($location_name == '広島県')
                    $location_count[33]++;
                elseif($location_name == '山口県')
                    $location_count[34]++;
                elseif($location_name == '徳島県')
                    $location_count[35]++;
                elseif($location_name == '香川県')
                    $location_count[36]++;
                elseif($location_name == '愛媛県')
                    $location_count[37]++;
                elseif($location_name == '高知県')
                    $location_count[38]++;
                elseif($location_name == '福岡県')
                    $location_count[39]++;
                elseif($location_name == '佐賀県')
                    $location_count[40]++;
                elseif($location_name == '長崎県')
                    $location_count[41]++;
                elseif($location_name == '熊本県')
                    $location_count[42]++;
                elseif($location_name == '大分県')
                    $location_count[43]++;
                elseif($location_name == '宮崎県')
                    $location_count[44]++;
                elseif($location_name == '鹿児島県')
                    $location_count[45]++;
                elseif($location_name == '沖縄県')
                    $location_count[46]++;
            }
            for($j = 0; $j < 8; $j++) {
                $age_rate[$j] = round(($age[$j] / $i) * 100, 1);
            }
            for($j = 0; $j < 7; $j++) {
                $all_ticket_rate[$j] = round(($all_ticket_count[$j] / $i) * 100, 1);
            }
            for($j = 0; $j < 47; $j++) {
                $location_rate[$j] = round(($location_count[$j] / $i) * 100, 1);
            }
            $sex_rate = round(($man_count / $i) * 100, 1);
            $adult_young_rate = round(($adult_young_count / $i) * 100, 1);
        }
        return view('pages.user.home', compact('files', 'news', 'tabValue', 'age_rate', 'sex_rate', 'all_ticket_rate', 'adult_young_rate', 'location_rate', 'filters'));
    }
}
