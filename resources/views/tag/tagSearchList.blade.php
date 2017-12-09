<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>记你所想</title>

    <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
    <link href="{{ URL::asset('css/bootstrap-low.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-low.js') }}"></script>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.ttf')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff2')}}"/>
    <link href="{{ URL::asset('css/tag/tagSearchList.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('css/nav_top.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        $(document).ready(function () {
            var list = document.getElementById('tag-note-info-list-id');
            $.ajax({
                url: "http://localhost:90/MyNote/public/tag/search",
                dataType: 'json',
                type: 'get',
                data: {
                    info: '{{$info}}'
                },
                success: function (data) {
                    console.log(data);
                    if(data.length === 0){
                        $('#tag-miss-result-show-note-id').show();
                    } else {
                        for (var id in data) {
                            var a_id = 'note_a_' + id.toString();
                            var h_id = 'note_h_' + id.toString();
                            var p_id = 'note_p_' + id.toString();
                            var a = $("<a href='#' class=\"list-group-item\" onclick='tag_noteClick(\"" + h_id + "\", \"" + p_id + "\")'></a>");
                            var h_note = $("<h4 class=\"list-group-item-heading\"></h4>");
                            var p_notebook = $("<p class=\"list-group-item-text\"></p>");
                            var p_tag = $("<p class=\"list-group-item-text\"></p>");
                            var p_time = $("<p class=\"list-group-item-text\"></p>");
                            a.attr('id', a_id);
                            h_note.attr('id', h_id);
                            h_note.html(data[id][1]);
                            p_notebook.html("笔记本：" + data[id][0]);
                            p_notebook.attr('id', p_id);
                            p_tag.html("标签：" + data[id][2]);
                            p_time.html("创建时间：" + data[id][3]);
                            h_note.appendTo(a);
                            p_notebook.appendTo(a);
                            p_tag.appendTo(a);
                            p_time.appendTo(a);
                            a.appendTo(list);
                        }
                    }
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

        function tag_noteClick(note_id, notebook_id) {
            var noteID = $('#' + note_id).html();
            var notebookID = $('#' + notebook_id).text().split("：")[1];
            notebookID = notebookID.trim();
            var url = 'http://localhost:90/MyNote/public/note/showNote?noteID=' + noteID + '&notebookID=' + notebookID;
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
    <div class="notelist-title-line">
        <p class="notelist-notename">搜索结果</p>
    </div>
</div>
<div class="container">
    <div class="list-group note-info-list" id="tag-note-info-list-id"></div>
    <div class="miss-result-show-note" id="tag-miss-result-show-note-id" hidden>
        <p class="text-center">喔喔！ 未找到该标签的笔记</p>
    </div>
</div>
</body>
</html>