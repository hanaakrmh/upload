<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Settingapp;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $username = $request->query('username');
        
        $users = User::when($username, function ($query, $username) {
            return $query->where('username', 'like', '%' . $username . '%');
        })->paginate(10); // Set jumlah item per halaman
        
        return view('admin.managementuser', compact('users'));
    }

    public function adduser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);


        $user = User::create([
            'username' => $request->username,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'realpassword' => $request->password,
        ]);

        return redirect()->route('admin.index');
    }

    public function deleteuser(Request $request)
    {
        $request->validate([
            'userId' => 'required',
        ]);


        $user = User::find($request->userId);
        $user->delete();

        return redirect()->route('admin.index');
    }

    public function updateuser(Request $request)
    {
        $request->validate([
            'userId' => 'required',
            'username' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);

        $user = User::find($request->userId);
        $user->username = $request->username;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->realpassword = $request->password;
        $user->save();

        return redirect()->route('admin.index');
    }

    public function settingapp(Request $request)
    {

        $aplikasi = $request->query('name');
        
        $settingapp = Settingapp::when($aplikasi, function ($query, $aplikasi) {
            return $query->where('name', 'like', '%' . $aplikasi . '%');
        })->paginate(8); // Set jumlah item per halaman
        
        return view('admin.settingapp', compact('settingapp'));
    }

    public function addsettingapp(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'link' => 'required',
        ]);
    
        $originalIconName = $request->file('icon')->getClientOriginalName();

        // Menyimpan ikon ke storage
        $iconPath = $request->file('icon')->storeAs('public/icons', $originalIconName); // Menyimpan dengan nama asli file
    
        // Membuat record Settingapp
        $settingapp = Settingapp::create([
            'name' => $request->name,
            'icon' => $originalIconName, // Menyimpan path file ke database
            'link' => $request->link,
        ]);
    
        return redirect()->route('admin.settingapp');
    }    

    public function deletesettingapp(Request $request)
    {
        $request->validate([
            'appId' => 'required',
        ]);

        $settingapp = Settingapp::find($request->appId);
        $settingapp->delete();

        return redirect()->route('admin.settingapp');
    }

    public function updateApp(Request $request)
    {
        $request->validate([
            'appId' => 'required',
            'name' => 'required',
            'icon' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'link' => 'required',
        ]);

        $settingapp = Settingapp::find($request->appId);

        if($request->file('icon') == null){
            $settingapp->icon = $settingapp->icon;
        }else{
            $originalIconName = $request->file('icon')->getClientOriginalName();
            $iconPath = $request->file('icon')->storeAs('public/icons', $originalIconName);
            $settingapp->icon = $originalIconName;
        }

        $settingapp->name = $request->name;
        $settingapp->link = $request->link;
        $settingapp->save();

        return redirect()->route('admin.settingapp');

    }
    
}
