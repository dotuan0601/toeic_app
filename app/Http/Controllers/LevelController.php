<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
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
        return view('admin.levelcreate');
    }

    public function index()
    {
        // get all the nerds
        $levels = Level::all();

        // load the view and pass the nerds
        return view('admin.levelindex', compact('levels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules = array(
            'name'       => 'required',
            'min_point'      => 'numeric',
            'max_point' => 'numeric'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('level/create')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $level = new Level();
            $level->name       = Input::get('name');
            $level->min_point      = Input::get('min_point');
            $level->max_point = Input::get('max_point');
            $level->save();

            // redirect
            Session::flash('message', 'Successfully created nerd!');
            return Redirect::to('level');
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
        // get the level
        $level = Level::find($id);

        // show the view and pass the nerd to it
        return view('admin.levelshow', compact('level'));
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
        $level = Level::find($id);

        // show the edit and pass the nerd to it
        return view('admin.leveledit', compact('level'));
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
            'name'       => 'required',
            'min_point'      => 'numeric',
            'max_point' => 'numeric'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('level/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $level = Level::find($id);
            $level->name       = Input::get('name');
            $level->min_point      = Input::get('min_point');
            $level->max_point = Input::get('max_point');
            $level->save();

            // redirect
            Session::flash('message', 'Successfully updated level!');
            return Redirect::to('level');
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
        $task = Level::findOrFail($id);

        $task->delete();

        Session::flash('flash_message', 'Level successfully deleted!');
        return Redirect::to('level');
    }

}
