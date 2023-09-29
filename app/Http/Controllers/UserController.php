<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\Jabatan;
use App\Models\Profile;
use App\Models\TingkatPendidikan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $user = User::where('is_deleted', '0')->get();

        return view('users.index', [
            'user' => $user,
            'jabatans' => Jabatan::all(),
        ]);
    }

    public function showAdmin(Request $request, $id_users)
    {
        $user = User::where('id_users', $id_users)->first();
        $user_profile = Profile::where('id_users', $id_users)->first();

        $tingkat_pendidikan = TingkatPendidikan::all();

        return view('profile.index', [
            'main_user' => $user,
            'user' => $user_profile,
            'tingkat_pendidikans' => $tingkat_pendidikan,
        ]);
    }

    public function show(Request $request, $id_users)
    {
        $user = User::where('id_users', $id_users)->where('is_deleted', '0')->get()[0];

        return view('users.show', [
            'user' => $user,
        ]);
    }

    public function create()
    {
        return view(
            'users.create', [
                'jabatan' => Jabatan::all(),
            ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_pegawai' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'level' => 'required',
            'id_jabatan' => 'required',
        ];

        $request->validate($rules);

        $array = $request->only([
            'nama_pegawai',
            'email',
            'password',
            'level',
            'id_jabatan',
        ]);

        $array['_password_'] = $request->password;

        $user = User::create($array);

        $array['kode_finger'] = $this->generateUniqueKodeFinger();

        return redirect()->route('user.index')->with([
            'success_message' => 'Data telah tersimpan',
        ]);
    }

        private function generateUniqueKodeFinger()
    {
        $kodeFinger = uniqid();

        while (User::where('kode_finger', $kodeFinger)->exists()) {
            $kodeFinger = uniqid();
        }

        return $kodeFinger;
    }

    public function edit($id_users)
    {
        //Menampilkan Form Edit
        $user = User::find($id_users);
        if (! $user) {
            return redirect()->route('user.index')->with('error_message', 'User dengan id'.$id_users.' tidak ditemukan');
        }

        return view('users.edit', [
            'user' => $user,
            'jabatan' => Jabatan::all(),
        ]);
    }

    public function update(Request $request, $id_users)
    {

        $rules = [
            'nama_pegawai' => 'required',
            'email' => 'required|unique:users,email,'.$id_users.',id_users',
            'level' => 'required',
            'id_jabatan' => 'required',
            'level' => 'required',
        ];

        if (isset($request->password)) {
            $rules['password'] = 'required|confirmed';
        }

        $request->validate($rules);

        $user = User::find($id_users);
        $user->nama_pegawai = $request->nama_pegawai;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->level = $request->level;
        $user->id_jabatan = $request->id_jabatan;
        $user->_password_ = $request->password;
        $user->save();

        return redirect()->route('user.index')->with([
            'success_message' => 'Data telah tersimpan',
        ]);
    }

    public function destroy($id_users)
    {
        $user = User::find($id_users);
        if ($user) {
            $user->is_deleted = '1';
            $user->email = rand().'_'.$user->email;
            $user->save();
        }

        return redirect()->route('user.index')->with([
            'success_message' => 'Data telah terhapus',
        ]);
    }

    public function changePassword(Request $request)
    {
        return view('users.change-pass');
    }

    public function saveChangePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|string|confirmed',
        ]);

        // Get the authenticated user
        $user = auth()->user();

        // Check if the current password matches the user's password in the database
        if (! Hash::check($request->input('old_password'), $user->password)) {
            return back()->withErrors(['old_password' => 'The current password is incorrect.']);
        }

        // Update the user's password
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('user.changePassword')->with('success', 'Password changed successfully.');
    }

    public function import(Request $request)
    {
        Excel::import(new UsersImport, $request->file('file')->store('temp'));

        return redirect()->back()->with([
            'success_message' => 'Data telah Tersimpan',
        ]);
    }
}
