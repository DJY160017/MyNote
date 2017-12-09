<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>记你所想</title>

    <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
    <link href="{{ URL::asset('css/bootstrap-low.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-low.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/note/notelist.js') }}"></script>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.ttf')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff2')}}"/>
    <link href="{{ URL::asset('css/note/notelist.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('css/nav_top.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajax({
                url: "http://localhost:90/MyNote/public/note/getAllNote",
                dataType: 'json',
                type: 'get',
                data: {
                    notebookID: '{{$result}}'
                },
                success: function (data) {
                    console.log(data);
                    var list = document.getElementById('note-info-list-id');
                    for (var id in data) {
                        var a_id = 'note_a_' + id.toString();
                        var h_id = 'note_h_' + id.toString();
                        var a = $("<a href='#' class=\"list-group-item\" onclick='noteClick(\"" + h_id + "\")'></a>");
                        var h_4 = $("<h4 class=\"list-group-item-heading\"></h4>");
                        var p_time = $("<p class=\"list-group-item-text\"></p>");
                        a.attr('id', a_id);
                        h_4.attr('id', h_id);
                        h_4.html(data[id][0]);
                        p_time.html("创建时间：" + data[id][1]);
                        h_4.appendTo(a);
                        p_time.appendTo(a);
                        a.appendTo(list);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
            $('#note-content-search-a-id').click(function () {
                var info = $('#search-note-name-input').val();
                var notebookID = $('#notebook-title-notelist').html();
                if (info === '') {
                    $("#search-note-name-input").css('border-color', 'lightcoral');
                    setTimeout(function () {
                        $("#search-note-name-input").css('border-color', '');
                    }, 4000);
                } else {
                    $.ajax({
                        url: "http://localhost:90/MyNote/public/note/searchNote",
                        dataType: 'json',
                        type: 'post',
                        data: {
                            info: info,
                            notebookID: notebookID
                        },
                        success: function (data) {
                            console.log(data);
                            if (data.length === 0) {
                                $("#note-info-list-id").hide();
                                $("#miss-result-show-note-id").show();
                                setTimeout(function () {
                                    $("#note-info-list-id").show();
                                    $("#miss-result-show-note-id").hide();
                                }, 4000);
                            } else {
                                $('#note-info-list-id').empty();
                                var list = document.getElementById('note-info-list-id');
                                for (var id in data) {
                                    var a_id = 'note_a_' + id.toString();
                                    var h_id = 'note_h_' + id.toString();
                                    var a = $("<a href='#' class=\"list-group-item\" onclick='notebookClick(\"" + h_id + "\")'></a>");
                                    var h_4 = $("<h4 class=\"list-group-item-heading\"></h4>");
                                    var p_time = $("<p class=\"list-group-item-text\"></p>");
                                    a.attr('id', a_id);
                                    h_4.attr('id', h_id);
                                    h_4.html(data[id][0]);
                                    p_time.html("创建时间：" + data[id][1]);
                                    h_4.appendTo(a);
                                    p_time.appendTo(a);
                                    a.appendTo(list);
                                }
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }
            });
            $('#modify-notebook-name-input-save-id').click(function () {
                var new_notebookID = $('#notelist-notebook-name-input-id').val();
                var old_notebookID = $('#notebook-title-notelist').text();
                if (new_notebookID === '') {
                    $("#notelist-notebook-name-input-id").css('border-color', 'lightcoral');
                    setTimeout(function () {
                        $("#notelist-notebook-name-input-id").css('border-color', '');
                    }, 4000);
                } else {
                    $.ajax({
                        url: "http://localhost:90/MyNote/public/notebook/modifyNotebookName",
                        dataType: 'json',
                        type: 'get',
                        data: {
                            old_notebookID: old_notebookID,
                            new_notebookID: new_notebookID
                        },
                        success: function (data) {
                            console.log(data);
                            if (data.result === 'success') {
                                $('#notebook-title-notelist').html(new_notebookID);
                                var p = document.getElementById('notebook-title-notelist');
                                var a_pencil = $("<a class=\"modify-notebook-name\" id=\"modify-notebook-name-id\" href=\"#\" onclick='show_modify()'></a>");
                                var a_trash = $("<a class=\"remove-notebook\" id=\"remove-notebook-id\" href=\"#\"></a>");
                                var span_pencil = $("<span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span>");
                                var span_trash = $("<span class=\"glyphicon glyphicon-trash\"></span>");
                                span_pencil.appendTo(a_pencil);
                                span_trash.appendTo(a_trash);
                                a_pencil.appendTo(p);
                                a_trash.appendTo(p);
                                $('#modify-notebook-name-input-div-id').hide();
                                $('#notebook-title-notelist').show();
                            } else {
                                $("#notelist-notebook-name-input-id").css('border-color', 'lightcoral');
                                $('#notelist-notebook-name-input-id').val("");
                                setTimeout(function () {
                                    $("#notelist-notebook-name-input-id").css('border-color', '');
                                }, 4000);
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }
            });
            $('#remove-notebook-id').click(function () {
                var notebookID = $('#notebook-title-notelist').text();
                $.ajax({
                    url: "http://localhost:90/MyNote/public/notebook/removeNotebook",
                    dataType: 'json',
                    type: 'get',
                    data: {
                        notebookID: notebookID
                    },
                    success: function (data) {
                        console.log(data);
                        window.close();
                        window.open('{{url('notebook')}}', '_self');
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
            $('#note-search-head-id').click(function () {
                var info = $('#note-search-info-head-id').val();
                window.close();
                window.open('http://localhost:90/MyNote/public/tag/showSearchResult?info=' + info, '_self');
            });
        });

        function noteClick(id) {
            var noteID = $('#' + id).html();
            var notebookID = $('#notebook-title-notelist').text();
            notebookID = notebookID.trim();
            var url = 'http://localhost:90/MyNote/public/note/showNote?noteID='+noteID+'&notebookID='+notebookID;
            window.close();
            window.open(url, '_self');
        }
    </script>
</head>
<body>
<div class="container">
    <nav class="myNavbar navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <p class="logo navbar-brand">Enote</p>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="right-nav nav nav-pills navbar-right">
                    <li>
                        <form class="navbar-form navbar-left" id="search-form">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon"
                                      style="border-top-left-radius: 15px;border-bottom-left-radius: 15px;">
                                    <a class="note-search-a" href="#" id="note-search-head-id">
                                    <span class="note-search glyphicon glyphicon-search"></span>
                                    </a>
                                </span>
                                <input type="text" class="form-control" id="note-search-info-head-id"
                                       placeholder="tag"
                                       style="border-top-right-radius: 15px;border-bottom-right-radius: 15px;"
                                       aria-describedby="sizing-addon3">
                            </div>
                        </form>
                    </li>
                    <li>
                        <a class="note-plus-a" href="{{url('note/create')}}">
                            <span class="note-plus glyphicon glyphicon-plus"></span>
                        </a>
                    </li>
                    <li>
                        <a class="note-book-a" href="{{url('notebook')}}">
                            <span class="note-book glyphicon glyphicon-book"></span>
                        </a>
                    </li>
                    <li>
                        <a class="note-friendnote-a" href="{{url('share/showFriendNotes')}}">
                            <span class="note-friend glyphicon glyphicon-file"></span>
                        </a>
                    </li>
                    <li>
                        <a class="note-tag-a" href="{{url('tag/create')}}">
                            <span class="note-tag glyphicon glyphicon-tags"></span>
                        </a>
                    </li>
                    <li>
                        <a class="note-checkUser-a" href="{{url('share')}}">
                            <span class="note-check glyphicon glyphicon-user"></span>
                        </a>
                    </li>
                    <li>
                        <a class="profile" href="{{url('your_profile')}}">
                            <img src="{{URL::asset('images/default.jpg')}}" class="img-circle"
                                 style="width: 20px;height: 20px">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="container ">
    <div class="modal fade in remove-hints-show" id="remove-hints-show-id" style="display: none; ">
        <div class="modal-body">
            <p>删除笔记本会把笔记也全删除喔！</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-info" data-dismiss="modal">取消</a>
            <a href="#" class="btn btn-success" id="remove-notebook-id">确认</a>
        </div>
    </div>
    <div class="notelist-title-line">
        <p class="notelist-notebookname" id="notebook-title-notelist">{{$result}}
            <a class="modify-notebook-name" id="modify-notebook-name-id" href="#" onclick="show_modify()">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            </a>
            <a class="remove-notebook" href="#remove-hints-show-id" data-toggle="modal">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </a>
        </p>
        <div class="modify-notebook-name-input-div" id="modify-notebook-name-input-div-id" hidden>
            <input class="form-control notelist-notebook-name-input" type="text" id="notelist-notebook-name-input-id"
                   placeholder="请输入名字" aria-describedby="sizing-addon1" required/>
            <div class="modify-notebook-name-input-button">
                <button class="btn btn-sm btn-success"
                        id="modify-notebook-name-input-save-id" type="button">保存
                </button>
                <button class="btn btn-sm btn-info"
                        id="modify-notebook-name-input-cancel-id" type="button" onclick="modify_Notebook_Name_Cancel()">
                    取消
                </button>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="search-note">
        <div class="input-group input-group-lg">
            <input class="form-control" type="text" id="search-note-name-input" name="search-note-name"
                   placeholder="查找笔记"
                   aria-describedby="sizing-addon1" required/>
            <span class="input-group-btn">
                <button class="btn btn-default" id="note-content-search-a-id" type="button">
                    <span class="note-search-g glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </div>
    <div class="list-group note-info-list" id="note-info-list-id"></div>
    <div class="miss-result-show-note" id="miss-result-show-note-id" hidden>
        <p class="text-center">喔喔！ 未找到符合要求的笔记</p>
    </div>
</div>
</body>
</html>