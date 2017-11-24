<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use App\Models\Exam;
use App\Models\ExamKit;
use App\Models\Exercise;
use App\Models\Lession;
use App\Models\Level;
use App\Models\Member;
use App\Models\MemberClasses;
use App\Models\MemberExamKits;
use App\Models\MemberExamKitScore;
use App\Models\MemberExerciseScore;
use App\Models\Test;
use App\Models\ToeicClasses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    protected $convert_level_arr = [
        null => 'newbie',
        'newbie' => 'master',
        'master' => 'unknown'
    ];

	public function __construct()
	{

	}

    public function getExamKit(Request $request) {
        if (!$request->get('idUser')) {
            return response()->json([
                'error' => 'please post idUser'
            ], 200);
        }

        if (!$request->get('type_of_test')) {
            return response()->json([
                'error' => 'please post type_of_test'
            ], 200);
        }

        $member_id = $request->get('idUser');
        $type_of_test = $request->get('type_of_test');

        $member = Member::where('id', '=', $member_id)->first();
        $exam_kit = DB::table('exam_kits')
            ->select('exam_kits.id', 'exam_kits.created_at')
            ->where('type_of_test', $type_of_test)
            ->where('level', $this->convert_level_arr[$member->level])
            ->leftJoin('member_exam_kits', 'exam_kits.id', '=', 'member_exam_kits.exam_kit_id')
            ->orderBy('member_exam_kits.number_receive', 'asc')
            ->first();

        $response_arr = [];
        if ($exam_kit) {
            $response_arr['idTest'] = $exam_kit->id;
            $response_arr['arrayExercises'] = [];
            $response_arr['exercise_time'] = 0;
            $exercise_time = 0;
            $exams = Exam::where('exam_kit_id', '=', $exam_kit->id)->get();
            if (count($exams) > 0) {
                foreach ($exams as $exam) {
                    $questions = Test::where('exam_id', '=', $exam['id'])->get();
                    $question_arr = [];
                    if (count($questions) > 0) {
                        foreach ($questions as $question) {
                            $answers = Choice::where('test_id', '=', $question['id'])->get();
                            $answer_arr = [];
                            if (count($answers) > 0) {
                                foreach ($answers as $answer) {
                                    $answer_arr[] = [
                                        'answer_id' => $answer['id'],
                                        'contentOfAnswer' => [
                                            'label' => $answer['label'],
                                            'content' => $answer['content'],
                                            'is_correct' => $answer['is_correct']
                                        ]
                                    ];
                                }
                            }

                            $question_arr[] = [
                                'id' => $question['id'],
                                'title' => $question['question'],
                                'image' => $question['content_image'],
                                'point' => $question['point'],
                                'arrayAnswers' => $answer_arr
                            ];
                        }
                    }

                    $exercise_time += 75;
                    $type_of_exercise = 'reading';
                    if ($exam['content_audio']) {
                        $type_of_exercise = 'listening';
                        $exercise_time += 45;
                    }
                    $response_arr['arrayExercises'][] = [
                        'id' => $exam['id'],
                        'instruction' => $exam['instruction'],
                        'name' => $exam['name'],
                        'description' => $exam['description'],
                        'text' => $exam['content_text'],
                        'image' => $exam['content_image'],
                        'audio' => $exam['content_audio'],
                        'type_of_exercise' => $type_of_exercise,
                        'arrayQuestions' => $question_arr,

                    ];
                }
            }

            $response_arr['exercise_time'] = $exercise_time;

            $check_member_exam_kits = MemberExamKits::where('member_id', '=', $member_id)
                ->where('exam_kit_id', '=', $exam_kit->id)
                ->first();

            if ($check_member_exam_kits) {
                DB::table('member_exam_kits')
                    ->where('id', $check_member_exam_kits['id'])
                    ->update([
                        'member_id' => $check_member_exam_kits['member_id'],
                        'exam_kit_id' => $check_member_exam_kits['exam_kit_id'],
                        'number_receive' => $check_member_exam_kits['number_receive'] + 1,
                        'created_at' => $check_member_exam_kits['created_at'],
                        'updated_at' => date('Y-m-d H:i:s', time())
                    ]);
            }
            else {
                $member_exam_kits = new MemberExamKits();
                $member_exam_kits->member_id = $member_id;
                $member_exam_kits->exam_kit_id = $exam_kit->id;
                $member_exam_kits->number_receive = 1;
                $member_exam_kits->created_at = date('Y-m-d H:i:s', time());
                $member_exam_kits->save();
            }
        }

        return response()->json($response_arr, 200);
    }

    public function submitTest(Request $request) {
        $user_id = intval($request->get('idUser'));
        $id_exam_kit = intval($request->get('idTest'));
        $arrayExercises = json_decode($request->get('arrayExercises'), true);
        $response_arr = [];
        $response_arr['idUser'] = $user_id;
        $response_arr['status'] = 1;
        $response_arr['arrayExerciseResults'] = [];

        $exam_kit_score = 0;
        if ($arrayExercises) {
            foreach ($arrayExercises as $exercise) {
                $exercise_odm = Exam::where('id', '=', $exercise['idEx'])->first();
                $arrayQuestions = $exercise['arrayQuestions'];
                $arrayQuestionResults = [];
                foreach ($arrayQuestions as $question) {
                    $list_answer = Choice::where('test_id', '=', $question['idQuestion'])->get();
                    $is_true_answer = 0;
                    $is_client_picked = $question['idAnswer'];
                    $answer_arr = [];
                    foreach ($list_answer as $answer) {
                        if ($answer['is_correct'] == 1) {
                            $is_true_answer = $answer['id'];
                            if ($question['idAnswer'] == $is_true_answer) {
                                $question_odm = Test::where('id', '=', $question['idQuestion'])->first();
                                $exam_kit_score += $question_odm['point'];
                            }
                        }
                        $answer_arr[][] = [
                            'idAnswer' => $answer['id'],
                            'contentOfAnswer' => $answer['content']
                        ];
                    }
                    $question_odm = Test::where('id', '=', $question['idQuestion'])->first();
                    $arrayQuestionResults[] = [
                        'title' => $question_odm['question'],
                        'idQuestion' => $question_odm['id'],
                        'arrayAnswers' => [
                            'listAnswers' => $answer_arr,
                            'isClientPicked' => $is_client_picked,
                            'isTrueAnswer' => $is_true_answer
                        ]
                    ];
                }

                $response_arr['arrayExerciseResults'][] = [
                    'id' => $exercise_odm['id'],
                    'introduce' => $exercise_odm['introduce'],
                    'description' => $exercise_odm['content_text'],
                    'image' => $exercise_odm['content_image'],
                    'audio' => $exercise_odm['content_audio'],
                    'arrayQuestionResults' => $arrayQuestionResults
                ];
            }
        }

        $new_record_score = new MemberExamKitScore();
        $new_record_score->member_id = $user_id;
        $new_record_score->exam_kit_id = $id_exam_kit;
        $new_record_score->score = $exam_kit_score;
        $new_record_score->created_at = date('Y-m-d H:i:s', time());
        $new_record_score->save();

        $response_arr['upgradeLevel'] = false;
        $response_arr['score'] = $exam_kit_score;
        $member_info = Member::where('id', '=', $user_id)->first();
        $response_arr['level'] = $member_info['level'];
        $exam_kit = ExamKit::where('id', '=', $id_exam_kit)->first();
        if ($exam_kit && $exam_kit['type_of_test'] == 'upgradeLevel') {
            $level_record = Level::where('min_point', '<=', $exam_kit_score)
                ->where('max_point', '>=', $exam_kit_score)
                ->where('name', '=', $this->convert_level_arr[$member_info->level])
                ->first();
            if ($level_record) {
                $response_arr['upgradeLevel'] = true;
                $response_arr['level'] = $this->convert_level_arr[$member_info->level];
                DB::table('members')
                    ->where('id', intval($user_id))
                    ->update([
                        'name' => $member_info['name'],
                        'email' => $member_info['email'],
                        'description' => $member_info['description'],
                        'nickname' => $member_info['nickname'],
                        'full_name' => $member_info['full_name'],
                        'avatar' => $member_info['avatar'],
                        'dob' => $member_info['dob'],
                        'id_fb' => $member_info['id_fb'],
                        'id_gplus' => $member_info['id_gplus'],
                        'register_date' => $member_info['register_date'],
                        'last_login_time' => $member_info['last_login_time'],
                        'banned' => $member_info['banned'],
                        'is_online' => 1,
                        'level' => $this->convert_level_arr[$member_info->level],
                        'created_at' => $member_info['created_at'],
                        'updated_at' => date('Y-m-d H:i:s', time())
                    ]);
            }
        }

        return response()->json($response_arr, 200);
    }
}
