<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lession;
use App\Models\Member;
use App\Models\MemberClasses;
use App\Models\NewWords;
use App\Models\ToeicClasses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToeicClassesController extends Controller
{

	public function __construct()
	{

	}

    public function getFullClass(Request $request) {
        $id_class = $request->get('idClass');
        if (!$id_class) {
            return response()->json([
                'error' => 'not found id'
            ], 200);
        }

        $class_info = ToeicClasses::where('id', '=', intval($id_class))->first();

        $member_classes = MemberClasses::where('class_id', '=', intval($id_class))->get();
        $members = [];
        if (count($member_classes) > 0) {
            foreach ($member_classes as $m) {
                $member = Member::where('id', '=', $m['member_id'])->first();
                if ($member) {
                    $members[] = [
                        'id' => $member['id'],
                        'name' => $member['name'],
                        'dob' => $member['dob'],
                        'description' => $member['description'],
                        'image' => $member['avatar'],
                    ];
                }

            }
        }

        return response()->json([
            'idClass' => $class_info['id'],
            'level' => $class_info['level'],
            'message' => [],
            'member' => $members
        ], 200);
    }

    public function getMembersOnline(Request $request) {
        $id_class = $request->get('idClass');
        if (!$id_class) {
            return response()->json([
                'error' => 'not found id'
            ], 200);
        }

        $class_info = ToeicClasses::where('id', '=', intval($id_class))->first();

        $member_classes = MemberClasses::where('class_id', '=', intval($id_class))->get();
        $members = [];
        if (count($member_classes) > 0) {
            foreach ($member_classes as $m) {
                $member = Member::where('id', '=', $m['member_id'])
                    ->where('is_online', '=', 1)
                    ->first();
                if ($member) {
                    $members[] = [
                        'id' => $member['id'],
                        'name' => $member['name'],
                        'dob' => $member['dob'],
                        'description' => $member['description'],
                        'image' => $member['avatar'],
                    ];
                }
            }
        }

        return response()->json([
            'idClass' => $class_info['id'],
            'level' => $class_info['level'],
            'message' => [],
            'member' => $members
        ], 200);
    }


    public function beforeStart(Request $request) {
        $id_class = $request->get('idClass');

        $response_arr = [];
        $member_classed = MemberClasses::where('class_id', '=' , $id_class)->get();
        if (count($member_classed) > 0) {
            foreach ($member_classed as $member) {
                $response_arr[] = [
                    'id' => $member['id'],
                    'image' => $member['avatar']
                ];
            }
        }

        return response()->json($response_arr);
    }


    public function previousLession(Request $request) {
        $id_class = $request->get('idClass');
        $day = $request->get('day');

        $toeic_class = ToeicClasses::where('id', '=', $id_class)->first();
        $lession = Lession::where('level_name', '=', $toeic_class['level'])
            ->where('lession_date', '=',  $day)->first();

        $response_arr = ['content' => ''];
        if ($lession) {
            $response_arr['content'] = $lession['note'];
        }

        return response()->json($response_arr);
    }


    public function newWords(Request $request) {
        $id_class = $request->get('idClass');
        $day = $request->get('day');

        $toeic_class = ToeicClasses::where('id', '=', $id_class)->first();
        $lession = Lession::where('level_name', '=', $toeic_class['level'])
            ->where('lession_date', '=',  $day)->first();

        $response_arr = ['description' => 'Hãy học từ mới để có thể làm tốt các bài tập trong ngày hôm nay',
            'array_new_words' => []];
        if ($lession) {
            $new_words = NewWords::where('lession_id', '=', $lession['id'])->get();
            if (count($new_words) > 0) {
                foreach ($new_words as $new_word) {
                    $response_arr['array_new_words'][] = [
                        'id' => $new_word['id'],
                        'name' => $new_word['name'],
                        'spelling' => $new_word['spelling'],
                        'meaning' => $new_word['meaning'],
                        'content_image' => $new_word['content_image'],
                        'content_audio' => $new_word['content_audio']
                    ];
                }
            }
        }

        return response()->json($response_arr);
    }


    public function checkClassStarted(Request $request) {
        $id_class = $request->get('idClass');
        $toeic_class = ToeicClasses::where('id', '=', $id_class)->first();
        if ($toeic_class) {
            $number_members = $toeic_class['number_members'];
            $is_started = false;
            if ($number_members >= ToeicClasses::getLimitMembers()) {
                $is_started = true;
            }
            $response_arr = [
                'number_members' => $number_members,
                'is_started' => $is_started
            ];
        }
        else {
            $response_arr = [
                'error_msg' => 'Not found class'
            ];
        }


        return response()->json($response_arr);
    }
}
