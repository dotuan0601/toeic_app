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
                <div class="panel-heading">Tạo bài học</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('lession.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('lession_date') ? ' has-error' : '' }}">
                            <label for="lession_date" class="col-md-4 control-label">Ngày học thứ</label>

                            <div class="col-md-6">
                                <input id="lession_date" type="number" min="1" class="form-control" name="lession_date"
                                       value="{{ old('lession_date') }}" required autofocus>

                                @if ($errors->has('lession_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lession_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('level') ? ' has-error' : '' }}">
                            <label for="level" class="col-md-4 control-label">Level</label>

                            <div class="col-md-6">
                                <select class="form-control" name="level" id="level">\
                                    @foreach($levels as $level)
                                        <option value="{{$level->name}}">{{$level->name}}</option>
                                    @endforeach\
                                </select>

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