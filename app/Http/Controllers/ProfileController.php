<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diambil',
            'data' => $request->user()
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'bio' => 'nullable|string',
            'skill' => 'nullable|string',
            'school' => 'nullable|string|max:255',
        ]);

        $user->update([
            'username' => $request->username,
            'bio' => $request->bio,
            'skill' => $request->skill,
            'school' => $request->school,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $user
        ]);
    }

    //front end profile
    public function webShow()
    {
        $user =\App\Models\User::find(session('user_id'));

        if (!$user) {
            return redirect('/login');
        }

        return view('profile.show', compact('user'));
    }

    //frontend halaman edit profile
    public function webEdit() {
        $user = User::find(session('user_id'));

        if (!$user) {
            abort(404);
        }
        return view('profile.edit', compact('user'));
    }

    //proses update profile
    public function webUpdate(Request $request) {
        $user = User::find(session('user_id'));

        if (!$user) {
            abort(404);
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'bio' => 'nullable|string|max:1000',
            'skill' => 'nullable|string|max:255',
            'school' => 'nullable|string|max:255',
        ]);

        $user->update([
            'username' => $request->username,
            'bio' => $request->bio,
            'skill' => $request->skill,
            'school' => $request->school,
        ]);

        //update session username juga
        session([
            'username' => $user->username
        ]);

        return redirect('/profile')
            ->with('success', 'Profile berhasil diperbarui');
    }
}
