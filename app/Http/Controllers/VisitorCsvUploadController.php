<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\File;

class VisitorCsvUploadController extends Controller
{
  public function show()
  {
    $files = File::paginate($perPage = 5);
    return view('pages.admin.visitor_data', compact('files'));
  }

  public function createCsvForm()
  {
    $data = File::max('id') + 1;
    return view('pages.admin.visitor_csv_register', ['file_no' => $data]);
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
        $fileName = time().'_'.$req->file->getClientOriginalName();
        $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');
        $fileModel->name = time().'_'.$req->file->getClientOriginalName();
        $fileModel->file_path = '/storage/' . $filePath;
        $fileModel->save();
        toastr()->success('来場者CSVデータが保存されました。','',config('toastr.options'));
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