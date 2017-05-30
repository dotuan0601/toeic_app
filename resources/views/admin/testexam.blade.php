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
                <div class="panel-heading">Tạo câu hỏi</div>
                <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data"  role="form" method="POST" action="{{ route('test.store') }}">
                        {{ csrf_field() }}

                        <input name="exam_id" value="{{ $exam_id }}" type="hidden"/>

                        <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Question</label>

                            <div class="col-md-6">
                                <textarea id="question" class="form-control" name="question"
                                       value="{{ old('question') }}" required autofocus></textarea>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('question') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('content_image') ? ' has-error' : '' }}">
                            <label for="content_image" class="col-md-4 control-label">Ảnh câu hỏi (câu hỏi listening)</label>

                            <div class="col-md-6">
                                <input id="content_image" type="file" name="content_image"/>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('point') ? ' has-error' : '' }}">
                            <label for="point" class="col-md-4 control-label">Điểm</label>

                            <div class="col-md-6">
                                <input id="point" type="number" min="1" class="form-control" name="point"
                                          value="{{ old('point') }}" required/>

                                @if ($errors->has('point'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('point') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Đặt đáp án đúng</label>

                            <div class="col-md-6">
                                <select class="form-control" name="right_choie" id="right_choie">
                                    <option value="">--</option>
                                </select>

                            </div>
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
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Lưu
                                </button>
                            </div>
                        </div>
                    </form>
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