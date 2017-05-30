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
                <div class="panel-heading">Create level</div>
                <div class="panel-body">
                    {!! Form::model($level, [
'method' => 'PATCH',
'route' => ['level.update', $level->id]
]) !!}

                    {{ csrf_field() }}

                    <input type="hidden" value="{{$level->id}}" name="id"/>

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name"
                                   value="{{ $level->name }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('min_point') ? ' has-error' : '' }}">
                        <label for="min_point" class="col-md-4 control-label">min_point</label>

                        <div class="col-md-6">
                            <input id="min_point" type="number" min="0" class="form-control" name="min_point"
                                   value="{{ $level->min_point }}" required autofocus>

                            @if ($errors->has('min_point'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('min_point') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>



                    <div class="form-group{{ $errors->has('max_point') ? ' has-error' : '' }}">
                        <label for="max_point" class="col-md-4 control-label">max_point</label>

                        <div class="col-md-6">
                            <input id="max_point" type="number" min="0" class="form-control" name="max_point"
                                   value="{{ $level->max_point }}" required autofocus>

                            @if ($errors->has('max_point'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('max_point') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Submit
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