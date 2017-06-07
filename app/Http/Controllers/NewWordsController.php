<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Lession;
use App\Models\NewWords;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class NewWordsController extends Controller
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
        $lessions = Lession::all();

        return view('admin.exercisecreate', compact('lessions'));
    }

    public function create_for_lession($lession_id)
    {
        $lession = Lession::where('id', '=', $lession_id)->first();

        return view('admin.newwordscreate', compact('lession'));
    }

    public function index()
    {
        // get all the nerds
        $exercises = Exercise::all();

        // load the view and pass the nerds
        return view('admin.exerciseindex', compact('exercises'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'name'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('exercise/create')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // storage image
            $image_url = '';
            if ($request->hasFile('content_image')) {
                $image = $request->file('content_image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image_url = 'img/newwords/' . $filename;
                $request->content_image->move(public_path('img/newwords/'), $filename);
            }

            // store audio
            $audio_filename = '';
            if ($request->hasFile('content_audio')) {
                $music_file = $request->file('content_audio');
                $sort_filename = $music_file->getClientOriginalExtension();
                $audio_filename = time() . '.' . $sort_filename;
                $audio_location = public_path('audio/newwords/' . $sort_filename);
                $music_file->move($audio_location,$audio_filename);
            }

            // store
            $new_word = new NewWords();
            $new_word->lession_id = Input::get('lession_id');
            $new_word->name       = Input::get('name');
            $new_word->spelling      = Input::get('spelling');
            $new_word->meaning = Input::get('meaning');
            if ($image_url != '') {
                $new_word->content_image = $image_url;
            }
            if ($audio_filename != '') {
                $new_word->content_audio = 'audio/newwords/' . $sort_filename . '/' . $audio_filename;
            }
            $new_word->save();

            // redirect
            Session::flash('message', 'Tạo thành công');
            return Redirect::to('lession');
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
        $new_word = NewWords::find($id);

        return view('admin.newwordsedit', compact('new_word'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('level/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // storage image
            $image_url = '';
            if ($request->hasFile('content_image')) {
                $image = $request->file('content_image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image_url = 'img/newwords/' . $filename;
                $request->content_image->move(public_path('img/newwords/'), $filename);
            }

            // store audio
            $audio_filename = '';
            if ($request->hasFile('content_audio')) {
                $music_file = $request->file('content_audio');
                $sort_filename = $music_file->getClientOriginalExtension();
                $audio_filename = time() . '.' . $sort_filename;
                $audio_location = public_path('audio/newwords/' . $sort_filename);
                $music_file->move($audio_location,$audio_filename);
            }

            // store
            $new_word = NewWords::find($id);
            $new_word->name       = Input::get('name');
            $new_word->spelling      = Input::get('spelling');
            $new_word->meaning = Input::get('meaning');
            if ($image_url != '') {
                $new_word->content_image = $image_url;
            }
            if ($audio_filename != '') {
                $new_word->content_audio = 'audio/newwords/' . $sort_filename . '/' . $audio_filename;
            }
            $new_word->save();

            // redirect
            Session::flash('message', 'Successfully updated new word!');
            return Redirect::to('lession');
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
        $task = NewWords::findOrFail($id);

        $task->delete();

        Session::flash('flash_message', 'Level successfully deleted!');
        return Redirect::to('lession');
    }

    public function remove($id) {
        $task = NewWords::findOrFail($id);
        $task->delete();

        Session::flash('flash_message', 'exam_kit successfully deleted!');
        return Redirect::to('lession');
    }
}
