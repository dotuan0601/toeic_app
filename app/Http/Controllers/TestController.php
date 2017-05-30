<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Exam;
use App\Models\Exercise;
use App\Models\Level;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $exericses = Exercise::all();

        return view('admin.testcreate', compact('exericses'));
    }

    public function exam($id)
    {
        $exam_id = $id;

        return view('admin.testexam', compact( 'exam_id'));
    }

    public function index()
    {
        // get all the nerds
        $tests = Test::where('exam_id', '=', null)->get();

        // load the view and pass the nerds
        return view('admin.testindex', compact('tests'));
    }

    public function list_by_exam($exam_id)
    {
        // get all the nerds
        $tests = Test::where('exam_id', '=', $exam_id)->get();

        // load the view and pass the nerds
        return view('admin.testlist', compact('tests', 'exam_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'question'       => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('test/create')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            $is_exercise = true;
            if(Input::get('exam_id')) {
                $is_exercise = false;

                // storage image
                $image_url = '';
                if ($request->hasFile('content_image')) {
                    $image = $request->file('content_image');
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    $image_url = 'img/exam/' . $filename;
                    $request->content_image->move(public_path('img/exam/'), $filename);
                }

                // store test exam
                // store test
                $test = new Test();
                $test->question       = Input::get('question');
                $test->exam_id      = Input::get('exam_id');
                if ($image_url != '') {
                    $test->content_image = $image_url;
                }
                $test->point            = Input::get('point');
                $test->save();
            }
            else {
                // store test
                $test = new Test();
                $test->question       = Input::get('question');
                $test->exercise_id      = Input::get('exercise_id');
                $test->point            = Input::get('point');
                $test->save();
            }

            // store test choices
            $alphabet = range('A', 'Z');
            $choice_content = Input::get('choice_content');
            foreach($choice_content as $k => $v) {
                $choice_orm = new Choice();
                $choice_orm->test_id = $test->id;
                $choice_orm->label = $alphabet[$k];
                $choice_orm->content = $v;
                if ($k == Input::get('right_choie')) {
                    $choice_orm->is_correct = 1;
                }
                $choice_orm->save();
            }

            // redirect
            if ($is_exercise) {
                Session::flash('message', 'Successfully created nerd!');
                return Redirect::to('test');
            }
            else {
                return Redirect::to('exam/' . Input::get('exam_id') . '/edit');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // get the test
        $test = Test::find($id);

        // show the view and pass the nerd to it
        return view('admin.testshow', compact('test'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // get the nerd
        $test = Test::find($id);
//        print_r($test->getJsonChoices()); die;
        $exericses = Exercise::all();

        // show the edit and pass the nerd to it
        return view('admin.testedit', compact('test', 'exericses'));
    }

    public function edit_by_exam($id, $exam_id)
    {
        // get the nerd
        $test = Test::find($id);

        // show the edit and pass the nerd to it
        return view('admin.testeditbyexam', compact('test', 'exam_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'question'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('test/edit_by_exam/' . $id . '/' . Input::get('exam_id'))
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            $is_exercise = true;
            if (Input::get('exam_id')) {
                $is_exercise = false;

                // storage image
                $image_url = '';
                if ($request->hasFile('content_image')) {
                    $image = $request->file('content_image');
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    $image_url = 'img/exam/' . $filename;
                    $request->content_image->move(public_path('img/exam/'), $filename);
                }

                // store test exam
                // store test
                $test = Test::find($id);
                $test->question       = Input::get('question');
                $test->exam_id      = Input::get('exam_id');
                if ($image_url != '') {
                    $test->content_image = $image_url;
                }
                $test->point            = Input::get('point');
                $test->save();
            }
            else {
                // store
                $test = Test::find($id);
                $test->question       = Input::get('question');
                $test->exercise_id      = Input::get('exercise_id');
                $test->point = intval(Input::get('point'));
                $test->save();
            }

            // remove all related choices
            Choice::where('test_id', '=', $id)->delete();

            // store test choices
            $alphabet = range('A', 'Z');
            $choice_content = Input::get('choice_content');
            foreach($choice_content as $k => $v) {
                $choice_orm = new Choice();
                $choice_orm->test_id = $test->id;
                $choice_orm->label = $alphabet[$k];
                $choice_orm->content = $v;
                if ($k == Input::get('right_choie')) {
                    $choice_orm->is_correct = 1;
                }
                $choice_orm->save();
            }

            // redirect
            Session::flash('message', 'Successfully updated test!');
            if ($is_exercise) {
                return Redirect::to('test');
            }
            else {
                return Redirect::to('exam/' . Input::get('exam_id') . '/edit');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        echo 'normal'; die;
        $task = Test::findOrFail($id);

        $task->delete();

        // remove all related choices
        Choice::where('test_id', '=', $id)->delete();

        Session::flash('flash_message', 'test successfully deleted!');
        return Redirect::to('test');
    }

    public function destroy_by_exam($id, $exam_id)
    {
        $task = Test::findOrFail($id);

        $task->delete();

        // remove all related choices
        Choice::where('test_id', '=', $id)->delete();

        Session::flash('flash_message', 'test successfully deleted!');

        return Redirect::to('exam/' . $exam_id . '/edit');
    }
}
