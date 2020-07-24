<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;
use Image;

class AjakController extends Controller
{
    public function infografik(Request $request)
    {
        //echo asset('pablik/infografik/14/blanditiis-doloribus1591941419.png');
        $thumb = time().'.'.$request->file->extension();
        $path = public_path('pablik/infografik/images');
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        $request->file->move($path, $thumb);
        if(file_exists($path.'/'.$thumb))
        {
            echo secure_asset('pablik/infografik/images/'.$thumb);
        }else{
            echo 'https://via.placeholder.com/150x150?text=Upload+Error';
        }
    }
}
