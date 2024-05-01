<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function get_users_by_class_id($id){
        return User::where('class_id', $id)->orderBy('name', "DESC")->get();
    }

    public function get_applicants(){
        return User::where('class_id', null)->latest()->get();
    }

    public function get_user_by_id($id){
        return User::find($id);
    }

    public function delete_user($id){
        User::where('id', $id)->delete();
    }
}
