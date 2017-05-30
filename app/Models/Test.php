<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public function getChoices() {
        return Choice::where('test_id', '=', $this->id)->get();
    }
}
