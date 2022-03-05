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
use Session;

use App\Models\User;

class ImportExportController extends Controller
{
    public function importUser( ){
        return view('pages.admin.csv_register');
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
                    return back();
                }
                catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                    $failures = $e->failures();
                    Log::error($e);
                    $errormessage = "";
                    foreach ($failures as $failure) {
                        $errormess = "";
                        foreach($failure->errors() as $error)
                        {
                            $errormess = $errormess.$error;
                        }
                        $errormessage .= "At Row ".$failure->row().", ".$errormess." ,\n";
                    }
                    Session::flash('error', $errormessage);
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
        return Excel::download(new DownloadCountExport($param), $from_dt.'～'.$end_dt.'.csv');
    }
}
