@extends('layouts.blank')

@push('stylesheets')
        <!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

        <!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <li><a href="{{ URL::to('level/create') }}">Create a level</a>
    </div>

    <h1>All Level</h1>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Min point</td>
            <td>Max point</td>
            <td class="col-md-2">Actions</td>
        </tr>
        </thead>
        <tbody>
        @foreach($levels as $key => $value)
            <tr>
                <td>{{ $value->id }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->min_point }}</td>
                <td>{{ $value->max_point }}</td>

                <!-- we will also add show, edit, and delete buttons -->
                <td>

                    <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                    <a class="btn btn-small btn-info" href="{{ URL::to('level/' . $value->id . '/edit') }}">Sửa</a>

                    <div class="col-md-6 text-right">
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => ['level.destroy', $value->id],
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