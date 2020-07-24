<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

function isAdmin()
{
    if(Auth::check())
    {
        $user = DB::table('user_groups')->where('user_id', Auth::id())->first();
        if($user)
        {
            if($user->group_id == 2)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }else{
        return false;
    }
}
function isMember()
{
    if(Auth::check())
    {
        $user = DB::table('user_groups')->where('user_id', Auth::id())->first();
        if($user)
        {
            if($user->group_id == 1)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }else{
        return false;
    }
}
function validate_url($url)
{
    $path = parse_url($url, PHP_URL_PATH);
    $encoded_path = array_map('urlencode', explode('/', $path));
    $url = str_replace($path, implode('/', $encoded_path), $url);

    return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
}
function getBytesFromHexString($hexdata)
{
    for($count = 0; $count < strlen($hexdata); $count+=2)
    $bytes[] = chr(hexdec(substr($hexdata, $count, 2)));
    return implode($bytes);
}

function getImageMimeType($imagedata)
{
    $imagemimetypes = array( 
        "jpeg" => "FFD8", 
        "png" => "89504E470D0A1A0A", 
        "gif" => "474946",
        "bmp" => "424D", 
        "tiff" => "4949",
        "tiff" => "4D4D"
    );
    foreach ($imagemimetypes as $mime => $hexbytes)
    {
        $bytes = getBytesFromHexString($hexbytes);
        if (substr($imagedata, 0, strlen($bytes)) == $bytes)
        {
            return $mime;
        }
    }
    return NULL;
}