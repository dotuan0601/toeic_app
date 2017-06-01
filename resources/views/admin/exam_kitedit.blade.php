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
                <div class="panel-heading">Sửa bộ đề 00 - {{ $exam_kit->id }}</div>
                <div class="panel-body">


                    {!! Form::model($exam_kit, [
'method' => 'PATCH',
'route' => ['exam_kit.update', $exam_kit->id]
]) !!}

                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('level') ? ' has-error' : '' }}">
                            <label for="level" class="col-md-4 control-label">Level</label>

                            <div class="col-md-6">
                                <select class="form-control" name="level">
                                    @foreach($levels as $level)
                                        <option value="{{$level->name}}" <?php if ($exam_kit->level == $level->name) echo 'selected'?>>{{$level->name}}</option>
                                    @endforeach
                                </select>
                                <br/>

                            </div>
                        </div>

                    <div class="form-group{{ $errors->has('type_of_test') ? ' has-error' : '' }}">
                        <label for="type_of_test" class="col-md-4 control-label">Loại test</label>

                        <div class="col-md-6">
                            <label for="upgradeLevel">Upgrade level</label>
                            <input type="radio" name="type_of_test" value="upgradeLevel"
                            <?php if($exam_kit->type_of_test == 'upgradeLevel') echo 'checked="checked"'?> />
                            <br/>
                            <label for="weekend">Bài học cuối tuần</label>
                            <input type="radio" name="type_of_test"  value="weekend"
                            <?php if($exam_kit->type_of_test == 'weekend') echo 'checked="checked"'?> />
                            <br/>

                        </div>
                    </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Lưu
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

<!-- script here -->
@section('section_script')
<script type="text/javascript">
    function genCharArray(charA, charZ) {
        var a = [], i = charA.charCodeAt(0), j = charZ.charCodeAt(0);
        for (; i <= j; ++i) {
            a.push(String.fromCharCode(i));
        }
        return a;
    }


    $(document).ready(function() {
        var number_choice = 0;
        var alphabet = genCharArray('A', 'Z');

        $("#add_new_choice").click(function() {
            btn = $(this);
            if (number_choice >= 0) {
                choice_label = alphabet[number_choice];
                choice_html = '<div  class="col-md-6 col-md-offset-4 choice-for-test">' +
                        '<label class="col-md-2 control-label">' + choice_label + '</label>' +
                        '<div class="col-md-10">' +
                        '<input type="text" class="form-control" name="choice_content[]"/>' + '<br/>' +
                        '</div>' +
                        '</div>';
                $("#choice_area").append(choice_html);
                number_choice ++;
                update_right_choice();

            }
        });


        $('#rm_new_choice').click(function(){
            if (number_choice >= 1) {
                $('.choice-for-test').last().remove();
                number_choice --;
                update_right_choice();
            }
        });

        function update_right_choice() {
            slt = $('#right_choie');
            html_slt = '';
            for(var i = 0; i < number_choice; i ++) {
                html_slt += '<option value="' + i + '">' +
                        alphabet[i] +
                        '</option>';
            }
            slt.html(html_slt);
        };
    })
</script>
@endsection

<!-- footer content -->
<footer>
    <div class="pull-right">
        Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
@endsection