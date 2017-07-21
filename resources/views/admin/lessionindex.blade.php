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
            <td>Từ mới</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        @foreach($lessions as $key => $value)
            <tr>
                <td>{{ $value->lession_date }}</td>
                <td>{{ $value->level_name }}</td>
                <td><?php echo htmlspecialchars_decode($value->note)?></td>
                <td>
                    <ul>
                        @foreach($value->getListExercises() as $exercise)
                            <li>
                                <a class="btn btn-small btn-link" href="{{ URL::to('exercise/' . $exercise->id . '/edit') }}">{{ $exercise->id }}</a>
                                (<a class="btn-small btn red" href="{{ URL::to('exercise/remove/' . $exercise->id) }}">Xóa</a>)
                            </li>
                        @endforeach
                        <a class="btn btn-small btn-link" href="{{ URL::to('exercise/create_for_lession/' . $value->id) }}">Thêm bài tập</a>
                    </ul>
                </td>
                <td>
                    @foreach($value->getNewWords() as $new_words)
                        <p>
                        <p>{{ $new_words->name }} (<a class="btn-small btn red" href="{{ URL::to('new_words/' . $new_words->id . '/edit') }}">Sửa</a>)
                            (<a class="btn-small btn red" href="{{ URL::to('new_words/remove/' . $new_words->id) }}">Xóa</a>)</p>
                        </p>
                    @endforeach
                    <p><a class="btn btn-small btn-link" href="{{ URL::to('new_words/create_for_lession/' . $value->id) }}">Thêm từ mới</a></p>
                </td>
                <!-- we will also add show, edit, and delete buttons -->
                <td>

                    <a class="btn btn-small btn-info" href="{{ URL::to('lession/' . $value->id . '/edit') }}">Sửa</a>

                    <div class="col-md-6 text-right">
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => ['lession.destroy', $value->id],
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