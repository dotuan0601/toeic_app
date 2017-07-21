<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Level;
use App\Models\Lession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LessionController  extends Controller
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

        return view('admin.lessioncreate', compact('levels'));
    }

    public function index()
    {
        // get all the nerds
        $lessions = Lession::orderBy('updated_at', 'DESC')->get();

        // load the view and pass the nerds
        return view('admin.lessionindex', compact('lessions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // check lession_date
        $check_existed = Lession::where('lession_date', '=', Input::get('lession_date'))->first();
        if ($check_existed) {
            return Redirect::to('lession/create')
                ->withInput(Input::except('lession_date'));
        }

        // get previous lession
        $note = '';
        $previous_date = Input::get('lession_date') - 1;
        $previous_lession = Lession::where('lession_date', '=', $previous_date)
            ->where('level_name', '=', '' . Input::get('level'))->first();
        if ($previous_lession) {
            $previous_exercises = Exercise::where('lession_id', '=', $previous_lession->id)->get();
            foreach ($previous_exercises as $exercise) {
                $note .= $exercise->note . "<br/><br/>";
            }
        }

        // store test
        $lession = new Lession();
        $lession->lession_date       = Input::get('lession_date');
        $lession->level_name      = Input::get('level');
        $lession->note = $note;
        $lession->save();

        // redirect
        Session::flash('message', 'Successfully created nerd!');
        return Redirect::to('lession');
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
        $test = Lession::find($id);

        // show the view and pass the nerd to it
        return view('admin.lessionshow', compact('test'));
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
        $lession = Lession::find($id);
//        print_r($test->getJsonChoices()); die;
        $levels = Level::all();

        // show the edit and pass the nerd to it
        return view('admin.lessionedit', compact('lession', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        // get previous lession
        $note = '';
        if (Input::get('note') == '') {
            $previous_date = Input::get('lession_date') - 1;
            $previous_lession = Lession::where('lession_date', '=', $previous_date)
                ->where('level_name', '=', '' . Input::get('level'))
                ->first();
            if ($previous_lession) {
                $previous_exercises = Exercise::where('lession_id', '=', $previous_lession->id)->get();
                foreach ($previous_exercises as $exercise) {
                    $note .= $exercise->note . "<br/><br/>";
                }
            }
        }
        else {
            $note = Input::get('note');
        }


        // store
        $lession = Lession::find($id);
        $lession->lession_date       = Input::get('lession_date');
        $lession->level_name      = Input::get('level');
        $lession->note = $note;
        $lession->save();

        // redirect
        Session::flash('message', 'Successfully updated test!');
        return Redirect::to('lession');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $task = Lession::findOrFail($id);

        $task->delete();

        Session::flash('flash_message', 'test successfully deleted!');
        return Redirect::to('lession');
    }

}
