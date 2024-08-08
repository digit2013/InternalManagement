<?php

namespace App\Http\Controllers;

use App\Models\TaskFiles;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function home(){
        if(Session::get('user')== null){
            return view('login');
        }else{
            return view('home');

        }
    }
    public function download($fid){

        $file = TaskFiles::find($fid);

        if (File::exists(public_path($file->file_url))) {
            return response()->download(
                public_path($file->file_url),
                basename($file->file_url)
            );
        }
    }
}
