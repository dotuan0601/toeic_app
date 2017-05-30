<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToeicClasses extends Model
{

    protected $table = 'toeic_classes';

    public static function getLimitMembers() {
        $config_limit = SystemConfig::where('key', '=', config('number_member_of_class'))->first();
        if (!$config_limit) {
            return 6;
        }
        else return intval($config_limit['value']);
    }
}
