@extends('layouts.blank')

@push('stylesheets')
        <!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

        <!-- page content -->
<div class="right_col" role="main">
    <h1>Level: {{ $level->name }}</h1>

    <div class="jumbotron text-center">
        <h2>{{ $level->name }}</h2>
        <p>
            <strong>Min point:</strong> {{ $level->min_point }}<br>
            <strong>Max point:</strong> {{ $level->max_point }}
        </p>
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