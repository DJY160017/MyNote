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
    <link href="{{ URL::asset('css/share/friendNotelist.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('css/nav_top.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajax({
                url: "http://localhost:90/MyNote/public/share/getAllFriendNotes",
                dataType: 'json',
                type: 'get',
                success: function (data) {
                    console.log(data);
                    var list = document.getElementById('friend-note-info-list-id');
                    for (var id in data) {
                        for (var sub_id in data[id]) {
                            var a_id = 'friend_note_a_' + sub_id.toString();
                            var h_id = 'friend_note_h_' + sub_id.toString();
                            var notebook_id = 'friend_note_n_' + sub_id.toString();
                            var friend_id = 'friend_note_u_' + sub_id.toString();
                            var a = $("<a href='#' class=\"list-group-item\" onclick='friend_note_Click(\"" + h_id + "\",\"" + notebook_id + "\",\"" + friend_id + "\")'></a>");
                            var h_4 = $("<h4 class=\"list-group-item-heading\"></h4>");
                            var p_time = $("<p class=\"list-group-item-text\"></p>");
                            var p_user = $("<p class=\"list-group-item-text\"></p>");
                            var p_notebook = $("<p class=\"list-group-item-text\"></p>");
                            a.attr('id', a_id);
                            h_4.attr('id', h_id);
                            p_notebook.attr('id', notebook_id);
                            p_user.attr('id', friend_id);
                            h_4.html("笔记：" + data[id][sub_id][2]);
                            p_user.html("好友：" + data[id][sub_id][0]);
                            p_notebook.html("笔记本：" + data[id][sub_id][1]);
                            p_time.html("创建时间：" + data[id][sub_id][3]);
                            h_4.appendTo(a);
                            p_user.appendTo(a);
                            p_notebook.appendTo(a);
                            p_time.appendTo(a);
                            a.appendTo(list);
                        }
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
            $('#friend-note-content-search-a-id').click(function () {
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
            $('#note-search-head-id').click(function () {
                var info = $('#note-search-info-head-id').val();
                window.close();
                window.open('http://localhost:90/MyNote/public/tag/showSearchResult?info=' + info, '_self');
            });
        });

        function friend_note_Click(id, notebook_id, friend_id) {
            var noteID = $('#' + id).text().split('：')[1];
            var notebookID = $('#'+notebook_id).text().split('：')[1];
            var friendID = $('#'+friend_id).text().split('：')[1];
            var url = 'http://localhost:90/MyNote/public/share/noteCheck?noteID='+noteID+'&notebookID='+notebookID+'&friendID='+friendID;
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
    <div class="friend-notelist-title-line">
        <p class="friend-notelist-notebookname" id="friend-notebook-title-notelist">好友笔记</p>
    </div>
</div>
<div class="container">
    <div class="search-friend-note">
        <div class="input-group input-group-lg">
            <input class="form-control" type="text" id="search-friend-note-name-input" name="search-friend-note-name"
                   placeholder="查找好友笔记"
                   aria-describedby="sizing-addon1" required/>
            <span class="input-group-btn">
                <button class="btn btn-default" id="friend-note-content-search-a-id" type="button">
                    <span class="friend-note-search-g glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </div>
    <div class="list-group friend-note-info-list" id="friend-note-info-list-id"></div>
    <div class="miss-result-show-friend-note" id="miss-result-show-friend-note-id" hidden>
        <p class="text-center">喔喔！ 未找到符合要求的好友笔记</p>
    </div>
</div>
</body>
</html>