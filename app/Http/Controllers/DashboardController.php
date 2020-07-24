<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InfoGrafik;
use App\Post;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //return view('home');
        if (isAdmin()){
            $pos_publish = Post::where('status', "1")->count();
            $pos_draft = Post::where('status', "0")->count();
            $ig_publish = InfoGrafik::where('status', "1")->count();
            $ig_draft = InfoGrafik::where('status', "0")->count();
            $sekarang = strtotime(date ('Y-m-d H:i:s', time()));
            $hari = array();
            for($i = 7; $i>0; $i--)
            {
                $hari[$i] = date ('D d',strtotime('-'.$i.' day', $sekarang ));
            }
            $data = [
                'days' => $hari,
                'pos_publish' => $pos_publish,
                'pos_draft' => $pos_draft,
                'ig_publish' => $ig_publish,
                'ig_draft' => $ig_draft,
            ];
            return view('dashboard-4', $data);
        }else{
            return redirect('logout');
        }
    }
}
