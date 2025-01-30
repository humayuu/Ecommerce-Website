<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    // Function for Redirect Home
    public function index(){
        return view('frontend.index');
    }


    // Function for User Logout
    Public function UserLogout(){
        Auth::logout();

        return redirect()->route('login');
    }

    // Function for Update User Profile
    public function UserProfile(){
        $id = Auth::user()->id;
        $user = User::find($id);

        return view('frontend.profile.user_profile',compact('user'));


    }

    public function UserProfileStore(Request $request){
        $userData = User::find(Auth::user()->id);
        $userData->name = $request->name;
        $userData->email = $request->email;
        $userData->phone = $request->phone;

        if($request->file('profile_photo_path')){
            $file = $request->file('profile_photo_path');
            unlink(public_path('upload/user_images/' . $userData->profile_photo_path));
            $fileName = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $fileName);
            $userData['profile_photo_path'] = $fileName;
        }

        $userData->save();


        $notification = [
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('dashboard')->with($notification);
    }

    // Function for User Change Password
    public function UserChangePassword(){
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('frontend.profile.change_password', compact('user'));
    }

    public function UserPasswordUpdate(Request $request){
        $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hashedPassword = User::find(Auth::user()->id)->password;

        if(Hash::check($request->oldpassword,$hashedPassword)){
            $admin = User::find(Auth::user()->id);
            $admin->password = Hash::make($request->password);
            $admin->save();
            Auth::logout();

            return redirect()->route('user.logout');

        }else{
            return redirect()->back();

        }


    }


}
