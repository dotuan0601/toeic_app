<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    public function getListQuestions() {
        $test_ids = Test::select('id')->where('exercise_id', '=', $this->id)->get();

        return $test_ids;
    }

    public function getLessionInfo() {
        $lession = Lession::where('id', '=', $this->lession_id)->first();

        return $lession;
    }

    public function getFullImage() {
        return public_path('img/exercise/' . $this->content_image);
    }
}
