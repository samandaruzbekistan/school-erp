<?php

namespace App\Repositories;

use App\Models\Classes;

class ClassesRepository
{
    public function all_classes(){
        $classes = Classes::all();
        return $classes;
    }

    public function get_class_by_name($name){
        $classes = Classes::where('name', $name)->first();
        return $classes;
    }

    public function add_class($name, $level){
        $cl = new Classes;
        $cl->level = $level;
        $cl->name = $name;
        $cl->save();
    }

}
