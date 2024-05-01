<?php

namespace App\Http\Controllers;

use App\Repositories\AdminRepository;
use App\Repositories\ClassesRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct(
        protected AdminRepository $adminRepository,
        protected ClassesRepository $classesRepository,
        protected UserRepository $userRepository,
        protected DistrictRepository $districtRepository,
    )
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

    public function home(){
        return view('admin.home');
    }

    public function classes(){
        $cl = $this->classesRepository->all_classes();
        return view('admin.classes', ['classes' => $cl]);
    }

    public function classes_new(Request $request){
        $request->validate([
            'name' => 'required|string',
            'level' => 'required|numeric',
        ]);
        $cl = $this->classesRepository->get_class_by_name($request->name);
        if($cl) return redirect()->back();
        $this->classesRepository->add_class($request->name, $request->level);
        return redirect()->back()->with('success',1);
    }

    public function class_users($id){
        $cl = $this->classesRepository->get_class_by_id($id);
        $classes = $this->classesRepository->all_classes();
        $users = $this->userRepository->get_users_by_class_id($id);
        return view('admin.users', ['users' => $users, 'current_class' => $cl, 'classes' => $classes]);
    }












    //    Region control
    public function districts($region_id){
        return $this->districtRepository->districts($region_id);
    }

    public function quarters($district_id){
        return $this->districtRepository->quarters($district_id);
    }
}
