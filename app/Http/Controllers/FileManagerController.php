<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\SentMessage; 
use Illuminate\Support\Facades\Storage;
use Validator;

class FileManagerController extends Controller
{
    public function my_drive()
    {
        return view('file_manager.my_drive');
    }

    public function folder_view($id)
    {
        $m_user_id = Auth::user()->emp_id;
        $m_folder =  DB::table('pro_folder')->where('user_id', $m_user_id)->where('folder_id', $id)->first();
        $m_sub_folder =  DB::table('pro_sub_folder')->where('user_id', $m_user_id)->where('folder_id', $id)->get();
        $m_file =  DB::table('pro_file')->where('user_id', $m_user_id)->where('folder_id', $id)->where('folder_sub_id', null)->get();
        return view('file_manager.folder_view', compact('m_folder', 'm_sub_folder', 'm_file'));
    }

    //Folder Store
    public function folder_store(Request $request)
    {
        $rules = [
            'txt_folder' => 'required',
        ];

        $customMessages = [
            'txt_folder.required' => 'Folder is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $check =   DB::table('pro_folder')->where('user_id', Auth::user()->emp_id)->where('folder_name', $request->txt_folder)->first();
        if ($check) {
            return back()->with('warning', 'Folder Alredy Exist');
        } else {
            DB::table('pro_folder')->insert([
                'folder_name' => $request->txt_folder,
                'user_id' => Auth::user()->emp_id,
                'valid' => 1,
                'entry_date' => date('Y-m-d'),
                'entry_time' => date("h:i:sa"),
            ]);

            return back()->with('Success', 'Folder Add Successfully.');
        }
    }

    public function folder_sub_store(Request $request, $id)
    {
        $rules = [
            'txt_folder' => 'required',
        ];

        $customMessages = [
            'txt_folder.required' => 'Folder is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $check =   DB::table('pro_folder')->where('user_id', Auth::user()->emp_id)->where('folder_name', $request->txt_folder)->first();
        if ($check) {
            return back()->with('warning', 'Folder Alredy Exist');
        } else {
            DB::table('pro_sub_folder')->insert([
                'folder_name' => $request->txt_folder,
                'folder_id' => $id,
                'user_id' => Auth::user()->emp_id,
                'entry_date' => date('Y-m-d'),
                'entry_time' => date("h:i:sa"),
            ]);

            return back()->with('Success', 'Folder Add Successfully.');
        }
    }
    //Folder Store End


    //File Store
    public function file_store(Request $request)
    {

        //Converted Byte to k,mb,gb
        $bytes = $request->file('txt_file')->getSize();
        $precision = 2;
        if ($bytes > pow(1024, 3)) {
            $file_size = round($bytes / pow(1024, 3), $precision) . 'GB';
        } elseif ($bytes > pow(1024, 2)) {
            $file_size = round($bytes / pow(1024, 2), $precision) . 'MB';
        } elseif ($bytes > 1024) {
            $file_size = round($bytes / 1024, $precision) . 'KB';
        } else {
            $file_size = $bytes . 'B';
        }



        $rules = [
            'txt_file' => 'required|mimes:png,jpg,jpeg,csv,txt,xlsx,xls,pdf,docx,doc,zip,rar,mp4,pptx,ppt|max:1034000',
        ];

        $customMessages = [
            'txt_file.required' => 'File is required!',
            'txt_file.max' => "Maxmium File Size 1 Gb! Your Uploded File Size is $file_size",
            'txt_file.mimes' => 'png,jpg,jpeg,csv,txt,xlsx,xls,pdf,docx,doc,zip,rar,mp4,pptx,ppt',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;
        $current_date = date('Y-m-d');
        $your_date = strtotime("20 day", strtotime("$current_date"));
        $expireDate = date("Y-m-d", $your_date);

        $filename = $request->file('txt_file')->getClientOriginalName();

        $check =  DB::table('pro_file')->where('user_id', $m_user_id)->where('file_name', $filename)->first();


        if ($check) {
            return back()->with('warning', 'File Alredy Exist');
        } else {


            $txt_file = $request->file('txt_file');
            if ($request->hasFile('txt_file')) {
                $upload_path = "public/mydrive/$m_user_id/";
                $image_url = $upload_path . $filename;
                $txt_file->move($upload_path, $filename);
            }

            DB::table('pro_file')->insert([
                'file_name' => $filename,
                'file_size' => $file_size,
                'myFile' => $image_url,
                'user_id' => Auth::user()->emp_id,
                'entry_date' => date('Y-m-d'),
                'entry_time' => date("h:i:sa"),
                'expire_date' => $expireDate,
            ]);

            return back()->with('Success', 'File Add Successfully.');
        }
    }


    public function file_sub_store(Request $request, $id)
    {

        //Converted Byte to k,mb,gb
        $bytes = $request->file('txt_file')->getSize();
        $precision = 2;
        if ($bytes > pow(1024, 3)) {
            $file_size = round($bytes / pow(1024, 3), $precision) . 'GB';
        } elseif ($bytes > pow(1024, 2)) {
            $file_size = round($bytes / pow(1024, 2), $precision) . 'MB';
        } elseif ($bytes > 1024) {
            $file_size = round($bytes / 1024, $precision) . 'KB';
        } else {
            $file_size = $bytes . 'B';
        }

        $rules = [
            'txt_file' => 'required|mimes:png,jpg,jpeg,csv,txt,xlsx,xls,pdf,docx,doc,zip,rar,mp4,pptx,ppt|max:1034000',
        ];

        $customMessages = [
            'txt_file.required' => 'File is required!',
            'txt_file.max' => "Maxmium File Size 1 Gb! Your Uploded File Size is $file_size",
            'txt_file.mimes' => 'png,jpg,jpeg,csv,txt,xlsx,xls,pdf,docx,doc,zip,rar,mp4,pptx,ppt',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;
        $current_date = date('Y-m-d');
        $your_date = strtotime("20 day", strtotime("$current_date"));
        $expireDate = date("Y-m-d", $your_date);


        $m_folder =   DB::table('pro_folder')->where('user_id', $m_user_id)->where('folder_id', $id)->first();
        $m_folder_name = $m_folder == null ? "0" : $m_folder->folder_name;

        $filename = $request->file('txt_file')->getClientOriginalName();


        $check =   DB::table('pro_file')->where('user_id', $m_user_id)->where('folder_id', $id)->where('file_name', $filename)->first();
        if ($check) {
            return back()->with('warning', 'File Alredy Exist');
        } else {


            $txt_file = $request->file('txt_file');
            if ($request->hasFile('txt_file')) {
                $upload_path = "public/mydrive/$m_user_id/$m_folder_name/";
                $image_url = $upload_path . $filename;
                $txt_file->move($upload_path, $filename);
            }

            DB::table('pro_file')->insert([
                'file_name' =>  $filename,
                'folder_id' => $id,
                'file_size' => $file_size,
                'myFile' => $image_url,
                'user_id' => Auth::user()->emp_id,
                'entry_date' => date('Y-m-d'),
                'entry_time' => date("h:i:sa"),
                'expire_date' => $expireDate,
            ]);

            return back()->with('Success', 'File Add Successfully.');
        }
    }

    //File Store End

    //Sub Child 
    public function sub_folder_view($id)
    {
        $m_user_id = Auth::user()->emp_id;
        $m_sub_folder =  DB::table('pro_sub_folder')->where('user_id', $m_user_id)->where('folder_sub_id', $id)->first();
        $m_file =  DB::table('pro_file')->where('user_id', $m_user_id)->where('folder_id', $m_sub_folder->folder_id)->where('folder_sub_id', $m_sub_folder->folder_sub_id)->get();
        return view('file_manager.m_sub_folder', compact('m_sub_folder', 'm_file'));
    }

    public function sub_file_store(Request $request, $id)
    {

        //Converted Byte to k,mb,gb
        $bytes = $request->file('txt_file')->getSize();
        $precision = 2;
        if ($bytes > pow(1024, 3)) {
            $file_size = round($bytes / pow(1024, 3), $precision) . 'Gb';
        } elseif ($bytes > pow(1024, 2)) {
            $file_size = round($bytes / pow(1024, 2), $precision) . 'Mb';
        } elseif ($bytes > 1024) {
            $file_size = round($bytes / 1024, $precision) . 'Kb';
        } else {
            $file_size = $bytes . 'B';
        }

        $rules = [
            'txt_file' => 'required|mimes:png,jpg,jpeg,csv,txt,xlsx,xls,pdf,docx,doc,zip,rar,mp4,pptx,ppt|max:1034000',
        ];

        $customMessages = [
            'txt_file.required' => 'File is required!',
            'txt_file.max' => "Maxmium File Size 1 Gb! Your Uploded File Size is $file_size",
            'txt_file.mimes' => 'png,jpg,jpeg,csv,txt,xlsx,xls,pdf,docx,doc,zip,rar,mp4,pptx,ppt',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;
        $current_date = date('Y-m-d');
        $your_date = strtotime("20 day", strtotime("$current_date"));
        $expireDate = date("Y-m-d", $your_date);


        $m_sub_folder =  DB::table('pro_sub_folder')->where('user_id', $m_user_id)->where('folder_sub_id', $id)->first();
        $m_sub_folder_name = $m_sub_folder == null ? "0" : $m_sub_folder->folder_name;
        $m_folder =   DB::table('pro_folder')->where('user_id', $m_user_id)->where('folder_id', $m_sub_folder->folder_id)->first();
        $m_folder_name = $m_folder == null ? "0" : $m_folder->folder_name;
        $filename = $request->file('txt_file')->getClientOriginalName();


        $check =   DB::table('pro_file')->where('user_id', $m_user_id)
            ->where('folder_id', $m_sub_folder->folder_id)
            ->where('folder_sub_id', $id)
            ->where('file_name', $filename)
            ->first();

        if ($check) {
            return back()->with('warning', 'File Alredy Exist');
        } else {
            $txt_file = $request->file('txt_file');
            if ($request->hasFile('txt_file')) {
                $upload_path = "public/mydrive/$m_user_id/$m_folder_name/$m_sub_folder_name/";
                $image_url = $upload_path . $filename;
                $txt_file->move($upload_path, $filename);
            }

            DB::table('pro_file')->insert([
                'file_name' =>  $filename,
                'folder_id' => $m_sub_folder->folder_id,
                'folder_sub_id' => $m_sub_folder->folder_sub_id,
                'file_size' => $file_size,
                'myFile' => $image_url,
                'user_id' => Auth::user()->emp_id,
                'entry_date' => date('Y-m-d'),
                'entry_time' => date("h:i:sa"),
                'expire_date' => $expireDate,
            ]);

            return back()->with('Success', 'File Add Successfully.');
        }
    }

    //Sub Child End

    //All Delete section
    public function folder_delete($id)
    {
        $m_user_id = Auth::user()->emp_id;
        $m_folder = DB::table('pro_folder')->where('user_id', $m_user_id)->where('folder_id', $id)->first();

        if ($m_folder) {
            $m_files =  DB::table('pro_file')->where('user_id', $m_user_id)->where('folder_id', $id)->get();
            if ($m_files) {
                foreach ($m_files as $m_file) {
                    if ($m_file->myFile && file_exists($m_file->myFile)) {
                        unlink($m_file->myFile);
                    }
                    DB::table('pro_file')->where('user_id', $m_user_id)->where('folder_sub_id', $m_file->file_id)->delete();
                }
            }

            //directory delete
            $dir = public_path("mydrive/$m_user_id/$m_folder->folder_name");
            if (File::isDirectory($dir)) {
                File::deleteDirectory($dir);
            }

            DB::table('pro_sub_folder')->where('user_id', $m_user_id)->where('folder_id', $id)->delete();
            DB::table('pro_folder')->where('user_id', $m_user_id)->where('folder_id', $id)->delete();
        } else {
            return back()->with('warning', 'Folder Not Found.');
        }

        return back()->with('Success', 'Delete Successfull.');
    }

    public function Sub_folder_delete($sub_folder_id)
    {
        $m_user_id = Auth::user()->emp_id;
        $m_sub_folder =  DB::table('pro_sub_folder')->where('user_id', $m_user_id)->where('folder_sub_id', $sub_folder_id)->first();
        $m_folder =  DB::table('pro_folder')->where('user_id', $m_user_id)->where('folder_id', $m_sub_folder->folder_id)->first();

        if ($m_sub_folder) {
            $m_files =  DB::table('pro_file')
                ->where('user_id', $m_user_id)
                ->where('folder_id', $m_sub_folder->folder_id)
                ->where('folder_sub_id', $m_sub_folder->folder_sub_id)
                ->get();
            if ($m_files) {
                foreach ($m_files as $m_file) {
                    if ($m_file->myFile && file_exists($m_file->myFile)) {
                        unlink($m_file->myFile);
                    }
                    DB::table('pro_file')->where('user_id', $m_user_id)->where('file_id', $m_file->file_id)->delete();
                }
            }

            //directory delete
            $dir = public_path("mydrive/$m_user_id/$m_folder->folder_name/$m_sub_folder->folder_name");
            if (File::isDirectory($dir)) {
                File::deleteDirectory($dir);
            }

            DB::table('pro_sub_folder')
                ->where('user_id', $m_user_id)
                ->where('folder_id', $m_sub_folder->folder_id)
                ->where('folder_sub_id', $m_sub_folder->folder_sub_id)
                ->delete();
        } else {
            return back()->with('warning', 'Folder Not Found.');
        }

        return back()->with('Success', "Delete Successfull.");
    }

    public function file_delete($file_id)
    {
        $m_user_id = Auth::user()->emp_id;
        $m_file =  DB::table('pro_file')->where('user_id', $m_user_id)->where('file_id', $file_id)->first();
        if ($m_file) {
            if ($m_file->myFile && file_exists($m_file->myFile)) {
                unlink($m_file->myFile);
            }
            DB::table('pro_file')->where('user_id', $m_user_id)->where('file_id', $file_id)->delete();
        } else {
            return back()->with('warning', 'File Not Found.');
        }
        return back()->with('Success', 'Delete Successfull.');
    }

    public function fileDawonload($id)
    {
        $m_user_id = Auth::user()->emp_id;
        $m_file = DB::table('pro_file')->where('user_id', $m_user_id)->where('file_id', $id)->first();
        if ($m_file) {
            return response()->download($m_file->myFile);
        } else {
            return back()->with('warning', 'File Not Found.');
        }
    }


    // Send File link and mail

    public function Send(Request $request)
    {

       $to_email = $request->email;
       $first_mail = '';
        if (isset($to_email)) 
        {
            $first_mail = $to_email[0];
        } 
        else
        {
            return back()->with('warning', "Email is required");
        } //if (isset($to_email))
                    
                     


        $chars = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
        $random_password = "$request->txt_file_id" . substr(str_shuffle($chars), 0, 10);

        $employe = DB::table('pro_employee_info')->where('employee_id', Auth::user()->emp_id)->first();
        $employe_name = $employe == null ? '' : $employe->employee_name;
        $enc1 = base64_encode('file_manager');
        $enc2 = base64_encode('5694934');

        $current_date = date('Y-m-d');
        $your_date = strtotime("20 day", strtotime("$current_date"));
        $expireDate = date("Y-m-d", $your_date);

        $m_user_id = Auth::user()->emp_id;
         $request->txt_file_id;
          $m_file = DB::table('pro_file')
        ->where('user_id', $m_user_id)
        ->where('file_id', $request->txt_file_id)
        ->first();


        $data = array();
        $data['to_email'] = $first_mail;  
        $data['from_email'] = "no_reply@sq-bd.com";
        $data['file_id'] = $request->txt_file_id;
        $data['file_name'] = $m_file->file_name;
        $data['random_password'] = $random_password;
        $data['user_name'] = $employe_name;
        $data['subject'] = "Attach file";
        $data['expire_date'] =  $expireDate;

        $data['link'] = url("")."/file_manager". "/" . $enc1 . "/" . $enc2;

        $m_biodata = DB::table('pro_employee_biodata')
        ->where('employee_id',$m_user_id)
        ->first();


        if($m_biodata && isset($m_biodata->email_office))
        {
            $data['cc_email'] = "$m_biodata->email_office";
            Mail::send('file_manager.mail', $data, function ($message) use ($data,$to_email)
            {
                $message->to($to_email,'')
                ->cc($data['cc_email'])
                ->subject($data['subject']);
                $message->from($data['from_email'], '');
            });

        } else {
            Mail::send('file_manager.mail', $data, function ($message) use ($data,$to_email)
            {
                $message->to($to_email,'')
                ->subject($data['subject']);
                $message->from($data['from_email'], '');
            });
        }// if($m_biodata && isset($m_biodata->email_office))


            $data['user_id'] = Auth::user()->emp_id;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['valid'] = 1;
            DB::table('pro_share_link')->insert($data);

            DB::table('pro_file')
            ->where('file_id',$request->txt_file_id)
            ->update(['expire_date'=>$expireDate]);

        return back()->with('success', "Success send message");

    }


    public function share_history()
    {
        $form = date('Y-m-d');
        $to = date('Y-m-d');
        $my_data = DB::table('pro_share_link')
            ->leftJoin('pro_file', 'pro_share_link.file_id', 'pro_file.file_id')
            ->select('pro_share_link.*', 'pro_file.file_name')
            ->where('pro_share_link.user_id', Auth::user()->emp_id)
            // ->where('expire_date','>=',date('Y-m-d'))
            ->orderByDesc('pro_share_link.share_id')
            ->take(10)
            ->get();

        return view('file_manager.share_history', compact('my_data', 'form', 'to'));
    }

    public function share_history_search(Request $request)
    {
        $rules = [
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
        ];

        $customMessages = [
            'txt_from_date.required' => 'Form is required!',
            'txt_to_date.required' => 'To is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $form = $request->txt_from_date;
        $to = $request->txt_to_date;

        $my_data = DB::table('pro_share_link')
            ->leftJoin('pro_file', 'pro_share_link.file_id', 'pro_file.file_id')
            ->select('pro_share_link.*', 'pro_file.file_name')
            ->where('pro_share_link.user_id', Auth::user()->emp_id)
            ->whereBetween('pro_share_link.entry_date', [$form, $to])
            // ->where('expire_date','>=',date('Y-m-d'))
            ->orderByDesc('pro_share_link.share_id')
            ->take(10)
            ->get();

        return view('file_manager.share_history', compact('my_data', 'form', 'to'));
    }

    //Share Login and dawonload

    public function FileManagerLogin($id,$id2)
    {
        return view('file_manager.login');
    }

    public function login_check(Request $request)
    {
        $rules = [
            'txt_email' => 'required',
            'password' => 'required',
        ];
        $customMessages = [
            'txt_email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $my_data = DB::table('pro_share_link')
            ->where('to_email', $request->txt_email)
            ->where('random_password', $request->password)
            ->where('expire_date', '>=', date('Y-m-d'))
            ->first();

        if ($my_data) {
            $file = DB::table('pro_file')->where('user_id', $my_data->user_id)->where('file_id', $my_data->file_id)->first();
            return view('file_manager.file_dawonload_list', compact('my_data', 'file'));
        } else {
            return back()->with('warning', "Wrong Email and Password or Expired.");
        }
    }

    public function Dawonload($id, $share_id)
    {
        $m_file = DB::table('pro_file')->where('file_id', $id)->first();

        $my_data = DB::table('pro_share_link')
            ->where('share_id', $share_id)
            ->where('expire_date', '>=', date('Y-m-d'))
            ->first();

        if ($m_file && $my_data) {

            $copy = $my_data->dawonload + 1;
            DB::table('pro_share_link')
                ->where('share_id', $share_id)
                ->update([
                    'dawonload' => $copy,
                    'dawonload_date' => date('Y-m-d'),
                    'dawonload_time' => date("h:i:sa"),
                ]);

            return response()->download($m_file->myFile);
        } else {
            return back()->with('warning', 'File Not Found.');
        }
    }
}
