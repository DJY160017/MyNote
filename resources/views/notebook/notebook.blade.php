<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>记你所想</title>

    <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
    <link href="{{ URL::asset('css/bootstrap-low.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-low.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/notebook/notebook.js') }}"></script>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.ttf')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff2')}}"/>
    <link href="{{ URL::asset('css/notebook/notebook.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('css/nav_top.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajax({
                url: "http://localhost:90/MyNote/public/notebook/getAllNotebook",
                dataType: 'json',
                type: 'get',
                success: function (data) {
                    console.log(data);
                    var list = document.getElementById('notebook-info-list-id');
                    for (var id in data) {
                        var a_id = 'notebook_a_' + id.toString();
                        var h_id = 'notebook_h_' + id.toString();
                        var a = $("<a href='#' class=\"list-group-item\" onclick='notebookClick(\"" + h_id + "\")'></a>");
                        var h_4 = $("<h4 class=\"list-group-item-heading\"></h4>");
                        var p_num = $("<p class=\"list-group-item-text\"></p>");
                        var p_time = $("<p class=\"list-group-item-text\"></p>");
                        a.attr('id', a_id);
                        h_4.attr('id', h_id);
                        h_4.html(data[id][0]);
                        p_time.html("创建时间：" + data[id][1]);
                        p_num.html(data[id][2] + "条笔记");
                        h_4.appendTo(a);
                        p_num.appendTo(a);
                        p_time.appendTo(a);
                        a.appendTo(list);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });

            $('#note-search-a-id').click(function () {
                var info = $('#search-notebook-name-input').val();
                if (info === '') {
                    $("#search-notebook-name-input").css('border-color', 'lightcoral');
                    setTimeout(function () {
                        $("#search-notebook-name-input").css('border-color', '');
                    }, 4000);
                } else {
                    $.ajax({
                        url: "http://localhost:90/MyNote/public/notebook/searchNotebook",
                        dataType: 'json',
                        type: 'get',
                        data: {
                            info: info
                        },
                        success: function (data) {
                            console.log(data);
                            if (data.length === 0) {
                                $("#notebook-info-list-id").hide();
                                $("#miss-result-show-id").show();
                                setTimeout(function () {
                                    $("#notebook-info-list-id").show();
                                    $("#miss-result-show-id").hide();
                                }, 4000);
                            } else {
                                $('#notebook-info-list-id').empty();
                                var list = document.getElementById('notebook-info-list-id');
                                for (var id in data) {
                                    var a_id = 'notebook_a_' + id.toString();
                                    var h_id = 'notebook_h_' + id.toString();
                                    var a = $("<a href='#' class=\"list-group-item\" onclick='notebookClick(\"" + h_id + "\")'></a>");
                                    var h_4 = $("<h4 class=\"list-group-item-heading\"></h4>");
                                    var p_num = $("<p class=\"list-group-item-text\"></p>");
                                    var p_time = $("<p class=\"list-group-item-text\"></p>");
                                    a.attr('id', a_id);
                                    h_4.attr('id', h_id);
                                    h_4.html(data[id][0]);
                                    p_time.html("创建时间：" + data[id][1]);
                                    p_num.html(data[id][2] + "条笔记");
                                    h_4.appendTo(a);
                                    p_num.appendTo(a);
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
            $('#note-search-head-id').click(function () {
                var info = $('#note-search-info-head-id').val();
                window.close();
                window.open('http://localhost:90/MyNote/public/tag/showSearchResult?info=' + info, '_self');
            });
        });

        function createNotebook() {
            var url = 'http://localhost:90/MyNote/public/notebook/create';
            window.close();
            window.open(url, '_self');
        }

        function notebookClick(id) {
            var notebookID = $('#' + id).html();
            var url = 'http://localhost:90/MyNote/public/note/notelist?notebookID=' + notebookID;
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
<div class="container">
    <div class="search-notebook">
        <div class="input-group input-group-lg">
            <input class="form-control" id="search-notebook-name-input" type="text" name="search-notebook-name"
                   placeholder="查找笔记本" aria-describedby="sizing-addon1" required/>
            <span class="input-group-btn">
                <button class="btn btn-default" id="notebook-plus-id" type="button" onclick="createNotebook()">
                    <span class="notebook-plus-g glyphicon glyphicon-plus"></span>
                </button>
                <button class="btn btn-default" id="note-search-a-id" type="button">
                    <span class="notebook-search-g glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </div>
    <div class="list-group notebook-info-list" id="notebook-info-list-id"></div>
    <div class="miss-result-show" id="miss-result-show-id" hidden>
        <p class="text-center">喔喔！ 未找到符合要求的笔记本</p>
    </div>
</div>
</body>
</html>