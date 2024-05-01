<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\User;
use App\Repositories\ActionRepository;
use App\Repositories\AdminRepository;
use App\Repositories\ClassesRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct(
        protected AdminRepository $adminRepository,
        protected ClassesRepository $classesRepository,
        protected UserRepository $userRepository,
        protected DistrictRepository $districtRepository,
        protected ActionRepository $actionRepository,
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
        $users = $this->userRepository->get_users_by_class_id($id);
        return view('admin.users', ['users' => $users, 'current_class' => $cl]);
    }

    public function getDownload($doc)
    {
        //PDF file is stored under project/public/download/info.pdf
        $file= public_path(). "/img/documents/".$doc;

        $headers = array(
            'Content-Type: application/pdf',
        );

        return response()->download($file, 'buyruq.pdf', $headers);
    }



    public function applicants(){
        $users = $this->userRepository->get_applicants();
        return view('admin.applicants', ['users' => $users]);
    }

    public function user($id){
        $user = $this->userRepository->get_user_by_id($id);
        $cl = $this->classesRepository->all_classes();
        $ac = $this->actionRepository->get_all_actions($id);
        return view('admin.student', ['student' => $user, 'classes' => $cl, 'actions' => $ac]);
    }

    public function action(Request $request){
        $request->validate([
            'user_id' => "required|numeric",
            'class_id' => "required|numeric",
            'type_id' => "required|numeric",
            'school' => "required|string",
            'school_address' => "required|string",
            'country' => "required|string",
//            'document' => "required|file",
            'document_number' => "required|string",
            'date' => "required|date",
            'comment' => "required|string",
        ]);
        $file = $request->file('document')->extension();
        $name = md5(microtime());
        $document_name = $name.".".$file;
        $path = $request->file('document')->move('img/documents/',$document_name);
        $action = new Action;
        $action->user_id = $request->user_id;
        $action->type_id = $request->type_id;
        $action->date = $request->date;
        $action->class_id = $request->class_id;
        $action->document = $document_name;
        $action->document_number = $request->document_number;
        $action->school = $request->school;
        $action->school_address = $request->school_address;
        $action->country = $request->country;
        $action->comment = $request->comment;
        $action->save();
        $this->userRepository->update_class_id($request->user_id, $request->class_id);
        return redirect()->back()->with('success', 1);
    }

    public function delete_user($id){
        $user = $this->userRepository->get_user_by_id($id);
        if ($user->photo != "no_photo") unlink('img/users/'.$user->photo);
        $this->userRepository->delete_user($id);
        return back();
    }

//    User control
    public function add_user(Request $request){
//        return $request;
        $validatedData = $request->validate([
            'name' => 'required|string',
            'birthday' => 'required|date',
//            'photo' => 'required|image|mimes:jpeg,png,jpg,gif',
            'passport' => 'required|string',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'parents_passport' => 'required|string',
            'father_phone' => 'required|string',
            'mother_phone' => 'required|string',
            'region_id' => 'required|numeric',
            'district_id' => 'required|numeric',
            'quarter_id' => 'required|numeric',
            'address' => 'required|string',
        ]);
        $photo_name = "no_photo";
        if ($request->hasFile('photo')){
            $file = $request->file('photo')->extension();
            $name = md5(microtime());
            $photo_name = $name.".".$file;
            $path = $request->file('photo')->move('img/users/',$photo_name);
        }
        if (!empty($request->mahalla)){
            $quarter_id = DB::table('quarters')->insertGetId([
                'district_id' => $request->district_id,
                'name' => $request->mahalla
            ]);
        }
        else{
            $quarter_id = $request->quarter_id;
        }
        $user = new User;
        $user->name = $request->name;
        $user->birthday = $request->birthday;
        $user->photo = $photo_name;
        $user->passport = $request->passport;
        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        $user->parents_passport = $request->parents_passport;
        $user->parents_number1 = $request->father_phone;
        $user->parents_number2 = $request->mother_phone;
        $user->region_id = $request->region_id;
        $user->district_id = $request->district_id;
        $user->quarter_id = $quarter_id;
        $user->address = $request->address;
        $user->save();
        return back()->with('success',1);
    }











    //    Region control
    public function districts($region_id){
        return $this->districtRepository->districts($region_id);
    }

    public function quarters($district_id){
        return $this->districtRepository->quarters($district_id);
    }
}
