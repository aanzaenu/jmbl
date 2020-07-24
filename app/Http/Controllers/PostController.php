<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Post as Kueri;
use App\Category;
use App\Categorypost;
use App\User;
use Image;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->folder = 'post';
    }
    public function index()
    {
        if (isAdmin()){
            $lists = Kueri::latest()->paginate(10);
            $categories = Category::orderBy('name', 'ASC')->get();
            $users = User::orderBy('name', 'ASC')->get();
            foreach($lists as $key=>$list)
            {
                if($list->categoryposts)
                {
                    $lists[$key]->kategori = Category::where('id', $list->categoryposts->category_id)->first()->name;
                }else{
                    $lists[$key]->kategori = '-';
                }
            }
            $quer = [
                'lists' => $lists,
                'categories' => $categories,
                'users' =>$users
            ];
            return view('web.'.$this->folder.'.list', $quer);
        }else{
            return view('welcome');
        }
    }
    public function show(Request $request)
    {
        if (isAdmin()){
            if(!empty($request->get('query')) || !empty($request->get('category')) || !empty($request->get('author'))){
                
                $listss = Kueri::join('categoryposts', function($join){
                    $join->on('posts.id', '=','categoryposts.post_id');
                });
                if(!empty($request->get('author')))
                {
                    $listss->where('posts.author', $request->get('author'));
                }
                if(!empty($request->get('category')))
                {
                    $listss->where('categoryposts.category_id', $request->get('category'));
                }
                if(!empty($request->get('query')))
                {
                    $listss->where(function($kueri) use ($request){
                        $kueri->where('posts.title', 'like', '%'.strip_tags($request->get('query')).'%')
                            ->orWhere('posts.slug', 'like', '%'.strip_tags($request->get('query')).'%')
                            ->orWhere('posts.excerpt', 'like', '%'.strip_tags($request->get('query')).'%')
                            ->orWhere('posts.content', 'like', '%'.strip_tags($request->get('query')).'%');
                    });
                }
                $lists = $listss->orderBy('posts.id', 'DESC')->paginate(10);
                $categories = Category::orderBy('name', 'ASC')->get();
                $users = User::orderBy('name', 'ASC')->get();
                foreach($lists as $key=>$list)
                {
                    $lists[$key]->kategori = Category::where('id', $list->category_id)->first()->name;
                }
                $quer = [
                    'lists' => $lists,
                    'categories' => $categories,
                    'users' =>$users
                ];
                return view('web.'.$this->folder.'.list', $quer);
            }else{
                return redirect()->route('post.index');
            }
        }else{
            return view('welcome');
        }
    }
    public function create()
    {
        if (isAdmin()){
            $categories = Category::orderBy('name', 'ASC')->get();
            $quer = [
                'categories' => $categories
            ];
            return view('web.'.$this->folder.'.create', $quer);
        }else{
            return view('welcome');
        }
    }
    public function store(Request $request)
    {
        $request->validate([
                'title' => 'required|unique:posts',
                'category' => 'required',
                'content' => 'required',
                'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'title.required' => 'Judul tidak boleh kosong',
                'title.unique' => 'Judul sudah digunakan',
                'content.required' => 'Konten tidak boleh kosong',
                'category.required' => 'Pilih salah satu kategori',
                'thumbnail.image' => 'Mohon unggah berkas gambar saja',
                'thumbnail.mimes' => 'Format Thumbnail tidak didukung',
                'thumbnail.max' => 'Ukuran Thumbnail terlalu besar'
            ]
        );
        $quer = new Kueri();
        $titel = htmlspecialchars(strip_tags($request->get('title')));
        $dsave = [
            'author' => Auth::id(),
            'title' => $titel,
            'slug' => Str::slug($titel, '-'),
            'keyword' => $request->get('keyword'),
            'excerpt' => $request->get('excerpt'),
            'content' => $request->get('content'),
            'comment' => $request->get('comment'),
            'status' => $request->get('status'),
        ];
        $save = $quer->create($dsave);
        if($save)
        {
            $id = $save->id;
            $saveCategori = new Categorypost();
            $saveCategori->post_id = $id;
            $saveCategori->category_id = $request->get('category');
            $saveCategori->save();

            $detail = $request->get('content');
            $dom = new \DomDocument();    
            @$dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
            $images = $dom->getElementsByTagName('img');
            foreach($images as $k => $img){
    
                $src = $img->getAttribute('src');
                
                if(preg_match('/data:image/', $src)){
                    preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                    $mimetype = $groups['mime'];
                    $filename = uniqid();
                    $filepath = 'pablik/artikel/'.$id.'/'.$filename.'.'.$mimetype;
                    $path = public_path('pablik/artikel/'.$id);
                    File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                    $image = Image::make($src)
                        ->encode($mimetype, 100)
                        ->save(public_path($filepath));

                    $new_src = secure_asset($filepath);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $new_src);
                } 
            }    
            $details = $dom->saveHTML();
            $quer2 = Kueri::findOrFail($id);
            $quer2->content = $details;

            if($request->hasFile('thumbnail'))
            {
                $thumb = Str::slug($titel, '-').time().'.'.$request->thumbnail->extension();
                $path = public_path('pablik/artikel/'.$id);
                File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                //$request->thumbnail->move($path, $thumb);
    
                $img = Image::make($request->thumbnail)->encode($request->thumbnail->extension(), 100);
                $img->crop(500, 500)->save($path.'/'.$thumb);
    
                $quer2->thumbnail = 'pablik/artikel/'.$id.'/'.$thumb;
            }
            $quer2->save();
        }
        $msg = '<div class="alert alert-success fade show"><p class="mb-0">Artikel baru ditambahkan!</p></div>';
        return redirect()->route('post.index')->with('msg', $msg);
    }
    public function edit($id)
    {
        if (isAdmin()){
            $row = Kueri::findOrFail($id);
            $categories = Category::orderBy('name', 'ASC')->get();
            $quer = [
                'row' => $row,
                'categories' => $categories
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
                'category' => 'required',
                'content' => 'required',
                'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'title.required' => 'Judul tidak boleh kosong',
                'title.unique' => 'Judul sudah digunakan',
                'content.required' => 'Konten tidak boleh kosong',
                'category.required' => 'Pilih salah satu kategori',
                'thumbnail.image' => 'Mohon unggah berkas gambar saja',
                'thumbnail.mimes' => 'Format Thumbnail tidak didukung',
                'thumbnail.max' => 'Ukuran Thumbnail terlalu besar'
            ]
        );
        $quer = Kueri::findOrFail($id);
        $detil = $request->get('content');
        if(strcmp($request->get('content'), $quer->content) !== 0)
        {
            $detail = $request->get('content');
            $dom = new \DomDocument();    
            @$dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
            $images = $dom->getElementsByTagName('img');
            foreach($images as $k => $img){
    
                $src = $img->getAttribute('src');
                
                if(preg_match('/data:image/', $src)){
                    preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                    $mimetype = $groups['mime'];
                    $filename = uniqid();
                    $filepath = 'pablik/artikel/'.$id.'/'.$filename.'.'.$mimetype;
                    $path = public_path('pablik/artikel/'.$id);
                    File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

                    $image = Image::make($src)
                        ->encode($mimetype, 100)
                        ->save(public_path($filepath));

                    $new_src = secure_asset($filepath);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $new_src);
                } 
            } 
            $detil = $dom->saveHTML();
        }
        $titel = htmlspecialchars(strip_tags($request->get('title')));
        if($request->get('title') !== $quer->title)
        {
            $quer->title = $titel;
            $quer->slug = Str::slug($titel, '-');
        }
        
        $quer->keyword = $request->get('keyword');
        $quer->excerpt = $request->get('excerpt');
        if(strcmp($request->get('content'), $quer->content) !== 0)
        {
            $quer->content = $detil;
        }
        $quer->comment = $request->get('comment');
        $quer->status = $request->get('status');
        
        if($request->hasFile('thumbnail'))
        {
            $thumb = Str::slug($titel, '-').time().'.'.$request->thumbnail->extension();
            $path = public_path('pablik/artikel/'.$id);
            File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
            //$request->thumbnail->move($path, $thumb);

            $img = Image::make($request->thumbnail)->encode($request->thumbnail->extension(), 100);
            $img->crop(500, 500)->save($path.'/'.$thumb);

            $quer->thumbnail = 'pablik/artikel/'.$id.'/'.$thumb;
        }
        $quer->save();
        
        $catarr = [
            'category_id' => $request->get('category')
        ];
        $saveCategori = Categorypost::where('post_id', $id);
        $saveCategori->update($catarr);
        
        $msg = '<div class="alert alert-success fade show"><p class="mb-0">Sukses Update artikel!</p></div>';
        return redirect()->route('post.index')->with('msg', $msg);
    }
    public function destroy($id)
    {
        $quer = Kueri::findOrFail($id);
        $path = public_path('pablik/artikel/'.$id);
        if(File::isDirectory($path))
        {
            File::deleteDirectory($path);
        }
        $quer->delete();

        $saveCategori = Categorypost::where('post_id', $id);
        $saveCategori->delete();
        $msg = '<div class="alert alert-success fade show"><p class="mb-0">Sukses menghapus artikel!</p></div>';
        return redirect()->route('post.index')->with('msg', $msg);
    }
    public function deletemass(Request $request)
    {
        $ids = $request->get('ids');
        $arr = explode(",", $ids);
        foreach($arr as $key=>$val)
        {
            $path = public_path('pablik/artikel/'.$val);
            if(File::isDirectory($path))
            {
                File::deleteDirectory($path);
            }
        }
        Kueri::whereIn('id', explode(",", $ids))->delete();
        
        $saveCategori = Categorypost::whereIn('post_id', explode(",", $ids));
        $saveCategori->delete();
        $msg = '<div class="alert alert-success fade show"><p class="mb-0">Sukses menghapus artikel!</p></div>';
        return redirect()->route('post.index')->with('msg', $msg);
    }
}
