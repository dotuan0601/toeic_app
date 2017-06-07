<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use App\Models\Exam;
use App\Models\Exercise;
use App\Models\Lession;
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

	public function __construct()
	{

	}

    public function getExamKit(Request $request) {
        $member_id = $request->get('idUser');
        $type_of_test = $request->get('type_of_test');

        $member = Member::where('id', '=', $member_id)->first();
        $exam_kit = DB::table('exam_kits')
            ->select('exam_kits.id', 'exam_kits.created_at')
            ->where('type_of_test', $type_of_test)
            ->where('level', $member->level)
            ->leftJoin('member_exam_kits', 'exam_kits.id', '=', 'member_exam_kits.exam_kit_id')
            ->orderBy('member_exam_kits.number_receive', 'asc')
            ->first();

        $response_arr = [];
        if ($exam_kit) {
            $response_arr['idTest'] = $exam_kit->id;
            $response_arr['arrayExercises'] = [];
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
                                'title' => $question['question'],
                                'image' => $question['content_image'],
                                'point' => $question['point'],
                                'arrayAnswers' => $answer_arr
                            ];
                        }
                    }

                    $response_arr['arrayExercises'][] = [
                        'instruction' => $exam['instruction'],
                        'name' => $exam['name'],
                        'description' => $exam['description'],
                        'text' => $exam['content_text'],
                        'image' => $exam['content_image'],
                        'audio' => $exam['content_audio'],
                        'arrayQuestions' => $question_arr,

                    ];
                }
            }

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
        foreach ($arrayExercises as $exercise) {
            $exercise_odm = Exam::where('id', '=', $exercise['id'])->first();
            $arrayQuestions = $exercise['arrayQuestions'];
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
            }

            $response_arr['arrayExerciseResults'][] = [
                'id' => $exercise_odm['id'],
                'introduce' => $exercise_odm['introduce'],
                'description' => $exercise_odm['content_text'],
                'image' => $exercise_odm['content_image'],
                'audio' => $exercise_odm['content_audio'],
                'arrayQuestionResults' => [
                    'title' => $question_odm['question'],
                    'idQuestion' => $question_odm['id'],
                    'arrayAnswers' => [
                        'listAnswers' => $answer_arr,
                        'isClientPicked' => $is_client_picked,
                        'isTrueAnswer' => $is_true_answer
                    ]
                ]
            ];
        }

        $new_record_score = new MemberExerciseScore();
        $new_record_score->member_id = $user_id;
        $new_record_score->exam_kit_id = $id_exam_kit;
        $new_record_score->score = $exam_kit_score;
        $new_record_score->created_at = date('Y-m-d H:i:s', time());
        $new_record_score->save();

        return response()->json($response_arr, 200);
    }
}
