@extends('layouts.blank')

@push('stylesheets')
        <!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

        <!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <li><a href="{{ URL::to('test/create') }}">Thêm câu hỏi</a>
    </div>

    <h1>All tests</h1>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td>ID</td>
            <td>Question</td>
            <td>Thuộc bài tập (Id)</td>
            <td>Điểm</td>
            <td>Đáp án</td>
            <td class="col-md-2"></td>
        </tr>
        </thead>
        <tbody>
        @foreach($tests as $key => $value)
            <tr>
                <td>{{ $value->id }}</td>
                <td>{{ $value->question }}</td>
                @if ($value->exercise_id)
                    <td>
                        <a class="btn btn-small btn-info" href="{{ URL::to('exercise/' . $value->exercise_id . '/edit') }}">{{ $value->exercise_id}}</a>
                    </td>
                @else:
                    <td>Chưa thuộc bài tập nào</td>
                @endif
                <td>{{ $value->point}}</td>
                <td>
                    <ul>
                        @foreach($value->getChoices() as $v)
                            @if ($v->is_correct == 1)
                                <li style="color: red">{{$v->label}} : {{$v->content}}</li>
                            @else
                                <li>{{$v->label}} : {{$v->content}}</li>
                            @endif

                        @endforeach
                    </ul>
                </td>
                <!-- we will also add show, edit, and delete buttons -->
                <td>

                    <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                    <!-- we will add this later since its a little more complicated than the other two buttons -->

                    <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                    <a class="btn btn-small btn-info" href="{{ URL::to('test/' . $value->id . '/edit') }}">Sửa</a>

                    <div class="col-md-6 text-right">
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => ['test.destroy', $value->id]
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