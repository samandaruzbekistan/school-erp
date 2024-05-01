<?php

namespace App\Repositories;

use App\Models\Action;

class ActionRepository
{
    public function add_class($user_id, $class_id, $action_id, $date, $document, $document_number,$school, $school_address, $country, $comment){
        $action = new Action;
        $action->user_id = $user_id;
        $action->type_id = $action_id;
        $action->date = $date;
        $action->class_id = $class_id;
        $action->document = $document;
        $action->document_number = $document_number;
        $action->school = $school;
        $action->school_address = $school_address;
        $action->country = $country;
        $action->comment = $comment;
        $action->save();
    }

    public function get_all_actions($user_id){
        return Action::where('user_id', $user_id)->get();
    }
}
