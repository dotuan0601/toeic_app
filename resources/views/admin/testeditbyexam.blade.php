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
                <div class="panel-heading">Sửa <strong>{{ $test->question }}</strong></div>
                <div class="panel-body">
                    {!! Form::model($test, [
'method' => 'PATCH',
'enctype' => "multipart/form-data",
'route' => ['test.update', $test->id]
]) !!}
                        {{ csrf_field() }}

                        <input type="hidden" name="exam_id" value="{{ $exam_id }}"/>

                        <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Question</label>

                            <div class="col-md-6">
                                <textarea id="question" class="form-control" name="question"
                                       value="{{ $test->question }}" required autofocus>{{ $test->question }}</textarea>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('question') }}</strong>
                                    </span>
                                @endif
                                <br/>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    <div class="form-group{{ $errors->has('point') ? ' has-error' : '' }}">
                        <label for="point" class="col-md-4 control-label">Điểm</label>

                        <div class="col-md-6">
                            <input type="number" min="0" id="point" class="form-control" name="point"
                                   value="{{ $test->point }}" required/>

                            @if ($errors->has('point'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('point') }}</strong>
                                    </span>
                            @endif
                            <br/>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group{{ $errors->has('content_image') ? ' has-error' : '' }}">
                        <label for="content_image" class="col-md-4 control-label">Ảnh câu hỏi (câu hỏi listening)</label>

                        <div class="col-md-6">
                            <input id="content_image" type="file" name="content_image"/>

                            @if ($test->content_image != '')
                                <img src="{{URL::to('') . '/' . $test->content_image}}" title="{{$test->content_image}}" width="200px" height="200px"/>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>

                        <input id="number_of_test_choices" type="hidden" value="<?php echo count($test->getChoices());?>"/>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Đặt đáp án đúng</label>

                            <div class="col-md-6">
                                <select class="form-control" name="right_choie" id="right_choie">
                                    <option value="">--</option>
                                </select>
                                <br/>

                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group" id="choice_area">
                            <div class="col-md-8 col-md-offset-4">
                                <div class="col-md-4 ">
                                    <button class="btn-default" type="button" id="add_new_choice">Thêm đáp án</button>
                                </div>
                                <div class="col-md-4 ">
                                    <button class="btn-danger" type="button" id="rm_new_choice">Xóa đáp án</button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a href="{{ URL::previous() }}"><button type="button" class="btn btn-default">Quay lại</button></a>
                                <button type="submit" class="btn btn-primary">
                                    Lưu
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}

                    @foreach ($test->getChoices() as $v)
                        @if ($v->is_correct == 1)
                            <input type="hidden" id="choice-correct-val" value="{{$v->label}}"/>
                            <input type="hidden" id="choice-{{ $v->label }}" value="{{$v->content}}"/>
                        @else:
                            <input type="hidden" id="choice-{{ $v->label }}" value="{{$v->content}}"/>
                        @endif
                    @endforeach
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
        var number_choice = $("#number_of_test_choices").val();
        var alphabet = genCharArray('A', 'Z');

        loadChoice();
        update_right_choice();

        $("#add_new_choice").click(function() {
            btn = $(this);
            if (number_choice >= 0) {
                choice_label = alphabet[number_choice];
                choice_html = '<div  class="col-md-6 col-md-offset-4 choice-for-test">' +
                        '<label class="col-md-2 control-label">' + choice_label + '</label>' +
                        '<div class="col-md-10">' +
                        '<input type="text" class="form-control" name="choice_content[]" value=""/>' + '<br/>' +
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

        function loadChoice() {
            for (var i = 0; i < number_choice; i++) {
                choice_label = alphabet[i];
                choice_html = '<div  class="col-md-6 col-md-offset-4 choice-for-test">' +
                        '<label class="col-md-2 control-label">' + choice_label + '</label>' +
                        '<div class="col-md-10">' +
                        '<input type="text" class="form-control" name="choice_content[]" value="' +
                        $("#choice-" + choice_label).val() +
                        '"/>' + '<br/>' +
                        '</div>' +
                        '</div>';
                $("#choice_area").append(choice_html);
            }
        }

        function update_right_choice() {
            slt = $('#right_choie');
            html_slt = '';
            for(var i = 0; i < number_choice; i ++) {
                if (alphabet[i] == $("#choice-correct-val").val()) {
                    html_slt += '<option value="' + i + '" selected>' +
                            alphabet[i] +
                            '</option>';
                }
                else {
                    html_slt += '<option value="' + i + '">' +
                            alphabet[i] +
                            '</option>';
                }
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