<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>好友的笔记</title>

    <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
    <link href="{{ URL::asset('css/bootstrap-low.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('css/nav_top.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('css/share/noteCheck.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-low.js') }}"></script>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.ttf')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff2')}}"/>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/share/noteCheck.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $.ajax({
                url: "http://localhost:90/MyNote/public/share/getFriendNote",
                dataType: 'json',
                type: 'get',
                data: {
                    friendID: '{{$friendID}}',
                    noteID: '{{$noteID}}',
                    notebookID: '{{$notebookID}}'
                },
                success: function (data) {
                    console.log(data);
                    $('#user-name-tag-show-user').html('好友：' + '{{$friendID}}');
                    $('#user-name-tag-show-notebook').html('笔记本：' + '{{$notebookID}}');
                    $('#user-name-tag-show-tag').html('标签：' + data.tagID);
                    $('#note-check-title-input').val('{{$noteID}}');
                    $('#summernote-note-check').html(data.note);
                },
                error: function (data) {
                    console.log(data);
                }
            });
            $('#note-search-head-id').click(function () {
                var info = $('#note-search-info-head-id').val();
                window.close();
                window.open('http://localhost:90/MyNote/public/tag/showSearchResult?info=' + info, '_self');
            });
        });

        function click_return() {
            window.close();
            window.open('http://localhost:90/MyNote/public/share/showFriendNotes', '_self');
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
    <div class="note-head">
        <div class="user-name-tag-show" id="user-name-tag-show-id">
            <p class="btn btn-primary" id="user-name-tag-show-user"></p>
            <p class="btn btn-primary" id="user-name-tag-show-notebook"></p>
            <p class="btn btn-primary" id="user-name-tag-show-tag"></p>
        </div>
        <div class="note-return" id="note-return-id">
            <button class="return btn btn-info" id="return-id" onclick="click_return()">返回</button>
        </div>
    </div>
    <div class="note-content">
        <div class="note-title">
            <input class="note-title-new" id="note-check-title-input" type="text" name="note_title" placeholder="写下标题吧"
                   disabled='disabled' required/>
        </div>
        <div id="summernote-note-check" class="summer-note-check"></div>
    </div>
</div>
</body>
</html>