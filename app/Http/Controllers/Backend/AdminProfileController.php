<?php

namespace App\Http\Controllers\Backend;


use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    // Function to show all data on the Admin Profile Page
    public function AdminProfile(){
        $adminData = Admin::find(1);
        return view('admin.admin_profile_view', compact('adminData'));
    }

    public function AdminProfileEdit(){
        $editData = Admin::find(1);
        return view('admin.admin_profile_edit', compact('editData'));
    }


    public function AdminProfileStore(Request $request){
        $adminData = Admin::find(1);
        $adminData->name = $request->name;
        $adminData->email = $request->email;

        if($request->file('profile_photo_path')){
            $file = $request->file('profile_photo_path');
            // unlink(public_path('upload/admin_images/' . $adminData->profile_photo_path));
            $fileName = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $fileName);
            $adminData['profile_photo_path'] = $fileName;
        }

        $adminData->save();


        $notification = [
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.profile')->with($notification);


    }

    public function AdminChangePassword(){
        return view('admin.admin_change_password');
    }


    public function AdminUpdateChangePassword(Request $request){
        $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hashedPassword = Admin::find(1)->password;

        if(Hash::check($request->oldpassword,$hashedPassword)){
            $admin = Admin::find(1);
            $admin->password = Hash::make($request->password);
            $admin->save();
            Auth::logout();

            return redirect()->route('admin.logout');

        }else{
            return redirect()->back();

        }


    }






}
