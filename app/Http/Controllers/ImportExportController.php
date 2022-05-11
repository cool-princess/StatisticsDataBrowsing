<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Exports\DownloadCountExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use App\Models\Admin;
use Session;

use App\Models\User;

class ImportExportController extends Controller
{
    public function importUser( ){
        if(Auth::guard('admin')->check())
        {
            $admin_id = Auth::guard('admin')->user()->admin_id;
            $admin_break = Admin::select('break')->where('admin_id', '=', $admin_id)->get();
            if($admin_break[0]->break == 0) {
                Auth::guard('admin')->logout();
                $errors = new MessageBag(['admin_id' => ['許可が一時停止されました。']]);
                return view('auth.admin.login')->withErrors($errors);
            }

            return view('pages.admin.csv_register');
        }
        else
            return redirect('/admin/login');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request) 
    {
        if($request->file()) {
            $extension = $request->csv_file->getClientOriginalExtension();
            if($extension != 'csv')
            {
                toastr()->warning('拡張子がcsvのファイルを選択してください。','',config('toastr.options'));
                return back();
            }
            else {
                $path1 = $request->file('csv_file')->store('temp'); 
                $path = storage_path('app').'/'.$path1;  
                try {
                    $result = Excel::import(new UsersImport, $path);
                    toastr()->success('会員CSVデータが保存されました。','',config('toastr.options'));
                    return back()->with('success','登録を完了しました');
                }
                catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                    $failures = $e->failures();
                    Log::error($e);
                    toastr()->warning('会員CSVデータが保存されませんでした。','',config('toastr.options'));
                    return back()->withErrors($failures);
                }
                // Excel::import(new UsersImport,$request->file('file'));
                // toastr()->success('会員CSVデータが保存されました。','',config('toastr.options'));
                // return back();
            }
        }
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export($slug) 
    {
        return Excel::download(new UsersExport, '会員リスト.'.$slug);
    }

    public function userCountShow ()
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
            return view('pages.admin.user_count_download');
        }
        else
            return redirect('/admin/login');
    }

    public function userCountExport(Request $request) 
    {
        $from_dt = Carbon::create($request->from_date_year, $request->from_date_month, $request->from_date_day);
        $end_dt = Carbon::create($request->end_date_year, $request->end_date_month, $request->end_date_day);
        $param = [
            'from_date' => $from_dt,
            'end_date' => $end_dt,
            'address1' => $request->address1,
            'sectors' => $request->sectors
        ];

        $results = User::where(function ($query) use ($param) {
            if ($param['address1']) {
                $query->select('user_id')->where('address1', '=', $param['address1']);
            }
            if ($param['sectors']) {
                $query->select('user_id')->where('sectors', '=', $param['sectors']);
            }
            if ($param['from_date'] || $param['end_date']) {
                $query->select('user_id')->whereBetween('created_at', [$param['from_date'], $param['end_date']]);
            }
        })->get();

        foreach($results as $result)
        {
            User::where('user_id', $result->user_id)->update(array('download_count' => ($result->download_count + 1)));
        }

        return Excel::download(new DownloadCountExport($param), $from_dt.'～'.$end_dt.'.csv');
    }
}
