<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function showChangePasswordForm()
    {
        $user = auth()->user();
        return view('auth.userprofile')->with(['user' => $user]);
    }

    public function setUserImage(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'image' => ['required','regex:/^(https?:\/\/.*\.(?:png|jpg|jpeg))/']
        ]);

        if ($validator->fails()) {
            return $validator;
        }
        
        $user = Auth::user();
        $user->image = $request->get('image');
        $user->save();
        return "Success";
    }

    public function setUserNameAndEmail(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'userName' => ['required','regex:/^(https?:\/\/.*\.(?:png|jpg|jpeg))/'],
            'userEmail' => ['reqired', 'email:rfc,dns','unique:App\User,email']
        ]);

        if ($validator->fails()) {
            return $validator;
        }
        
        $user = Auth::user();
        $user->name = $request->get('userName');
        $user->email = $request->get('userEmail');
        $user->save();
        return "Success";
    }

    public function changePassword(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","รหัสผ่านปัจจุบันของคุณไม่ตรงกับรหัสผ่านที่คุณระบุ กรุณาลองอีกครั้ง");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","รหัสผ่านใหม่เหมือนกับรหัสผ่านก่อนหน้านี้ กรุณาเลือกรหัสผ่านอื่น");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","เปลี่ยนรหัสผ่านสำเร็จแล้ว");
    }
}