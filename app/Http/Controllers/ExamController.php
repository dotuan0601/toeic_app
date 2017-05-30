<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Exam;
use App\Models\ExamKit;
use App\Models\Exercise;
use App\Models\Level;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ExamController   extends Controller
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

    public function listening($kit_id) {
        $is_require_audio = true;

        return view('admin.examcreate', compact('kit_id', 'is_require_audio'));
    }

    public function reading($kit_id) {
        $is_require_audio = false;

        return view('admin.examcreate', compact('kit_id', 'is_require_audio'));
    }

    public function create()
    {
        $levels = Level::all();

        return view('admin.exam_kitcreate', compact('levels'));
    }

    public function index()
    {
        // get all the nerds
        $exam_kits = ExamKit::all();

        // load the view and pass the nerds
        return view('admin.exam_kitindex', compact('exam_kits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'kit_id'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('exam/create')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {

            // storage image
            $image_url = '';
            if ($request->hasFile('content_image')) {
                $image = $request->file('content_image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image_url = 'img/exam/' . $filename;
                $request->content_image->move(public_path('img/exam/'), $filename);
            }

            // store audio
            $audio_filename = '';
            if ($request->hasFile('content_audio')) {
                $music_file = $request->file('content_audio');
                $sort_filename = $music_file->getClientOriginalExtension();
                $audio_filename = time() . '.' . $sort_filename;
                $audio_location = public_path('audio/exam/' . $sort_filename);
                $music_file->move($audio_location,$audio_filename);
            }

            // store exam
            $exam = new Exam();
            $exam->name = Input::get('name');
            $exam->content_text       = Input::get('content_text');
            if ($image_url != '') {
                $exam->content_image = $image_url;
            }
            if ($audio_filename != '') {
                $exam->content_audio = 'audio/exam/' . $sort_filename . '/' . $audio_filename;
            }
            $exam->exam_kit_id       = Input::get('kit_id');
            $exam->save();

            // redirect
            Session::flash('message', 'Tạo thành công');
            return Redirect::to('exam/' . $exam->id . '/edit');
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
        // get the exam_kit
        $exam_kit = exam_kit::find($id);

        // show the view and pass the nerd to it
        return view('admin.exam_kitshow', compact('exam_kit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $exam = Exam::find($id);

        $tests = Test::where('exam_id', '=', $id)->get();

        // show the edit and pass the nerd to it
        return view('admin.examedit', compact('exam', 'tests'));
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
            'name'       => 'string',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('exam/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // check xem có câu hỏi nào chưa
            $quetions = Test::where('exam_id', '=', $id)->first();
            if (!$quetions) {
                Session::flash('message', "Chưa có câu hỏi nào cho phần này");
                return Redirect::to('exam/' . $id . '/edit');
            }


            // storage image
            $image_url = '';
            if ($request->hasFile('content_image')) {
                $image = $request->file('content_image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image_url = 'img/exam/' . $filename;
                $request->content_image->move(public_path('img/exam/'), $filename);
            }

            // store audio
            $audio_filename = '';
            if ($request->hasFile('content_audio')) {
                $music_file = $request->file('content_audio');
                $sort_filename = $music_file->getClientOriginalExtension();
                $audio_filename = time() . '.' . $sort_filename;
                $audio_location = public_path('audio/exam/' . $sort_filename);
                $music_file->move($audio_location,$audio_filename);
            }

            // store exam
            $exam = Exam::find($id);
            $exam->name = Input::get('name');
            $exam->content_text       = Input::get('content_text');
            if ($image_url != '') {
                $exam->content_image = $image_url;
            }
            if ($audio_filename != '') {
                $exam->content_audio = 'audio/exam/' . $sort_filename . '/' . $audio_filename;
            }
            $exam->save();

            // redirect
            Session::flash('message', 'Successfully created nerd!');
            return Redirect::to('exam');
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
//        $task = exam_kit::findOrFail($id);
//
//        $task->delete();
//
//        // remove all related choices
//        Choice::where('exam_kit_id', '=', $id)->delete();

        Session::flash('flash_message', 'exam_kit successfully deleted!');
        return Redirect::to('exam_kit');
    }

    public function remove($id) {
        $task = Exam::findOrFail($id);
        $task->delete();

        Session::flash('flash_message', 'exam_kit successfully deleted!');
        return Redirect::to('exam_kit');
    }

}
