<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $user = User::where('is_deleted', '0')->get();

        return view('users.index', [
            'user' => $user,
            'jabatans' => Jabatan::all()
        ]);

    }

    public function show(Request $request, $id_users){
        $user = User::where('id_users',$id_users)->where('is_deleted', '0')->get()[0];
        return view('users.show', [
            'user' => $user,
        ]);
    }
    
    public function create()
    {
        return view(
            'users.create', [
            'jabatan' => Jabatan::all()
        ]);
    }

    public function store(Request $request){
         //Menyimpan Data pegawai
        $request->validate([
            'nama_pegawai' => 'required',
            'email' => 'required',
            'password' => 'required',
            'level' => 'required',
            'id_jabatan' => 'required'
        ]);

        $array = $request->only([
            'nama_pegawai',
            'email' ,
            'password' ,
            'level' ,
            'id_jabatan',
        ]);

        $array['_password_'] = $request->password;

        $user = User::create($array);

        return redirect()->route('user.index')->with([
            'success_message' => 'Data telah tersimpan',
        ]);
    }

    public function edit($id_users){
        //Menampilkan Form Edit
        $user = User::find($id_users);
        if (!$user) return redirect()->route('user.index')->with('error_message', 'User dengan id'.$id_users.' tidak ditemukan');
        return view('users.edit', [
            'user' => $user,
            'jabatan' => Jabatan::all()
        ]); 
    }

    public function update(Request $request, $id_users){
        //Mengedit Data User
        $request->validate([
            'nama_pegawai' => 'required',
            'email' => 'required',
            'password' => 'required',
            'level' => 'required',
             'id_jabatan' => 'required',
        ]);
        $user = User::find($id_users);
        $user->nama_pegawai = $request->nama_pegawai;
        $user->email = $request->email;
        if ($request->password) $user->password = bcrypt($request->password);
        $user->level = $request->level;
        $user->id_jabatan = $request->id_jabatan;
        $user->save();
        return redirect()->route('user.index') ->with([
        'success_message' => 'Data telah tersimpan',
        ]);
    }

    public function destroy($id_users){
        $user = User::find($id_users);
        if ($user) {
            $user->is_deleted = '1';
            $user->email = rand() . '_' . $user->email;
            $user->save();
        }
        return redirect()->route('user.index') ->with([
            'success_message' => 'Data telah terhapus',
        ]);
    }
}