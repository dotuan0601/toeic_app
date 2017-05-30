<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Exam;
use App\Models\ExamKit;
use App\Models\Exercise;
use App\Models\Level;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ExamKitController  extends Controller
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
    public function store()
    {
        $rules = array(
            'level'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('exam_kit/create')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store exam_kit
            $exam_kit = new ExamKit();
            $exam_kit->level       = Input::get('level');
            $exam_kit->save();

            // redirect
            Session::flash('message', 'Successfully created nerd!');
            return Redirect::to('exam_kit');
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
        // get the nerd
        $exam_kit = ExamKit::find($id);
        $levels = Level::all();

        // show the edit and pass the nerd to it
        return view('admin.exam_kitedit', compact('exam_kit', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'level'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('exam_kit/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $exam_kit = ExamKit::find($id);
            $exam_kit->level       = Input::get('level');
            $exam_kit->save();

            // redirect
            Session::flash('message', 'Successfully updated exam_kit!');
            return Redirect::to('exam_kit');
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
        $task = ExamKit::findOrFail($id);

        $task->delete();

        // remove all related exams
        Exam::where('exam_kit_id', '=', $id)->delete();

        Session::flash('flash_message', 'exam_kit successfully deleted!');
        return Redirect::to('exam_kit');
    }

}
