<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Statistics;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use App\Models\Admin;
use ZipArchive;
use File;
use PDF;

class StatisticsFileController extends Controller
{
  public function showStatisticsFile()
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

      $files = Statistics::orderBy('created_at', 'desc')->paginate($perPage = 20);
      return view('pages.admin.statistics_file', compact('files'));
    }
    else
        return redirect('/admin/login');
  }

  public function showStatisticsFileRegister()
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
      $data = Statistics::max('id') + 1;
      return view('pages.admin.statistics_file_register', ['file_no' => $data]);
    }
    else
        return redirect('/admin/login');
  }

  public function statisticsFileRegister(Request $req) 
  {
    $fileModel = new Statistics;
    if($req->file()) {
      $extension = $req->file->getClientOriginalExtension();
      if($extension != 'pdf')
      {
        toastr()->warning('拡張子がpdfのファイルを選択してください。','',config('toastr.options'));
        return back();
      }
      else {
        $fileName = time().'_'.$req->file->getClientOriginalName();
        $filePath = $req->file('file')->move(public_path('uploads/統計ファイル'), $fileName);
        $fileModel->display_name = time().'_'.$req->file->getClientOriginalName();
        $fileModel->file_path = $filePath;
        $fileModel->category = $req->category;
        $fileModel->reporter = $req->reporter;
        $fileModel->created_at = Carbon::create($req->year, $req->month, $req->day);
        $fileModel->save();
        toastr()->success('統計ファイルが保存されました。','',config('toastr.options'));
        $files = Statistics::orderBy('created_at', 'desc')->paginate($perPage = 20);
        return view('pages.admin.statistics_file', compact('files'));
      }
    }
    else {
      toastr()->warning('CSVファイルを選択してください。','',config('toastr.options'));
      return back();
    }
  }

  public function showStatisticsFileUpdate($id)
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

      $data = Statistics::where('id', $id)->get();
      return view('pages.admin.statistics_file_update', compact('data'));
    }
    else
        return redirect('/admin/login');
  }

  public function statisticsFileUpdate(Request $req, $id)
  {
    if($req->file()) {
      $extension = $req->file->getClientOriginalExtension();
      if($extension != 'pdf')
      {
        toastr()->warning('拡張子がpdfのファイルを選択してください。','',config('toastr.options'));
        return back();
      }
      else {
        $fileName = time().'_'.$req->file->getClientOriginalName();
        $filePath = $req->file('file')->move(public_path('uploads/統計ファイル'), $fileName);
        Statistics::where('id', $id)->update(array('category' => $req->input('category')));
        Statistics::where('id', $id)->update(array('reporter' => $req->input('reporter')));
        Statistics::where('id', $id)->update(array('display_name' => time().'_'.$req->file->getClientOriginalName()));
        Statistics::where('id', $id)->update(array('file_path' => $filePath));
        Statistics::where('id', $id)->update(array('updated_at' => Carbon::create($req->year, $req->month, $req->day)));
        toastr()->success('統計ファイルが更新されました。','',config('toastr.options'));
        $files = Statistics::orderBy('created_at', 'desc')->paginate($perPage = 20);
        return view('pages.admin.statistics_file', compact('files'));
      }
    }
    else {
      Statistics::where('id', $id)->update(array('category' => $req->input('category')));
      Statistics::where('id', $id)->update(array('reporter' => $req->input('reporter')));
      Statistics::where('id', $id)->update(array('updated_at' => Carbon::create($req->year, $req->month, $req->day)));
      toastr()->success('統計ファイルが更新されました。','',config('toastr.options'));
      $files = Statistics::orderBy('created_at', 'desc')->paginate($perPage = 20);
      return view('pages.admin.statistics_file', compact('files'));
    }
  }

  public function delete($id)
  {
    Statistics::where('id', $id)->delete();
    $files = Statistics::orderBy('created_at', 'desc')->paginate($perPage = 20);
    toastr()->success('統計ファイルが削除されました。','',config('toastr.options'));
    return view('pages.admin.statistics_file', compact('files'));
  }

  public function statisticsFileExport($id) 
  {
    $file = Statistics::find($id);
    // $path = storage_path($file->file_path);
    return response()->download($file->file_path);
  }

  public function reportFileExport(Request $request) 
  {
    $fileId = $request->input('fileId');
    $file = Statistics::whereIn('id', $fileId)->get();
    $number_of_files = count($file);
    if (($number_of_files > 1) && ($number_of_files <= 10)) {
      if($request->has('download')) {
        $public_dir=public_path().'/uploads';
        $zipFileName = time().'_統計ファイル.zip';
        $zip = new ZipArchive;
        if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
          $files = File::files($public_dir.'/統計ファイル');
          foreach ($files as $key => $value) {
            foreach ($file as $items) {
              if($items['display_name'] == basename($value)) {
                $zip->addFile($public_dir.'/統計ファイル/'. $items['display_name'], '統計ファイル/'.$items['display_name']);
              }
            }
          }
          $zip->close();
        }
        // Set Header
        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );
        $filetopath=$public_dir.'/'.$zipFileName;
        // Create Download Response
        if(file_exists($filetopath)){
            return response()->download($filetopath,$zipFileName,$headers);
        }
      }
    } elseif($number_of_files == 1) {
      $headers = ['Content-Type: application/pdf'];
      $file_path = $file[0]->file_path;
      return response()->download($file_path, $file[0]->display_name, $headers);
    } else {
      toastr()->success('一度に選択できるファイル数は10個までです。','',config('toastr.options'));
      return back();
    }
  }
}