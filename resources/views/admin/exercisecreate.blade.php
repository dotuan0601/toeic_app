@extends('layouts.blank')

@push('stylesheets')
        <!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

        <!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Tạo bài tập</div>
                <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST"
                          action="{{ route('exercise.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('introduce') ? ' has-error' : '' }}">
                            <label for="introduce" class="col-md-4 control-label">Giới thiệu bài tập</label>

                            <div class="col-md-6">
                                <textarea id="introduce" type="date" class="form-control" name="introduce"
                                       value="{{ old('introduce') }}" required autofocus></textarea>

                                @if ($errors->has('introduce'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('introduce') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('content_text') ? ' has-error' : '' }}">
                            <label for="content_text" class="col-md-4 control-label">Nội dung bài tập</label>

                            <div class="col-md-6">
                                <textarea id="content_text" type="date" class="form-control" name="content_text"
                                          value="{{ old('content_text') }}"></textarea>

                                @if ($errors->has('content_text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('content_text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('content_image') ? ' has-error' : '' }}">
                            <label for="content_image" class="col-md-4 control-label">Ảnh bài tập</label>

                            <div class="col-md-6">
                                <input id="content_image" type="file" name="content_image"/>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('content_audio') ? ' has-error' : '' }}">
                            <label for="content_audio" class="col-md-4 control-label">Audio bài tập</label>

                            <div class="col-md-6">
                                <input id="content_audio" type="file" name="content_audio"/>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('explaination') ? ' has-error' : '' }}">
                            <label for="explaination" class="col-md-4 control-label">Giải thích</label>

                            <div class="col-md-6">
                                <textarea id="explaination" type="date" class="form-control" name="explaination"
                                          value="{{ old('explaination') }}" required autofocus></textarea>

                                @if ($errors->has('explaination'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('explaination') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('lession_id') ? ' has-error' : '' }}">
                            <label for="lession_id" class="col-md-4 control-label">Bài học thứ</label>

                            <div class="col-md-6">
                                <select class="form-control" name="lession_id" id="lession_id">\
                                    @foreach($lessions as $lession)
                                        <option value="{{$lession->id}}">{{$lession->lession_date}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
                            <label for="note" class="col-md-4 control-label">Ghi chú (cho bài học tiếp)</label>

                            <div class="col-md-6">
                                <textarea id="note" type="date" class="form-control" name="note"
                                          value="{{ old('note') }}" required autofocus></textarea>

                                @if ($errors->has('note'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('note') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Lưu
                                </button>
                            </div>
                        </div>
                    </form>
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