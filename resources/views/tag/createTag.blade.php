<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>创建您的标签</title>

    <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
    <link href="{{ URL::asset('css/bootstrap-low.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-low.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/tag/createTag.js') }}"></script>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.ttf')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff2')}}"/>
    <link href="{{ URL::asset('css/tag/createTag.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#confirm').click(function () {
                var tag_new = $('#tag-name-input').val();
                $.ajax({
                    url: "http://localhost:90/MyNote/public/tag/createTag",
                    dataType: 'json',
                    type: 'post',
                    data: {
                        tag_new: tag_new
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.result === 'success') {
                            window.close();
                            window.open('{{url('note/create')}}', '_self');
                        } else {
                            $('#info-for-tag-id').show();
                            $('#info-for-tag-id').html("该标签已存在");
                            setTimeout(function () {
                                $("#info-for-tag-id").hide();
                            }, 4000);
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
            $('#cancel').click(function () {
                window.close();
                window.open('{{url('note/create')}}', '_self');
            });
        });
    </script>
</head>
<body>
<div class="container main">
    <div class="head">
        <span class="glyphicon glyphicon-tag note-tag-logo" aria-hidden="true"></span>
        <p class="tag-introduction">创建标签</p>
    </div>
    <div class="input-group input-group-lg tag-input-name">
        <input class="form-control" type="text" name="tag-name" id="tag-name-input" placeholder="给标签起个名字吧"
               aria-describedby="sizing-addon1" oninput="changeConfirm()" style="border: none" required/>
    </div>
    <span class="label label-danger info-for-tag" id="info-for-tag-id" style="display: none"></span>
    <div class="tag-name-create-button">
        <button class="btn btn-info create-cancel" id="cancel">取消</button>
        <button class="btn btn-info create-confirm" id="confirm" disabled="disabled">创建标签</button>
    </div>
</div>
</body>
</html>