<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function get_users_by_class_id($id){
        return User::where('class_id', $id)->orderBy('name', "DESC")->get();
    }
}
