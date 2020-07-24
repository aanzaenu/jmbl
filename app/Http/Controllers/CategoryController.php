<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Category as Kueri;
use App\Categorypost;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->folder = 'category';
    }
    public function index()
    {
        if (isAdmin()){
            $lists = Kueri::latest()->paginate(10);
            $quer = [
                'lists' => $lists
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
                $lists = Kueri::where('name', 'like', '%'.strip_tags($request->get('query')).'%')
                            ->orWhere('description', 'like', '%'.strip_tags($request->get('query')).'%')
                            ->orderBy('id', 'DESC')
                            ->paginate(10);
                $quer = [
                    'lists' => $lists
                ];
                return view('web.'.$this->folder.'.list', $quer);
            }else{
                return redirect()->route('rubrik.index');
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
                'name' => 'required|unique:categories',
            ],
            [
                'name.required' => 'Nama tidak boleh kosong'
            ]
        );
        $quer = new Kueri();
        $nam = htmlspecialchars(strip_tags($request->get('name')));
        $dsave = [
            'name' => $nam,
            'slug' => Str::slug($nam, '-'),
            'description' => strip_tags($request->get('description')),
        ];
        $quer->create($dsave);
        $msg = '<div class="alert alert-success fade show"><p class="mb-0">Rubrik baru ditambahkan!</p></div>';
        return redirect()->route('rubrik.index')->with('msg', $msg);
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
                'name' => 'required'
            ],
            [
                'name.required' => 'Nama tidak boleh kosong'
            ]
        );
        $quer = Kueri::findOrFail($id);
        $quer->name = $request->get('name');
        $quer->slug = Str::slug($request->get('name'), '-');
        $quer->description = $request->get('description');
        $quer->save();
        $msg = '<div class="alert alert-success fade show"><p class="mb-0">Sukses Update Rubrik!</p></div>';
        return redirect()->route('rubrik.index')->with('msg', $msg);
    }
    public function destroy($id)
    {
        if($id == 1)
        {            
            $msg = '<div class="alert alert-danger fade show"><p class="mb-0">Jangan dihapus yang satu ini!</p></div>';
            return redirect()->route('rubrik.index')->with('msg', $msg);
        }else{
            $quer = Kueri::findOrFail($id);
            $quer->delete();
            $catpos = CategoryPost::where('category_id', $id)->count();
            if($catpos > 0)
            {
                CategoryPost::where('category_id', $id)->update(['category_id' => 1]);
            }
            $msg = '<div class="alert alert-success fade show"><p class="mb-0">Sukses menghapus Rubrik!</p></div>';
            return redirect()->route('rubrik.index')->with('msg', $msg);
        }
    }
    public function deletemass(Request $request)
    {
        $ids = $request->get('ids');
        $arr = explode(",", $ids);
        if(in_array('1', $arr))
        {            
            $msg = '<div class="alert alert-danger fade show"><p class="mb-0">Akses ditolak!</p></div>';
            return redirect()->route('category.index')->with('msg', $msg);
        }else{
            foreach($arr as $key=>$val)
            {
                if(CategoryPost::where('category_id', $val)->count() > 0){
                    CategoryPost::where('category_id', $val)->update(['category_id' => 1]);
                }
            }
            Kueri::whereIn('id', explode(",", $ids))->delete();
            
            $msg = '<div class="alert alert-success fade show"><p class="mb-0">Sukses menghapus Rubrik!</p></div>';
            return redirect()->route('rubrik.index')->with('msg', $msg);
        }
    }
}
