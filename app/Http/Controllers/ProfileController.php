<?php

namespace App\Http\Controllers;

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
}
