<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::where('is_deletd', '0')->get();
    return view('users.index', [
    'user' => $user
    ]);
    }
    
    public function create(){

        return view(
            'users.create', );
        }
        
    public function store(Request $request){
        //Menyimpan Data user
        $request->validate([
        'nama_pegawai' => 'required',
        'email' => 'required',
        'password' => 'required|confirmed',
        'level' => 'required',
      
       
        ]);
        $array = $request->only([
            'nama_pegawai',
            'email',
            'password',
            'level'
       
        
        ]);
        $user=User::create($array);
        return redirect()->route('users.index') ->with('success_message', 'Berhasil menambah user baru');
        
    }

    public function destroy($id)
    {
        $user = User::find($id);
    
        if ($user) {
            $user->is_deletd = '1';
            $user->save();
        }
    
        return redirect()->route('user.index')->with('success_message', 'Berhasil menghapus kategori wisata');
    }
   
    
    
    
    
    
    
    
}