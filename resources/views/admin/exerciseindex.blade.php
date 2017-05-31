@extends('layouts.blank')

@push('stylesheets')
        <!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

        <!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <li><a href="{{ URL::to('exercise/create') }}">Tạo bài tập</a></li>
    </div>

    <h1>Danh sách bài tập</h1>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td>Bài học ngày thứ</td>
            <td>Giới thiệu</td>
            <td>Nội dung</td>
            <td>Ghi chú (cho ngày tiếp)</td>
            <td>Giải thích</td>
            <td>Danh sách Câu hỏi</td>
            <td class="col-md-2"></td>
        </tr>
        </thead>
        <tbody>
        @foreach($exercises as $key => $value)
            <tr>
                <td>
                    <a class="btn btn-small btn-info" href="{{ URL::to('lession/' . $value->lession_id . '/edit') }}">{{ $value->getLessionInfo()->lession_date }}</a>
                </td>
                <td>{{ $value->introduce }}</td>
                <td>
                    {{ $value->content_text }}
                    @if ($value->content_image != '')
                        <br/>
                        <img src="{{URL::to('') . '/' . $value->content_image}}" title="{{$value->content_image}}" width="200px" height="200px"/>
                    @endif
                    @if ($value->content_audio != '')
                        <br/>
                        <audio controls src="{{URL::to('') . '/' . $value->content_audio}}"></audio>
                    @endif
                </td>
                <td>{{ $value->explaination }}</td>
                <td>{{ $value->note}}</td>
                <td>
                    <ul>
                        @foreach ($value->getListQuestions() as $k_question => $question)
                            <li>
                                <a class="btn btn-small btn-info" href="{{ URL::to('test/' . $question->id . '/edit') }}">{{ $question->id}}</a>
                            </li>
                        @endforeach
                    </ul>
                </td>
                <!-- we will also add show, edit, and delete buttons -->
                <td>
                    <a class="btn btn-small btn-info" href="{{ URL::to('exercise/' . $value->id . '/edit') }}">Sửa</a>

                    <div class="col-md-6 text-right">
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => ['exercise.destroy', $value->id],
                            'onsubmit' => 'return ConfirmDelete()'
                        ]) !!}
                        {!! Form::submit('Xóa?', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>
                    <script>

                        function ConfirmDelete()
                        {
                            var x = confirm("Bạn thực sự muốn xóa???");
                            if (x)
                                return true;
                            else
                                return false;
                        }

                    </script>
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