@extends('layouts.blank')

@push('stylesheets')
        <!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

        <!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <li><a href="{{ URL::to('lession/create') }}">Tạo bài học</a></li>
    </div>

    <h1>Danh sách bài học</h1>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td>Ngày học thứ</td>
            <td>Level</td>
            <td>Note bài học trước</td>
            <td>Danh sách bài tập</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        @foreach($lessions as $key => $value)
            <tr>
                <td>{{ $value->lession_date }}</td>
                <td>{{ $value->level_name }}</td>
                <td>{{ $value->note}}</td>
                <td>
                    <ul>
                        @foreach($value->getListExercises() as $exercise)
                            <li>
                                <a class="btn btn-small btn-info" href="{{ URL::to('exercise/' . $exercise->id . '/edit') }}">{{ $exercise->id }}</a>
                            </li>
                        @endforeach
                    </ul>
                </td>
                <!-- we will also add show, edit, and delete buttons -->
                <td>

                    <a class="btn btn-small btn-info" href="{{ URL::to('lession/' . $value->id . '/edit') }}">Sửa</a>

                    <div class="col-md-6 text-right">
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => ['lession.destroy', $value->id]
                        ]) !!}
                        {!! Form::submit('Xóa?', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
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