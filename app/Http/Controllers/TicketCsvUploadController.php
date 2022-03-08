<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TicketImport;
use Illuminate\Support\Facades\Auth;

class TicketCsvUploadController extends Controller
{
  public function show()
  {
    if(Auth::guard('admin')->check())
    {
      $files = File::paginate($perPage = 5);
      return view('pages.admin.visitor_data', compact('files'));
    }
    else
        return redirect('/admin/login');
  }

  public function createCsvForm()
  {
    if(Auth::guard('admin')->check())
    {
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
        $result = Excel::import(new TicketImport, $path);
        $fileName = time().'_'.$req->file->getClientOriginalName();
        $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');
        $fileModel->name = time().'_'.$req->file->getClientOriginalName();
        $fileModel->file_path = '/storage/' . $filePath;
        $fileModel->save();
        toastr()->success('チケット購入者データが保存されました。','',config('toastr.options'));
        return back();
      }
    }
  }

  public function delete($no)
  {
      File::where('id', $no)->delete();
      $files = File::paginate($perPage = 5);
      toastr()->success('来場者データが削除されました。','',config('toastr.options'));
      return view('pages.admin.visitor_data', compact('files'));
  }
}