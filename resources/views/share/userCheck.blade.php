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
    <link href="{{ URL::asset('css/share/userCheck.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('css/nav_top.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajax({
                url: "http://localhost:90/MyNote/public/share/getAllUser",
                dataType: 'json',
                type: 'get',
                success: function (data) {
                    console.log(data);
                    var list = document.getElementById('user-info-list-id');
                    for (var id in data) {
                        var a_id = 'user_a_' + id.toString();
                        var h_id = 'user_h_' + id.toString();
                        var a = $("<a href='#' class=\"list-group-item\" onclick='userClick(\"" + h_id + "\")'></a>");
                        var h_4 = $("<h4 class=\"list-group-item-heading\"></h4>");
                        var p_introduction = $("<p class=\"list-group-item-text\"></p>");
                        var p_num = $("<p class=\"list-group-item-text\"></p>");
                        var p_mail = $("<p class=\"list-group-item-text\"></p>");
                        a.attr('id', a_id);
                        h_4.attr('id', h_id);
                        h_4.html(data[id][0]);
                        p_introduction.html('自我介绍：' + data[id][1]);
                        p_num.html("笔记总数：" + data[id][3]);
                        p_mail.html("邮箱：" + data[id][2]);
                        h_4.appendTo(a);
                        p_introduction.appendTo(a);
                        p_num.appendTo(a);
                        p_mail.appendTo(a);
                        a.appendTo(list);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
            $.ajax({
                url: "http://localhost:90/MyNote/public/share/getFriends",
                dataType: 'json',
                type: 'get',
                success: function (data) {
                    console.log(data);
                    var list = document.getElementById('friend-info-list-id');
                    for (var id in data) {
                        var a_id = 'friend_a_' + id.toString();
                        var h_id = 'friend_h_' + id.toString();
                        var a = $("<a href='#' class=\"list-group-item\" onclick='friendClick(\"" + h_id + "\")'></a>");
                        var h_4 = $("<h4 class=\"list-group-item-heading\"></h4>");
                        var p_introduction = $("<p class=\"list-group-item-text\"></p>");
                        var p_num = $("<p class=\"list-group-item-text\"></p>");
                        var p_mail = $("<p class=\"list-group-item-text\"></p>");
                        a.attr('id', a_id);
                        h_4.attr('id', h_id);
                        h_4.html(data[id][0]);
                        p_introduction.html('自我介绍：' + data[id][1]);
                        p_num.html("笔记总数：" + data[id][3]);
                        p_mail.html("邮箱：" + data[id][2]);
                        h_4.appendTo(a);
                        p_introduction.appendTo(a);
                        p_num.appendTo(a);
                        p_mail.appendTo(a);
                        a.appendTo(list);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
            $('#user-search-a-id').click(function () {
                var info = $('#search-user-name-input').val();
                if (info === '') {
                    $("#search-user-name-input").css('border-color', 'lightcoral');
                    setTimeout(function () {
                        $("#search-user-name-input").css('border-color', '');
                    }, 4000);
                } else {
                    $.ajax({
                        url: "http://localhost:90/MyNote/public/share/searchUser",
                        dataType: 'json',
                        type: 'get',
                        data: {
                            info: info
                        },
                        success: function (data) {
                            console.log(data);
                            if (data.length === 0) {
                                $("#user-info-list-id").hide();
                                $("#miss-result-show-user-id").show();
                                setTimeout(function () {
                                    $("#user-info-list-id").show();
                                    $("#miss-result-show-user-id").hide();
                                }, 4000);
                            } else {
                                $('#user-info-list-id').empty();
                                var list = document.getElementById('user-info-list-id');
                                for (var id in data) {
                                    var a_id = 'user_a_' + id.toString();
                                    var h_id = 'user_h_' + id.toString();
                                    var a = $("<a href='#' class=\"list-group-item\" onclick='userClick(\"" + h_id + "\")'></a>");
                                    var h_4 = $("<h4 class=\"list-group-item-heading\"></h4>");
                                    var p_introduction = $("<p class=\"list-group-item-text\"></p>");
                                    var p_num = $("<p class=\"list-group-item-text\"></p>");
                                    var p_mail = $("<p class=\"list-group-item-text\"></p>");
                                    a.attr('id', a_id);
                                    h_4.attr('id', h_id);
                                    h_4.html(data[id][0]);
                                    p_introduction.html('自我介绍：' + data[id][1]);
                                    p_num.html("笔记总数：" + data[id][3]);
                                    p_mail.html("邮箱：" + data[id][2]);
                                    h_4.appendTo(a);
                                    p_introduction.appendTo(a);
                                    p_num.appendTo(a);
                                    p_mail.appendTo(a);
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
            $('#friend-search-a-id').click(function () {
                var info = $('#search-friend-name-input').val();
                if (info === '') {
                    $("#search-friend-name-input").css('border-color', 'lightcoral');
                    setTimeout(function () {
                        $("#search-friend-name-input").css('border-color', '');
                    }, 4000);
                } else {
                    $.ajax({
                        url: "http://localhost:90/MyNote/public/share/searchFriend",
                        dataType: 'json',
                        type: 'get',
                        data: {
                            info: info
                        },
                        success: function (data) {
                            console.log(data);
                            if (data.length === 0) {
                                $("#friend-info-list-id").hide();
                                $("#miss-result-show-friend-id").show();
                                setTimeout(function () {
                                    $("#friend-info-list-id").show();
                                    $("#miss-result-show-friend-id").hide();
                                }, 4000);
                            } else {
                                $('#friend-info-list-id').empty();
                                var list = document.getElementById('friend-info-list-id');
                                for (var id in data) {
                                    var a_id = 'friend_a_' + id.toString();
                                    var h_id = 'friend_h_' + id.toString();
                                    var a = $("<a href='#' class=\"list-group-item\" onclick='friendClick(\"" + h_id + "\")'></a>");
                                    var h_4 = $("<h4 class=\"list-group-item-heading\"></h4>");
                                    var p_introduction = $("<p class=\"list-group-item-text\"></p>");
                                    var p_num = $("<p class=\"list-group-item-text\"></p>");
                                    var p_mail = $("<p class=\"list-group-item-text\"></p>");
                                    a.attr('id', a_id);
                                    h_4.attr('id', h_id);
                                    h_4.html(data[id][0]);
                                    p_introduction.html('自我介绍：' + data[id][1]);
                                    p_num.html("笔记总数：" + data[id][3]);
                                    p_mail.html("邮箱：" + data[id][2]);
                                    h_4.appendTo(a);
                                    p_introduction.appendTo(a);
                                    p_num.appendTo(a);
                                    p_mail.appendTo(a);
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
        });
        function userClick(id) {
            var friendID = $('#' + id).html();
            $.ajax({
                url: "http://localhost:90/MyNote/public/share/addFriend",
                dataType: 'json',
                type: 'get',
                data: {
                    friendID: friendID
                },
                success: function (data) {
                    console.log(data);
                    alert('关注好友' + friendID + "成功");
                    window.location.reload();
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        function friendClick(id) {
            var friendID = $('#' + id).html();
            $.ajax({
                url: "http://localhost:90/MyNote/public/share/removeFriend",
                dataType: 'json',
                type: 'get',
                data: {
                    friendID: friendID
                },
                success: function (data) {
                    console.log(data);
                    alert('取消关注' + friendID + "成功");
                    window.location.reload();
                },
                error: function (data) {
                    console.log(data);
                }
            });
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
    <ul id="myTab" class="nav nav-tabs">
        <li class="active">
            <a href="#find" data-toggle="tab">关注用户</a>
        </li>
        <li>
            <a href="#myfriend" data-toggle="tab">我的好友</a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="find">
            <div class="search-user">
                <div class="input-group input-group-lg">
                    <input class="form-control" type="text" id="search-user-name-input" name="search-user-name"
                           placeholder="查找用户"
                           aria-describedby="sizing-addon1" required/>
                    <span class="input-group-btn">
                        <button class="btn btn-default" id="user-search-a-id" type="button">
                            <span class="user-search-g glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </div>
            <div class="list-group user-info-list" id="user-info-list-id"></div>
            <div class="miss-result-show-user" id="miss-result-show-user-id" hidden>
                <p class="text-center">喔喔！ 未找到用户</p>
            </div>
        </div>
        <div class="tab-pane fade in" id="myfriend">
            <div class="search-friend">
                <div class="input-group input-group-lg">
                    <input class="form-control" type="text" id="search-friend-name-input" name="search-friend-name"
                           placeholder="查找好友"
                           aria-describedby="sizing-addon1" required/>
                    <span class="input-group-btn">
                        <button class="btn btn-default" id="friend-search-a-id" type="button">
                            <span class="friend-search-g glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </div>
            <div class="list-group friend-info-list" id="friend-info-list-id"></div>
            <div class="miss-result-show-friend" id="miss-result-show-friend-id" hidden>
                <p class="text-center">喔喔！ 未找到好友</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>