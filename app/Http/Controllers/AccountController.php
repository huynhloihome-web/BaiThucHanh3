<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // Hiển thị trang account
    public function accountpanel()
    {
        $user = DB::table("users")
            ->where("id", Auth::user()->id)
            ->first();

        return view("vidusach.account", compact("user"));
    }

    // Lưu thông tin
    public function saveaccountinfo(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string'],
            'photo' => ['nullable', 'image']
        ]);

        $id = $request->input('id');

        $data = [
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone
        ];

        // Upload ảnh
        if ($request->hasFile('photo')) {
            $fileName = Auth::user()->id . '.' . $request->file('photo')->extension();
            $request->file('photo')->storeAs('public/profile', $fileName);
            $data['photo'] = $fileName;
        }

        DB::table("users")->where("id", $id)->update($data);

        return redirect()->route('account')->with('status', 'Cập nhật thành công');
    }
}