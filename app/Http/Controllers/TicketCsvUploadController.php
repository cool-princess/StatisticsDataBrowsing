<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TicketImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use App\Models\Admin;

class TicketCsvUploadController extends Controller
{
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

      $files = File::orderBy('created_at', 'desc')->paginate($perPage = 5);
      return view('pages.admin.visitor_data', compact('files'));
    }
    else
        return redirect('/admin/login');
  }

  public function createCsvForm()
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

      $data = File::max('id') + 1;
      return view('pages.admin.visitor_csv_register', ['file_no' => $data]);
    }
    else
        return redirect('/admin/login');
  }

  public function csvFileUpload(Request $req) 
  {
    $fileModel = new File;
    if($req->file()) {
      $extension = $req->file->getClientOriginalExtension();
      if($extension != 'csv')
      {
        toastr()->warning('拡張子がcsvのファイルを選択してください。','',config('toastr.options'));
        return back();
      }
      else {
        $path1 = $req->file('file')->store('temp'); 
        $path = storage_path('app').'/'.$path1;  
        try {
          $result = Excel::import(new TicketImport, $path);
          $duplicated = DB::table('ticket')
                      ->select('order_number', DB::raw('count(`order_number`) as occurences'))
                      ->groupBy('order_number')
                      ->having('occurences', '>', 1)
                      ->get();
          foreach ($duplicated as $duplicate) {
            $dontDeleteThisRow = Ticket::where('order_number', $duplicate->order_number)->first();
            Ticket::where('order_number', $duplicate->order_number)->where('id', '!=', $dontDeleteThisRow->id)->delete();
          }
          
          $fileName = time().'_'.$req->file->getClientOriginalName();
          $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');
          $fileModel->name = $req->file->getClientOriginalName();
          $fileModel->file_path = '/storage/app/public/' . $filePath;
          $fileModel->save();
          toastr()->success('チケット購入者データが保存されました。','',config('toastr.options'));
          return back()->with('success','登録を完了しました');
        }
        catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
          $failures = $e->failures();
          Log::error($e);
          toastr()->warning('チケット購入者データが保存されませんでした。','',config('toastr.options'));
          return back()->withErrors($failures);
        }
      }
    }
  }

  public function delete($no)
  {
      File::where('id', $no)->delete();
      $files = File::paginate($perPage = 5);
      toastr()->success('チケット購入者データが削除されました。','',config('toastr.options'));
      return view('pages.admin.visitor_data', compact('files'));
  }
}