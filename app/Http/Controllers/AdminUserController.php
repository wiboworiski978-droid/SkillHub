<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    //menampilkan semua user
    public function index()
    {
        $users = User::latest()->get();

        return view('admin.users.index', compact('users'));
    }

    //menghapus user
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return back()->withErrors([
                'user' => 'User dengan ID ' . $id . ' tidak ditemukan'
            ]);
        }

        //admin tidak boleh menghapus akun admin sendiri
        if ($user->id === session('user_id')) {
            return back()->withErrors([
                'user' => 'Anda tidak bisa menghapus akun sendiri'
            ]);
        }

        $user->delete();

        return redirect('/admin/users')
            ->with('success', 'user berhasil dihapus');
    }
}
