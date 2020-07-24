<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;
use App\InfoGrafik as Kueri;
use App\User;
use Image;

include(public_path('simple_html_dom.php'));

class InfoGrafikController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->folder = 'infografik';
    }
    public function index()
    {
        if (isAdmin()){
            $lists = Kueri::latest()->paginate(10);
            $quer = [
                'lists' => $lists,
            ];
            return view('web.'.$this->folder.'.list', $quer);
        }else{
            return view('welcome');
        }
    }
    public function show(Request $request)
    {
        if (isAdmin()){
            if(!empty($request->get('query'))){
                $lists = Kueri::where('title', 'like', '%'.strip_tags($request->get('query')).'%')
                            ->orWhere('slug', 'like', '%'.strip_tags($request->get('query')).'%')
                            ->orWhere('keyword', 'like', '%'.strip_tags($request->get('query')).'%')
                            ->orWhere('description', 'like', '%'.strip_tags($request->get('query')).'%')
                            ->orderBy('id', 'DESC')
                            ->paginate(10);
                $quer = [
                    'lists' => $lists
                ];
                return view('web.'.$this->folder.'.list', $quer);
            }else{
                return redirect()->route('infografik.index');
            }
        }else{
            return view('welcome');
        }
    }
    public function create() 
    {
        if (isAdmin()){
            return view('web.'.$this->folder.'.create');
        }else{
            return view('welcome');
        }
    }
    public function store(Request $request)
    {
        $request->validate([
                'title' => 'required|unique:posts',
                'description' => 'required',
                'tamnel' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'title.required' => 'Judul tidak boleh kosong',
                'title.unique' => 'Judul sudah digunakan',
                'description.required' => 'Deskripsi tidak boleh kosong',
                'tamnel.image' => 'Mohon unggah berkas gambar saja',
                'tamnel.mimes' => 'Format Thumbnail tidak didukung',
                'tamnel.max' => 'Ukuran Thumbnail terlalu besar',
            ]
        );
        $quer = new Kueri();
        $titel = htmlspecialchars(strip_tags($request->get('title')));
        $slak = Str::slug($titel, '-').'-'.time();
        $dsave = [
            'author' => Auth::id(),
            'title' => $titel,
            'slug' => $slak,
            'keyword' => $request->get('keyword'),
            'description' => $request->get('description'),
            'status' => $request->get('status'),
        ];
        $save = $quer->create($dsave);
        if($save)
        {
            $id = $save->id;
            $quer2 = Kueri::findOrFail($id);
            if(!empty($request->get('content')) && Str::contains(strtolower($request->get('content')), ['<html', '<body']))
            {
                $sidom = str_get_html($request->get('content'));
                $sidom->find('title', 0)->innertext = $titel.' - '.env('APP_NAME');
                $meta = '
                <meta name="viewport" content="width=device-width">
                <meta name="description" content="'.$request->get('description').'">
                <meta name="keywords" content="'.$request->get('keyword').'">
                <meta name="googlebot-news" content="index, follow, follow" />
                <meta  name="googlebot" content="index, follow, follow" />
                <meta name="author" content="'.env('APP_NAME').'">';
                $riples = $sidom->find('head', 0)->innertext;
                $sidom->find('head', 0)->innertext = $sidom->find('head', 0)->innertext.$meta;
                $detail = $sidom->save();

                $path = public_path('pablik/infografik/pages/'.$id);
                File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                $namafile = $slak.'.html';
                File::put($path.'/'.$namafile, $detail);
                if(file_exists($path.'/'.$namafile))
                {
                    $quer2->content = 'pablik/infografik/pages/'.$id.'/'.$namafile;
                }
            }

            if($request->hasFile('tamnel'))
            {
                $thumb = Str::slug($titel, '-').time().'.'.$request->tamnel->extension();
                $path = public_path('pablik/infografik/pages/'.$id);
                File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                $request->tamnel->move($path, $thumb);
    
                if(file_exists($path.'/'.$thumb))
                {
                    $quer2->thumbnail = 'pablik/infografik/pages/'.$id.'/'.$thumb;
                }
            }
            $quer2->save();
        }
        $msg = '<div class="alert alert-success fade show"><p class="mb-0">Info Grafik baru ditambahkan!</p></div>';
        return redirect()->route('infografik.index')->with('msg', $msg);
    }
    public function edit($id)
    {
        if (isAdmin()){
            $row = Kueri::findOrFail($id);
            $quer = [
                'row' => $row
            ];
            return view('web.'.$this->folder.'.edit', $quer);
        }else{
            return view('welcome');
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
                'title' => 'required|unique:posts,title,' . $id . ',id',
                'description' => 'required',
                'tamnel' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'title.required' => 'Judul tidak boleh kosong',
                'title.unique' => 'Judul sudah digunakan',
                'description.required' => 'Deskripsi tidak boleh kosong',
                'tamnel.image' => 'Mohon unggah berkas gambar saja',
                'tamnel.mimes' => 'Format Thumbnail tidak didukung',
                'tamnel.max' => 'Ukuran Thumbnail terlalu besar',
            ]
        );
        $quer = Kueri::findOrFail($id);
        $titel = htmlspecialchars(strip_tags($request->get('title')));
        $waktu = time();
        $slak = Str::slug($titel, '-').'-'.$waktu;
        if($request->get('title') !== $quer->title)
        {
            $quer->title = $titel;
            $quer->slug = $slak;
        }
        if(!empty($request->get('content')))
        {
            if(!empty($request->get('content')) && Str::contains(strtolower($request->get('content')), ['<html', '<body', '<title']))
            {            
                $detail = $request->get('content');
                $sidom = str_get_html($detail);
                $sidom->find('title', 0)->innertext = $titel.' - '.env('APP_NAME');
                $meta = '
                <meta name="viewport" content="width=device-width">
                <meta name="description" content="'.$request->get('description').'">
                <meta name="keywords" content="'.$request->get('keyword').'">
                <meta name="googlebot-news" content="index, follow, follow" />
                <meta  name="googlebot" content="index, follow, follow" />
                <meta name="author" content="'.env('APP_NAME').'">';
                $riples = $sidom->find('head', 0)->innertext;
                $sidom->find('head', 0)->innertext = $sidom->find('head', 0)->innertext.$meta;
                
                $path = public_path('pablik/infografik/pages/'.$id);
                File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                $detail = $sidom->save();
                $namafile = $slak.'.html';
                File::put($path.'/'.$namafile, $detail);
                if(file_exists($path.'/'.$namafile))
                {
                    $quer->content = 'pablik/infografik/pages/'.$id.'/'.$namafile;
                }
            }
            if($request->hasFile('tamnel'))
            {
                $thumb = Str::slug($titel, '-').time().'.'.$request->tamnel->extension();
                $path = public_path('pablik/infografik/pages/'.$id);
                File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                $request->tamnel->move($path, $thumb);
    
                if(file_exists($path.'/'.$thumb))
                {
                    $quer->thumbnail = 'pablik/infografik/pages/'.$id.'/'.$thumb;
                }
            }
        }
        $quer->keyword = $request->get('keyword');
        $quer->status = $request->get('status');
        $quer->save();
        $msg = '<div class="alert alert-success fade show"><p class="mb-0">Sukses Update Info Grafik!</p></div>';
        return redirect()->route('infografik.index')->with('msg', $msg);
    }
    public function destroy($id)
    {
        $quer = Kueri::findOrFail($id);
        $quer->delete();
        $path = public_path('pablik/infografik/pages/'.$id);
        if(File::isDirectory($path))
        {
            File::deleteDirectory($path);
        }
        $msg = '<div class="alert alert-success fade show"><p class="mb-0">Sukses menghapus Info Grafik!</p></div>';
        return redirect()->route('infografik.index')->with('msg', $msg);

    }
    public function deletemass(Request $request)
    {
        $ids = $request->get('ids');
        $arr = explode(",", $ids);
        Kueri::whereIn('id', explode(",", $ids))->delete();
        
        foreach($arr as $key=>$val)
        {
            $path = public_path('pablik/infografik/pages/'.$val);
            if(File::isDirectory($path))
            {
                File::deleteDirectory($path);
            }
        }
        $msg = '<div class="alert alert-success fade show"><p class="mb-0">Sukses menghapus Info Grafik!</p></div>';
        return redirect()->route('infografik.index')->with('msg', $msg);
    }
}
