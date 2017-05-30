@extends('layouts.blank')

@push('stylesheets')
        <!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

        <!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <a class="btn btn-small btn-info" href="{{ URL::to('exam/' . $exam_id . '/edit') }}">Quay về</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td>ID</td>
            <td>Question</td>
            <td>Ảnh (nếu có)</td>
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
                    <a class="btn btn-small btn-info" href="{{ URL::to('test/edit_by_exam/' . $value->id . '/' . $exam_id) }}">Sửa</a>

                    <a class="btn btn-small btn-danger" href="{{ URL::to('test/destroy_by_exam/' . $value->id . '/' . $exam_id) }}">Xóa</a>

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