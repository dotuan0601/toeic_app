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
                <div class="panel-heading">Tạo từ mới cho ngày học thứ <span style="color: blue">{{ $lession->lession_date }}</span></div>
                <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST"
                          action="{{ route('new_words.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Từ mới</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name"
                                       value="{{ old('name') }}"/>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('spelling') ? ' has-error' : '' }}">
                            <label for="spelling" class="col-md-4 control-label">Phiên âm</label>

                            <div class="col-md-6">
                                <input id="spelling" type="text" class="form-control" name="spelling"
                                          value="{{ old('spelling') }}"/>

                                @if ($errors->has('spelling'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('spelling') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('meaning') ? ' has-error' : '' }}">
                            <label for="meaning" class="col-md-4 control-label">Nghĩa</label>

                            <div class="col-md-6">
                                <input id="content_text" type="meaning" class="form-control" name="meaning"
                                          value="{{ old('meaning') }}"/>

                                @if ($errors->has('meaning'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('meaning') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('content_image') ? ' has-error' : '' }}">
                            <label for="content_image" class="col-md-4 control-label">Ảnh từ mới</label>

                            <div class="col-md-6">
                                <input id="content_image" type="file" name="content_image"/>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('content_audio') ? ' has-error' : '' }}">
                            <label for="content_audio" class="col-md-4 control-label">Audio từ mới</label>

                            <div class="col-md-6">
                                <input id="content_audio" type="file" name="content_audio"/>
                            </div>
                        </div>

                        <input type="hidden" value="{{ $lession->id }}" name="lession_id"/>

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