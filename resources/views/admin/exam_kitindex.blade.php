@extends('layouts.blank')

@push('stylesheets')
        <!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

        <!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <li><a href="{{ URL::to('exam_kit/create') }}">Thêm Bộ đề thi</a>
    </div>

    <h1>Danh sách bộ đề</h1>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td>Mã bộ đề</td>
            <td>Level</td>
            <td>Các phần (Part)</td>
            <td class="col-md-2"></td>
        </tr>
        </thead>
        <tbody>
        @foreach($exam_kits as $key => $value)
            <tr>
                <td>00 - {{ $value->id }}</td>
                <td>{{ $value->level }}</td>

                <td>
                    + Phần nghe:
                    <ul>
                        <?php $listening = $value->getListening();?>
                        @if (count($listening) > 0)
                            @foreach($listening as $item)
                                <li>{{ $item->name }} (<a class="btn-small btn red" href="{{ URL::to('exam/' . $item->id . '/edit') }}">Sửa</a>)   (<a class="btn-small btn red" href="{{ URL::to('exam/remove/' . $item->id) }}">Xóa</a>)</li>
                            @endforeach
                        @endif
                        <li><a class="btn btn-small btn-info" href="{{ URL::to('exam/listening/' . $value->id) }}">Thêm phần nghe</a>
                    </ul>
                    <br/>
                    <br/>
                    + Phần đọc:
                    <ul>
                        <?php $reading = $value->getReading();?>
                        @if (count($reading) > 0)
                            @foreach($reading as $item)
                                <li>{{ $item->name }} (<a class="btn-small btn red" href="{{ URL::to('exam/' . $item->id . '/edit') }}">Sửa</a>)   (<a class="btn-small btn red" href="{{ URL::to('exam/remove/' . $item->id) }}">Xóa</a>)</li>
                            @endforeach
                        @endif
                        <li><a class="btn btn-small btn-info" href="{{ URL::to('exam/reading/' . $value->id) }}">Thêm phần đọc</a>
                    </ul>
                </td>

                <!-- we will also add show, edit, and delete buttons -->
                <td>

                    <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                    <!-- we will add this later since its a little more complicated than the other two buttons -->

                    <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                    <a class="btn btn-small btn-info" href="{{ URL::to('exam_kit/' . $value->id . '/edit') }}">Sửa</a>

                    <div class="col-md-6 text-right">
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => ['exam_kit.destroy', $value->id]
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