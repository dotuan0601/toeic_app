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
                <div class="panel-heading">Bài tập</div>
                <div class="panel-body">
                    {!! Form::model($exercise, [
'method' => 'PATCH',
'enctype' => "multipart/form-data",
'route' => ['exercise.update', $exercise->id]
]) !!}
                        {{ csrf_field() }}



                        @if (Session::has('message'))
                            <div class="alert alert-danger text-right">{{ Session::get('message') }}</div>
                        @endif

                        <div class="form-group">
                            <p>Số câu hỏi hiện có: <strong><b>{{ count($tests) }}</b></strong></p>
                            @if (count($tests) > 0)
                                <a class="btn btn-small btn-info" href="{{ URL::to('test/list_by_exercise/' . $exercise->id) }}">Xem danh sách câu hỏi</a>
                            @endif
                            <a class="btn btn-small btn-danger" href="{{ URL::to('test/exercise/' . $exercise->id) }}">Thêm câu hỏi</a>
                            <br/><br/>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group{{ $errors->has('introduce') ? ' has-error' : '' }}">
                            <label for="introduce" class="col-md-4 control-label">Giới thiệu bài tập</label>

                            <div class="col-md-6">
                                <textarea id="introduce" type="date" class="form-control" name="introduce"
                                       value="{{ $exercise->introduce }}" required autofocus>{{$exercise->introduce}}</textarea>

                                @if ($errors->has('introduce'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('introduce') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group{{ $errors->has('content_text') ? ' has-error' : '' }}">
                            <label for="content_text" class="col-md-4 control-label">Nội dung bài tập</label>

                            <div class="col-md-6">
                                <textarea id="content_text" type="date" class="form-control" name="content_text"
                                          value="{{ $exercise->content_text }}" required autofocus>{{$exercise->content_text}}</textarea>

                                @if ($errors->has('content_text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('content_text') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group{{ $errors->has('content_image') ? ' has-error' : '' }}">
                            <label for="content_image" class="col-md-4 control-label">Ảnh bài tập</label>

                            <div class="col-md-6">
                                <input id="content_image" type="file" name="content_image"/>
                                @if ($exercise->content_image != '')
                                    <img src="{{URL::to('') . '/' . $exercise->content_image}}" title="{{$exercise->content_image}}" width="200px" height="200px"/>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group{{ $errors->has('content_audio') ? ' has-error' : '' }}">
                            <label for="content_audio" class="col-md-4 control-label">Audio bài tập</label>

                            <div class="col-md-6">
                                <input id="content_audio" type="file" name="content_audio"/>
                                @if ($exercise->content_audio != ''):

                                    <label class="col-md-4 control-label">Audio hiện tại</label>
                                    <audio controls src="{{URL::to('') . '/' . $exercise->content_audio}}"></audio>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group{{ $errors->has('explaination') ? ' has-error' : '' }}">
                            <label for="explaination" class="col-md-4 control-label">Giải thích</label>

                            <div class="col-md-6">
                                <textarea id="explaination" type="date" class="form-control" name="explaination"
                                          value="{{ $exercise->explaination}}" required autofocus>{{$exercise->explaination}}</textarea>

                                @if ($errors->has('explaination'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('explaination') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>


                        <div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
                            <label for="note" class="col-md-4 control-label">Ghi chú (cho bài học tiếp)</label>

                            <div class="col-md-6">
                                <textarea id="note" type="date" class="form-control" name="note"
                                          value="{{ $exercise->note }}" required autofocus>{{$exercise->note}}</textarea>

                                @if ($errors->has('note'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('note') }}</strong>
                                    </span>
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



@section('section_script')
    {{ Html::script('js/ckeditor/ckeditor.js') }}

    <script type="text/javascript">
        CKEDITOR.replace( 'content_text',
                {
                    customConfig : 'config.js',
                    toolbar : 'simple'
                })
        CKEDITOR.replace( 'note',
                {
                    customConfig : 'config.js',
                    toolbar : 'simple'
                })
        CKEDITOR.replace( 'introduce',
                {
                    customConfig : 'config.js',
                    toolbar : 'simple'
                })
    </script>
    @endsection

<!-- footer content -->
<footer>
    <div class="pull-right">
        Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
@endsection