<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamKit extends Model
{

    protected $table = 'exam_kits';

    public function getListening() {
        $listening = Exam::where('exam_kit_id', '=', $this->id)
            ->where('content_audio', '!=', '')
            ->get();

        return $listening;
    }

    public function getReading() {
        $reading = Exam::where('exam_kit_id', '=', $this->id)
            ->where('content_audio', '=', null)
            ->get();

        return $reading;
    }
}
