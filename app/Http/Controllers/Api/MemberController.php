<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberClasses;
use App\Models\ToeicClasses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{

	public function __construct()
	{

	}

	public function getInfo() {
		return ['fid' => 11111];
	}

    protected function validateFb($id_fb, $email, $name) {
        if (!$id_fb || $id_fb == '') {
            return 'invalid id_fb';
        }

        if (!$email || $email == '') {
            return 'invalid email';
        }

        if (!$name || $name == '') {
            return 'invalid name';
        }

        return false;
    }

    protected function validateGoogle($id_gplus, $email, $name) {
        if (!$id_gplus || $id_gplus == '') {
            return 'invalid id_gplus';
        }

        if (!$email || $email == '') {
            return 'invalid email';
        }

        if (!$name || $name == '') {
            return 'invalid name';
        }

        return false;
    }

    protected function registerSocial($id, $email, $name, $type = 'fb') {
        $member_social = new Member();
        if ($type == 'fb') {
            $member_social->id_fb = $id;
        }
        else {
            $member_social->id_gplus = $id;
        }
        $member_social->name = $name;
        $member_social->email = $email;
        $member_social->level = 'newbie';
        $member_social->created_at = time();
        $member_social->save();

        return $member_social;
    }

    protected function makeClass($member_id, $member_level) {
        $classes = ToeicClasses::where('status', '=', 0)
            ->where('number_members', '<', ToeicClasses::getLimitMembers())
            ->where('level', '=', $member_level)
            ->where('status', '=', 0)
            ->first();

        if (!$classes) {
            $new_classes = new ToeicClasses();
            $new_classes->number_members = 1;
            $new_classes->level = $member_level;
            $new_classes->created_at = date('Y-m-d H:i:s', time());
            $new_classes->save();

            return $new_classes->id;
        }
        else {
            $status = 0;
            $start_date = null;
            if ($classes['number_members'] == ToeicClasses::getLimitMembers() - 1) {
                $status = 1;
                $start_date = date('Y-m-d', strtotime('now') + 24*3600);
            }

            $number_members = $classes['number_members'] + 1;
            DB::table('toeic_classes')
                ->where('id', $classes['id'])
                ->update([
                    'number_members' => $number_members,
                    'level' => $member_level,
                    'status' => $status,
                    'start_date' => $start_date,
                    'created_at' => $classes['created_at'],
                    'updated_at' => date('Y-m-d H:i:s', time())
                ]);
            return $classes['id'];
        }
    }

    protected function makeMemberClass($member_id, $class_id) {
        $check_existed = MemberClasses::where('member_id', '=', $member_id)
            ->where('class_id', '=', $class_id)
            ->first();

        if ($check_existed) {
            return $check_existed['id'];
        }
        else {
            $member_class = new MemberClasses();
            $member_class->member_id = $member_id;
            $member_class->class_id = $class_id;
            $member_class->save();

            return $member_class->id;
        }
    }

    protected function findClass($member_id) {
        $member_class= MemberClasses::where('member_id', '=', $member_id)->first();
        return $member_class['class_id'];
    }

    public function loginFacebook(Request $request) {
        $id_fb = $request->get('id_fb');
        $email = $request->get('email');
        $name = $request->get('name');

        if ($msg_error = $this->validateFb($id_fb, $email, $name)) {
            return response()->json([
                'error' => $msg_error
            ], 200);
        }

        /* check id_fb in database */
        $check_member_fb = Member::where('id_fb', '=', $id_fb)->first();
        if (!$check_member_fb) {
            // register
            $member_fb = $this->registerSocial($id_fb, $email, $name);
            // create class and member_class
            $class_id = $this->makeClass($member_fb->id, $member_fb->level);
            // make member class
            $this->makeMemberClass($member_fb->id, $class_id);

            return response()->json([
                'status' => 0,
                'idClass' => null,
                'level' => null,
                'member' => null
            ], 200);
        }
        else {


            return response()->json([
                'id' => $check_member_fb['id'],
                'idClass' => $this->findClass($check_member_fb['id']),
                'status' => 1,
                'message' => null,
                'level' => $check_member_fb['level'],
                'member' => [
                    'id' => $check_member_fb['id'],
                    'name' => $check_member_fb['name'],
                    'dob' => $check_member_fb['dob'],
                    'description' => $check_member_fb['description'],
                    'image' => $check_member_fb['avatar']
                ]
            ], 200);
        }
    }

    public function loginGoogle(Request $request) {
        $id_gplus = $request->get('id_gplus');
        $email = $request->get('email');
        $name = $request->get('name');

        if ($msg_error = $this->validateGoogle($id_gplus, $email, $name)) {
            return response()->json([
                'error' => $msg_error
            ], 200);
        }

        /* check id_fb in database */
        $check_member_gplus = Member::where('id_gplus', '=', $id_gplus)->first();
        if (!$check_member_gplus) {
            // register
            $member_gplus = $this->registerSocial($id_gplus, $email, $name, 'google');
            // create class and member_class
            $class_id = $this->makeClass($member_gplus->id, $member_gplus->level);
            // make member class
            $this->makeMemberClass($member_gplus->id, $class_id);

            return response()->json([
                'status' => 0,
                'idClass' => null,
                'level' => null,
                'member' => null
            ], 200);
        }
        else {
            return response()->json([
                'id' => $check_member_gplus['id'],
                'idClass' => $this->findClass($check_member_gplus['id']),
                'status' => 1,
                'message' => null,
                'level' => $check_member_gplus['level'],
                'member' => [
                    'id' => $check_member_gplus['id'],
                    'name' => $check_member_gplus['name'],
                    'dob' => $check_member_gplus['dob'],
                    'description' => $check_member_gplus['description'],
                    'image' => $check_member_gplus['avatar']
                ]
            ], 200);
        }
    }


    public function register(Request $request) {
        $id = $request->get('id', null);
        $member_not_found = false;
        if (!$id) {
            $member_not_found = true;
        }
        else {
            $member_info = Member::where('id', '=', intval($id))->first();
            if (!$member_info) {
                $member_not_found = true;
            }
        }
        if ($member_not_found) {
            return response()->json([
                'error' => 'member not found'
            ], 200);
        }

        DB::table('members')
            ->where('id', intval($id))
            ->update([
                'name' => $request->get('name', ''),
                'email' => $member_info['email'],
                'description' => $request->get('description', ''),
                'nickname' => $member_info['nickname'],
                'full_name' => $member_info['full_name'],
                'avatar' => $member_info['avatar'],
                'dob' => $request->get('dob', null),
                'id_fb' => $member_info['id_fb'],
                'id_gplus' => $member_info['id_gplus'],
                'register_date' => date('Y-m-d H:i:s', time()),
                'last_login_time' => $member_info['last_login_time'],
                'banned' => $member_info['banned'],
                'is_online' => 1,
                'level' => $member_info['level'],
                'created_at' => $member_info['created_at'],
                'updated_at' => date('Y-m-d H:i:s', time())
            ]);

        return response()->json([
            'id' => $member_info['id'],
            'idClass' => $this->findClass($member_info['id']),
            'status' => 1,
            'message' => null,
            'level' => $member_info['level'],
            'member' => [
                'id' => $member_info['id'],
                'name' => $member_info['name'],
                'dob' => $member_info['dob'],
                'description' => $member_info['description'],
                'image' => $member_info['avatar']
            ]
        ], 200);
    }
}