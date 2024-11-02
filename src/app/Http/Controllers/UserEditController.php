<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\UserEditRequest;

class UserEditController extends Controller
{
    public function edit()
{
    $user = auth()->user();
    return view('user_edit', compact('user'));
}

public function update(UserEditRequest $request)
{
    $validatedData = $request->validated();

    $user = auth()->user();
    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('current_password') && $request->filled('new_password')) {
        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
        } else {
            return back()->withErrors(['current_password' => '現在のパスワードが違います']);
        }
    }

    if ($request->hasFile('profile_image')) {
        $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        $user->profile_image = $imagePath;
    }

    $user->save();

    return back()->with('success', 'プロフィール情報を更新しました');
}

}
