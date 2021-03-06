<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>您的笔记</title>

    <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
    <link href="{{ URL::asset('css/bootstrap-low.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('css/nav_top.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('css/note/noteinfo.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-low.js') }}"></script>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.ttf')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff2')}}"/>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/note/noteinfo.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $.ajax({
                url: "http://localhost:90/MyNote/public/note/getNote",
                dataType: 'json',
                type: 'get',
                data: {
                    noteID: '{{$noteID}}',
                    notebookID: '{{$notebookID}}'
                },
                success: function (data) {
                    console.log(data);
                    $('#name-tag-show-notebook').html('笔记本：' + '{{$notebookID}}');
                    $('#name-tag-show-tag').html('标签：' + data.tagID);
                    $('#note-modify-title-input').val('{{$noteID}}');
                    $('#summernote-note').html(data.note);
                },
                error: function (data) {
                    console.log(data);
                }
            });
            $('#note-confirm').click(function () {
                var new_noteID = $('#note-modify-title-input').val();
                var old_noteID = '{{$noteID}}';
                var new_notebookID = $('#showNotebook-note').html().split("：")[1];
                var old_notebookID = '{{$notebookID}}';
                var note = $('#summernote-note').summernote('code');
                var tagID = $('#showTag-note').html().split("：")[1];
                $.ajax({
                    url: "http://localhost:90/MyNote/public/note/modifyNote",
                    dataType: 'json',
                    type: 'post',
                    data: {
                        new_noteID: new_noteID,
                        old_noteID: old_noteID,
                        new_notebookID: new_notebookID,
                        old_notebookID: old_notebookID,
                        note: note,
                        tagID: tagID
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.result === 'success') {
                            $('#note-operation-id').show();
                            $('#confirm-note-id').hide();
                            $('#note-modify-title-input').attr('disabled', 'disabled');
                            $('#note-bookname-id').hide();
                            $('#note-tagname-id').hide();
                            $('#name-tag-show-id').show();
                            $('#name-tag-show-notebook').html('笔记本：' + new_notebookID);
                            $('#name-tag-show-tag').html('标签：' + tagID);
                            $('#summernote-note').summernote('destroy');
                        } else {
                            alert('请查看你的笔记名，笔记本名，笔记重复了');
                        }
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
    <div class="modal fade in remove-note-hints-show" id="remove-note-hints-show-id" style="display: none; ">
        <div class="modal-body">
            <p>删除笔记就找不回来了喔！</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-info" data-dismiss="modal">取消</a>
            <a href="#" class="btn btn-success" id="remove-note-id" onclick="remove_note_confirm()">确认</a>
        </div>
    </div>
    <div class="note-head">
        <div class="name-tag-show" id="name-tag-show-id">
            <p class="btn btn-primary" id="name-tag-show-notebook"></p>
            <p class="btn btn-primary" id="name-tag-show-tag"></p>
        </div>
        <div class="btn-group note-bookname" id="note-bookname-id" style="display: none">
            <button type="button" class="btn btn-primary note-bookname-input" id="showNotebook-note"></button>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only"></span>
            </button>
            <ul class="dropdown-menu" role="menu" id="notebook-menu"></ul>
        </div>
        <div class="btn-group note-tagname" id="note-tagname-id" style="display: none">
            <button type="button" class="btn btn-primary note-tagname-input" id="showTag-note"></button>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only"></span>
            </button>
            <ul class="dropdown-menu" role="menu" id="tag-menu"></ul>
        </div>
        <div class="note-operation" id="note-operation-id">
            <a class="modify-note" id="modify-note-id" href="#" onclick="show_note_modify()">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            </a>
            <a class="remove-note" href="#remove-note-hints-show-id" data-toggle="modal">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </a>
        </div>
        <div class="confirm-note" id="confirm-note-id" hidden>
            <button class="confirm-cancel btn btn-info" id="note-cancel" onclick="modify_note_cancel()">取消</button>
            <button class="confirm-save btn btn-success" id="note-confirm">完成</button>
        </div>
    </div>
    <div class="note-content">
        <div class="note-title">
            <input class="note-title-new" id="note-modify-title-input" type="text" name="note_title" placeholder="写下标题吧"
                   disabled='disabled' required/>
        </div>
        <div id="summernote-note" class="summer-note" onclick="show_note_modify()"></div>
    </div>
</div>
</body>
</html>