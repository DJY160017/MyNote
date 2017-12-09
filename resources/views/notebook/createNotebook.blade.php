<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>创建您的笔记本</title>

    <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
    <link href="{{ URL::asset('css/bootstrap-low.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-low.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/notebook/createNotebook.js') }}"></script>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.ttf')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff2')}}"/>
    <link href="{{ URL::asset('css/notebook/createNotebook.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#confirm').click(function () {
                var notebook_new = $('#notebook-name-input').val();
                $.ajax({
                    url: "http://localhost:90/MyNote/public/notebook/createNotebook",
                    dataType: 'json',
                    type: 'post',
                    data: {
                        notebook_new: notebook_new
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.result === 'success') {
                            window.close();
                            window.open('{{url('note/create')}}', '_self');
                        } else {
                            $('#info-for-notebook-id').show();
                            $('#info-for-notebook-id').html("该笔记本已存在");
                            setTimeout(function () {
                                $("#info-for-notebook-id").hide();
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
        <span class="glyphicon glyphicon-book note-book-logo" aria-hidden="true"></span>
        <p class="book-introduction">创建笔记本</p>
    </div>
    <div class="input-group input-group-lg noteook-input-bookname">
        <input class="form-control" type="text" name="notebook-name" id="notebook-name-input" placeholder="给笔记本起个名字吧"
               aria-describedby="sizing-addon1" oninput="changeConfirm()" style="border: none" required/>
    </div>
    <span class="label label-danger info-for-notebook" id="info-for-notebook-id" style="display: none"></span>
    <div class="notebook-name-create-button">
        <button class="btn btn-info create-cancel" id="cancel">取消</button>
        <button class="btn btn-info create-confirm" id="confirm" disabled="disabled">创建笔记本</button>
    </div>
</div>
</body>
</html>