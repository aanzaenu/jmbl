<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User as Kueri;
use App\Group;
use App\UserGroup;
use Illuminate\Support\Facades\Hash;

class UserlistsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->folder = 'userlist';
    }
    public function index()
    {
        if (isAdmin()){
            $listss = Kueri::join('user_groups', function($join){
                $join->on('users.id', '=','user_groups.user_id');
            });
            $lists = $listss->orderBy('users.name', 'ASC')->paginate(10);
            foreach($lists as $key=>$list)
            {
                $lists[$key]->role = Group::where('id', $list->group_id)->first()->name;
            }
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
                $listss = Kueri::join('user_groups', function($join){
                    $join->on('users.id', '=','user_groups.user_id');
                });
                $listss->where('users.name', 'like', '%'.strip_tags($request->get('query')).'%')
                            ->orWhere('users.email', 'like', '%'.strip_tags($request->get('query')).'%');
                $lists = $listss->orderBy('users.name', 'ASC')->paginate(10);   
                foreach($lists as $key=>$list)
                {
                    $lists[$key]->role = Group::where('id', $list->group_id)->first()->name;
                }                         
                $quer = [
                    'lists' => $lists
                ];
                return view('web.'.$this->folder.'.list', $quer);
            }else{
                return redirect()->route('userlist.index');
            }
        }else{
            return view('welcome');
        }
    }
    public function create()
    {
        if (isAdmin()){
            $groups = Group::orderBy('name', 'ASC')->get();
            $quer = [
                'groups' => $groups
            ];
            return view('web.'.$this->folder.'.create', $quer);
        }else{
            return view('welcome');
        }
    }
    public function store(Request $request)
    {
        $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'min:8', 'confirmed'],
                'password_confirmation' => ['required'],
            ],
            [
                'name.required' => 'Nama tidak boleh kosong',
                'name.max' => 'Panjang Nama maksimal 255 karakter',
                'email.required' => 'Email tidak boleh kosong',
                'email.email' => 'Email tidak valid',
                'email.max' => 'Panjang Email maksimal 255 karakter',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password tidak boleh kosong',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Password tidak cocok',
                'password_confirmation.required' => 'Konfirmasi Passowrd tidak boleh kosong',
            ]
        );
        $quer = new Kueri();
        $dsave = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ];
        $save = $quer->create($dsave);
        if($save)
        {
            $id = $save->id;
            $saveGrp = new UserGroup();
            $saveGrp->user_id = $id;
            $saveGrp->group_id = $request->get('group');
            $saveGrp->save();
        }
        $msg = '<div class="alert alert-success fade show"><p class="mb-0">User baru ditambahkan!</p></div>';
        return redirect()->route('userlist.index')->with('msg', $msg);
    }
    public function edit($id)
    {
        if (isAdmin()){
            if(Auth::id() == $id)
            {
                $msg = '<div class="alert alert-danger fade show"><p class="mb-0">Akses ditolak!</p></div>';
                return redirect()->route('userlist.index')->with('msg', $msg);
            }else{
                $row = Kueri::findOrFail($id);
                $groups = Group::orderBy('name', 'ASC')->get();
                $quer = [
                    'row' => $row,
                    'groups' => $groups
                ];
                return view('web.'.$this->folder.'.edit', $quer);
            }
        }else{
            return view('welcome');
        }
    }
    public function update(Request $request, $id)
    {
        if(!empty($request->get('password')))
        {
            $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$id.',id'],
                    'password' => ['required', 'min:8', 'confirmed'],
                    'password_confirmation' => ['required'],
                ],
                [
                    'name.required' => 'Nama tidak boleh kosong',
                    'name.max' => 'Panjang Nama maksimal 255 karakter',
                    'email.required' => 'Email tidak boleh kosong',
                    'email.email' => 'Email tidak valid',
                    'email.max' => 'Panjang Email maksimal 255 karakter',
                    'email.unique' => 'Email sudah terdaftar',
                    'password.required' => 'Password tidak boleh kosong',
                    'password.min' => 'Password minimal 8 karakter',
                    'password.confirmed' => 'Password tidak cocok',
                    'password_confirmation.required' => 'Konfirmasi Passowrd tidak boleh kosong',
                ]
            );
        }else{
            $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$id.',id'],
                ],
                [
                    'name.required' => 'Nama tidak boleh kosong',
                    'name.max' => 'Panjang Nama maksimal 255 karakter',
                    'email.required' => 'Email tidak boleh kosong',
                    'email.email' => 'Email tidak valid',
                    'email.max' => 'Panjang Email maksimal 255 karakter',
                    'email.unique' => 'Email sudah terdaftar',
                ]
            );
        }
        $quer = Kueri::findOrFail($id);
        $quer->name = $request->get('name');
        $quer->email = $request->get('email');
        if(!empty($request->get('password')))
        {
            $quer->password = Hash::make($request->get('password'));
        }
        $quer->save();
        
        $grarr = [
            'group_id' => $request->get('group')
        ];
        $saveGrp = UserGroup::where('user_id', $grarr);
        $saveGrp->update($grarr);
        $msg = '<div class="alert alert-success fade show"><p class="mb-0">Sukses Update User!</p></div>';
        return redirect()->route('userlist.index')->with('msg', $msg);
    }
    public function destroy($id)
    {
        if(Auth::id() == $id){
            $msg = '<div class="alert alert-danger fade show"><p class="mb-0">Akses ditolak!</p></div>';
            return redirect()->route('userlist.index')->with('msg', $msg);
        }else{
            $quer = Kueri::findOrFail($id);
            $quer->delete();

            $saveCategori = UserGroup::where('user_id', $id);
            $saveCategori->delete();
            $msg = '<div class="alert alert-success fade show"><p class="mb-0">Sukses menghapus User!</p></div>';
            return redirect()->route('userlist.index')->with('msg', $msg);
        }
    }
    public function deletemass(Request $request)
    {
        $ids = $request->get('ids');
        if(in_array(Auth::id(), explode(",", $ids)))
        {
            $msg = '<div class="alert alert-danger fade show"><p class="mb-0">Akses ditolak!</p></div>';
            return redirect()->route('userlist.index')->with('msg', $msg);
        }else{
            $arr = explode(",", $ids);
            Kueri::whereIn('id', explode(",", $ids))->delete();
            
            $saveCategori = UserGroup::whereIn('user_id', explode(",", $ids));
            $saveCategori->delete();
            $msg = '<div class="alert alert-success fade show"><p class="mb-0">Sukses menghapus User!</p></div>';
            return redirect()->route('userlist.index')->with('msg', $msg);
        }
    }
}
