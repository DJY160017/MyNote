<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>记你所想</title>

    <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
    <link href="{{ URL::asset('css/bootstrap-low.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('css/nav_top.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('css/note/note.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-low.js') }}"></script>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.ttf')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff2')}}"/>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/note/note.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#summernote').summernote({
                height: 400,
                placeholder: 'Hi! here start your note...',
                dialogsFade: true,
                dialogsInBody: true,
                disableDragAndDrop: true,
                focus: true
            });
            $.ajax({
                url: "http://localhost:90/MyNote/public/note/getInitNotebookInfo",
                dataType: 'json',
                type: 'get',
                success: function (data) {
                    console.log(data);
                    var menu = document.getElementById('notebook-menu');
                   for(var id in data){
                       var li = $("<li></li>");
                       var a_id = 'notebook_'+id.toString();
                       var a = $("<a onclick='menuClick(\""+a_id+"\",\"#showNotebook\")'></a>");
                       a.html(data[id]);
                       a.attr('id',a_id);
                       a.appendTo(li);
                       li.appendTo(menu);
                   }
                },
                error: function (data) {
                    console.log(data);
                }
            });
            $.ajax({
                url: "http://localhost:90/MyNote/public/note/getInitTagInfo",
                dataType: 'json',
                type: 'get',
                success: function (data) {
                    console.log(data);
                    var menu = document.getElementById('tag-menu');
                    for(var id in data){
                        var li = $("<li></li>");
                        var a_id = 'tag_'+id.toString();
                        var a = $("<a onclick='menuClick(\""+a_id+"\",\"#showTag\")'></a>");
                        a.html(data[id]);
                        a.attr('id', a_id);
                        a.appendTo(li);
                        li.appendTo(menu);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
            $('#note-confirm').click(function () {
                var title = $('#note-title-input').val();
                var notebook = $('#showNotebook').html();
                var tag = $('#showTag').html();
                var note = $('#summernote').summernote('code');
                if(title === ''){
                    alert('请填写您的标题');
                }else if(note === ''){
                    alert('请填写笔记内容');
                } else if(notebook === '@您的笔记本'){
                    alert('请选择笔记本或者创建一个');
                } else if(tag === "@您的标签"){
                    alert('请选择标签或者创建一个');
                } else{
                    $.ajax({
                        url: "http://localhost:90/MyNote/public/note/createNote",
                        dataType: 'json',
                        type: 'post',
                        data: {
                            notebook: notebook,
                            tag: tag,
                            title: title,
                            note: note
                        },
                        success: function (data) {
                            console.log(data);
                            if(data.result === 'success'){
                                alert('保存成功');
                                window.close();
                                window.open('{{url('note/create')}}','_self')
                            } else{
                                alert('该笔记已有了，换个名字吧！');
                                $("#note-title-input").css('border-color', 'lightcoral');
                                $('#note-title-input').val("");
                                setTimeout(function () {
                                    $("#note-title-inputd").css('border-color', '');
                                }, 4000);
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

        function menuClick(id, menuID){
            var value = document.getElementById(id).innerHTML;
            $(menuID).html(value);
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
        <div class="btn-group note-bookname">
            <button type="button" class="btn btn-primary note-bookname-input" id="showNotebook">@您的笔记本</button>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only"></span>
            </button>
            <ul class="dropdown-menu" role="menu" id="notebook-menu">
                <li>
                    <a class="notebook-plus-a" href="{{url('notebook/create')}}">
                        <span class="note-plus glyphicon glyphicon-plus">新建笔记本</span>
                    </a>
                </li>
                <li role="presentation" class="divider"></li>
            </ul>
        </div>
        <div class="btn-group note-tagname">
            <button type="button" class="btn btn-primary note-tagname-input" id="showTag">@您的标签</button>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only"></span>
            </button>
            <ul class="dropdown-menu" role="menu" id="tag-menu">
                <li>
                    <a class="tag-plus-a" href="{{url('tag/create')}}">
                        <span class="note-plus glyphicon glyphicon-plus">新建标签</span>
                    </a>
                </li>
                <li role="presentation" class="divider"></li>
            </ul>
        </div>
        <div class="confirm">
            <button class="confirm-save btn btn-success" id="note-confirm">完成</button>
        </div>
    </div>
    <div class="note-content">
        <div class="note-title">
            <input class="note-title-new" id="note-title-input" type="text" name="note_title" placeholder="写下标题吧" required/>
        </div>
        <div id="summernote" class="summer-note"></div>
    </div>
</div>
</body>
</html>