<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct(protected AdminRepository $adminRepository)
    {
    }

    public function auth(Request $request){
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $admin = $this->adminRepository->getAdmin($request->username);
        if (!$admin){
            return back()->with('login_error', 1);
        }
        if (Hash::check($request->input('password'), $admin->password)) {
            session()->flush();
            session()->put('admin',1);
            session()->put('name',$admin->fullname);
            session()->put('id',$admin->id);
            session()->put('username',$admin->username);
            return redirect()->route('admin.home');
        }
        else{
            return back()->with('login_error', 1);
        }
    }

    public function profile(){
        $admin = $this->adminRepository->getAdmin(session('username'));
        return view('admin.profile', ['user' => $admin]);
    }

    public function update(Request $request){
        $request->validate([
            'password1' => 'required|string',
            'password2' => 'required|string',
        ]);
        if ($request->input('password1') != $request->input('password2')) return back()->with('password_error',1);
        $this->adminRepository->update_password($request->password1);
        return back()->with('success',1);
    }

    public function logout(){
        session()->flush();
        return redirect()->route('admin.login');
    }
}