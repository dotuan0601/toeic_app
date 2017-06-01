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
                <div class="panel-heading">Tạo bài học</div>
                <div class="panel-body">
                    {!! Form::model($lession, [
'method' => 'PATCH',
'route' => ['lession.update', $lession->id]
]) !!}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('lession_date') ? ' has-error' : '' }}">
                            <label for="lession_date" class="col-md-4 control-label">Ngày học thứ</label>

                            <div class="col-md-6">
                                <input id="lession_date" type="number" min="1" class="form-control" name="lession_date"
                                       value="{{ $lession->lession_date }}" required autofocus>

                                @if ($errors->has('lession_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lession_date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="clearfix"></div>
                        </div>


                        <div class="form-group{{ $errors->has('level') ? ' has-error' : '' }}">
                            <label for="level" class="col-md-4 control-label">Level</label>

                            <div class="col-md-6">
                                <select class="form-control" name="level" id="level">\
                                    @foreach($levels as $level)
                                        <option value="{{$level->name}}" <?php if ($lession->level_name == $level->name) echo 'selected'?>>{{$level->name}}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="clearfix"></div>
                        </div>


                    <div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
                        <label for="note" class="col-md-4 control-label">Note từ bài học trước</label>

                        <div class="col-md-6">
                                <textarea id="note" type="date" class="form-control" name="note"
                                          value="{{ $lession->note }}">{{$lession->note}}</textarea>

                            @if ($errors->has('note'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('note') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="clearfix"></div>
                    </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a href="{{ URL::previous() }}"><button type="button" class="btn btn-default">Quay lại</button></a>
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
        CKEDITOR.replace( 'note',
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