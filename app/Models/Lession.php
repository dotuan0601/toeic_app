<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lession extends Model
{
    public function getListExercises() {
        $list_exercises = Exercise::select('id')->where('lession_id', '=', $this->id)->get();

        return $list_exercises;
    }

//    public function formatDate() {
//        $date = new \DateTime($this->lession_date);
//        return $date->format('Y-m-d');
//    }
}
