@extends('layouts.blank')

@push('stylesheets')
        <!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

        <!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Từ mới</div>
                <div class="panel-body">
                    {!! Form::model($new_word, [
'method' => 'PATCH',
'enctype' => "multipart/form-data",
'route' => ['new_words.update', $new_word->id]
]) !!}
                        {{ csrf_field() }}



                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Từ mới</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name"
                                   value="{{ $new_word->name }}"/>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group{{ $errors->has('spelling') ? ' has-error' : '' }}">
                        <label for="spelling" class="col-md-4 control-label">Phiên âm</label>

                        <div class="col-md-6">
                            <input id="spelling" type="text" class="form-control" name="spelling"
                                   value="{{ $new_word->spelling }}"/>

                            @if ($errors->has('spelling'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('spelling') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group{{ $errors->has('meaning') ? ' has-error' : '' }}">
                        <label for="meaning" class="col-md-4 control-label">Nghĩa</label>

                        <div class="col-md-6">
                            <input id="content_text" type="meaning" class="form-control" name="meaning"
                                   value="{{ $new_word->meaning }}"/>

                            @if ($errors->has('meaning'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('meaning') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group{{ $errors->has('content_image') ? ' has-error' : '' }}">
                        <label for="content_image" class="col-md-4 control-label">Ảnh từ mới</label>

                        <div class="col-md-6">
                            <input id="content_image" type="file" name="content_image"/>
                            @if ($new_word->content_image != '')
                                <img src="{{URL::to('') . '/' . $new_word->content_image}}" title="{{$new_word->content_image}}" width="200px" height="200px"/>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group{{ $errors->has('content_audio') ? ' has-error' : '' }}">
                        <label for="content_audio" class="col-md-4 control-label">Audio từ mới</label>

                        <div class="col-md-6">
                            <input id="content_audio" type="file" name="content_audio"/>
                            @if ($new_word->content_audio != ''):

                            <label class="col-md-4 control-label">Audio hiện tại</label>
                            <audio controls src="{{URL::to('') . '/' . $new_word->content_audio}}"></audio>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>

                        <div class="form-group">
                            <div class="clearfix"></div>
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Lưu
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->


<!-- footer content -->
<footer>
    <div class="pull-right">
        Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
@endsection