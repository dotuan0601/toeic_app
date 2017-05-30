<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberClasses;
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
}
