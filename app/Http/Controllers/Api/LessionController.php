<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use App\Models\Exercise;
use App\Models\Lession;
use App\Models\Member;
use App\Models\MemberClasses;
use App\Models\MemberExerciseScore;
use App\Models\Test;
use App\Models\ToeicClasses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LessionController extends Controller
{

	public function __construct()
	{

	}

    public function exercises(Request $request) {
        $id_class = $request->get('idClass');
        if (!$id_class) {
            return response()->json([
                'error' => 'not found id'
            ], 200);
        }

        $class_info = ToeicClasses::where('id', '=', intval($id_class))->first();
        if (!$class_info) {
            return response()->json([
                'error' => 'not found class'
            ], 200);
        }

        $level = $class_info['level'];
        $lession = Lession::where('level_name', '=', $level)
            ->where('lession_date', '=', intval($request->get('day')))
            ->first();

        if (!$lession) {
            return response()->json([
                'error' => 'not found lession'
            ], 200);
        }

        $exerscise_arr = [];
        $exerscises = Exercise::where('lession_id', '=', $lession['id'])->get();
        if (count($exerscises) > 0) {
            foreach ($exerscises as $exercise) {
                $questions = Test::where('exercise_id', '=', $exercise['id'])->get();
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

                $exerscise_arr[] = [
                    'id' => $exercise['id'],
                    'description' => $exercise['introduce'],
                    'text' => $exercise['content_text'],
                    'image' => $exercise['content_image'],
                    'audio' => $exercise['content_audio'],
                    'arrayQuestions' => $question_arr,

                ];
            }
        }

        return response()->json($exerscise_arr, 200);
    }

    public function submitAnswers(Request $request) {
        $user_id = intval($request->get('idUser'));
        $id_ex = intval($request->get('id_ex'));
        $day = intval($request->get('day'));
        $class_id = intval($request->get('idClass'));
        $array_answers = json_decode($request->get('arrayAnswer'), true);

        $response_arr = [];
        $response_arr['idUser'] = $user_id;
        $response_arr['id_ex'] = $id_ex;
        $response_arr['arrayQuestionResults'] = [];

        $exercise_score = 0;
        foreach ($array_answers as $user_answer) {
            $system_answer = Choice::where('id', '=', $user_answer['idAnswer'])
                ->first();

            $is_true_answer = null;
            if ($system_answer['is_correct'] == 1) {
                $exercise_score += 10;
                $is_true_answer = $system_answer;
            }

            $question = Test::where('id', '=', $user_answer['idQuestion'])->first();
            $response_arr['arrayQuestionResults'][] = [
                'idQuestion' => $user_answer['idQuestion'],
                'contentQuestion' => $question['question'],
                'arrayAnswers' => [
                    'idAnswer' => $user_answer['idAnswer'],
                    'contentAnswer' => [
                        'id' => $system_answer['id'],
                        'label' => $system_answer['label'],
                        'content' => $system_answer['content'],
                        'is_correct' => $system_answer['is_correct']
                    ],
                    'isClientPicked' => $user_answer['idAnswer'],
                    'isTrueAnswer' => $is_true_answer
                ]
            ];
        }

        $record_score = MemberExerciseScore::where('member_id', '=', $user_id)
            ->where('class_id', '=', $class_id)
            ->where('day', '=', $day)
            ->first();

        if (!$record_score) {
            $new_record_score = new MemberExerciseScore();
            $new_record_score->member_id = $user_id;
            $new_record_score->class_id = $class_id;
            $new_record_score->day = $day;
            $new_record_score->score = float($exercise_score);
            $new_record_score->created_at = date('Y-m-d H:i:s', time());
            $new_record_score->save();
        }
        else {
            DB::table('member_exercise_scores')
                ->where('id', $record_score['id'])
                ->update([
                    'member_id' => $request->get('name', ''),
                    'class_id' => $record_score['class_id'],
                    'day' => $record_score['day'],
                    'score' => $record_score + $exercise_score,
                    'created_at' => $record_score['created_at'],
                    'updated_at' => date('Y-m-d H:i:s', time())
                ]);
        }

        return response()->json($response_arr, 200);
    }

    public function getResultsOfClass(Request $request) {
        $id_class = $request->get('idClass');
        $day = $request->get('day');

        $scores = MemberExerciseScore::where('class_id', '=', $id_class)
            ->where('day', '=', intval($day))
            ->get();

        $response_arr = [];
        if (count($scores) > 0) {
            foreach ($scores as $score) {
                $member_id = $score['member_id'];
                $image = '';
                $member = Member::where('id', '=', $member_id)->first();
                if ($member) {
                    $image = $member->avatar;
                }

                $response_arr[] = [
                    'id' => $member_id,
                    'image' => $image,
                    'score' => $score['score']
                ];
            }
        }

        return response()->json($response_arr, 200);
    }
}
