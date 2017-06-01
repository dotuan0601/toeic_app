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
                <div class="panel-heading">Chỉnh sửa listening</div>
                <div class="panel-body">
                    {!! Form::model($exam, [
'method' => 'PATCH',
'enctype' => "multipart/form-data",
'route' => ['exam.update', $exam->id]
]) !!}
                        {{ csrf_field() }}

                        <h3>Thuộc bộ đề: 00 - {{ $exam->exam_kit_id }}</h3>

                        @if (Session::has('message'))
                            <div class="alert alert-danger">{{ Session::get('message') }}</div>
                        @endif

                        <div class="form-group">
                            <p>Số câu hỏi hiện có: <strong><b>{{ count($tests) }}</b></strong></p>
                            @if (count($tests) > 0)
                                <a class="btn btn-small btn-info" href="{{ URL::to('test/list_by_exam/' . $exam->id) }}">Xem danh sách câu hỏi</a>
                            @endif
                            <a class="btn btn-small btn-danger" href="{{ URL::to('test/exam/' . $exam->id) }}">Thêm câu hỏi</a>

                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group{{ $errors->has('instruction') ? ' has-error' : '' }}">
                            <label for="instruction" class="col-md-4 control-label">Hướng dẫn làm bài</label>

                            <div class="col-md-6">
                                    <textarea id="instruction" type="date" class="form-control" name="instruction"
                                              value="{{ old('instruction') }}" required autofocus>{{ $exam->instruction }}</textarea>

                                @if ($errors->has('instruction'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('instruction') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Tên (ví dụ Q1-100)</label>

                            <div class="col-md-6">
                                <textarea id="name" type="date" class="form-control" name="name"
                                          value="{{ old('name') }}" required autofocus>{{ $exam->name }}</textarea>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group{{ $errors->has('content_text') ? ' has-error' : '' }}">
                            <label for="content_text" class="col-md-4 control-label">Nội dung</label>

                            <div class="col-md-6">
                                <textarea id="content_text" type="date" class="form-control" name="content_text"
                                       value="{{ old('content_text') }}">{{$exam->content_text}}</textarea>

                                @if ($errors->has('content_text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('content_text') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group{{ $errors->has('content_image') ? ' has-error' : '' }}">
                            <label for="content_image" class="col-md-4 control-label">Hình ảnh (nếu có)</label>

                            <div class="col-md-6">
                                <input id="content_image" type="file" name="content_image"/>

                                @if ($exam->content_image != '')
                                    <img src="{{URL::to('') . '/' . $exam->content_image}}" title="{{$exam->content_image}}" width="200px" height="200px"/>
                                @endif
                            </div>

                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group{{ $errors->has('content_audio') ? ' has-error' : '' }}">
                            <label for="content_audio" class="col-md-4 control-label">Audio</label>

                            <div class="col-md-6">
                                <input id="content_audio" type="file" name="content_audio"/>
                                @if ($exam->content_audio != ''):

                                <label class="col-md-4 control-label">Audio hiện tại</label>
                                <audio controls src="{{URL::to('') . '/' . $exam->content_audio}}"></audio>
                                @endif
                            </div>

                            <div class="clearfix"></div>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label class="col-md-4 control-label">Danh sách câu hỏi</label>--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<div class="col-md-6 col-md-offset-4">--}}
                                {{--<button type="button" id="add-new-question" class="btn btn-xs btn-default btn-flat">Thêm câu hỏi</i>--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Lưu
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}



                    {{--<div class="modal" id="add-new-question-modal">--}}
                        {{--<div class="modal-dialog">--}}
                            {{--<div class="modal-content">--}}
                                {{--<div class="modal-header">--}}
                                    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--}}
                                    {{--<h4 class="modal-title">Delete Confirmation</h4>--}}
                                {{--</div>--}}
                                {{--<div class="modal-body">--}}
                                    {{--<p>Are you sure you, want to delete?</p>--}}
                                {{--</div>--}}
                                {{--<div class="modal-footer">--}}
                                    {{--<button type="button" class="btn btn-sm btn-primary" id="delete-btn">Delete</button>--}}
                                    {{--<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->


@section('section_script')
    {{ Html::script('js/ckeditor/ckeditor.js') }}

    <script type="text/javascript">
        CKEDITOR.replace( 'content_text',
                {
                    customConfig : 'config.js',
                    toolbar : 'simple'
                })
        CKEDITOR.replace( 'instruction',
                {
                    customConfig : 'config.js',
                    toolbar : 'simple'
                })
    </script>
    @endsection

{{--@section('section_script')--}}
        {{--<script type="text/javascript">--}}
            {{--$(document).ready(function() {--}}
                {{--function addNewQuestion() {--}}
                    {{--$('#add-new-question-modal').modal('hide');--}}
                {{--}--}}

                {{--$("#add-new-question").on('click', function() {--}}
                    {{--$('#add-new-question-modal').modal({ backdrop: 'static', keyboard: false })--}}
                            {{--.on('click', '#delete-btn', function(){--}}
                                {{--addNewQuestion();--}}
                            {{--});--}}
                {{--})--}}
            {{--})--}}
        {{--</script>--}}
{{--@endsection--}}


<!-- footer content -->
<footer>
    <div class="pull-right">
        Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
@endsection