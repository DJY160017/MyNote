<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>您的个人信息</title>

    <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
    <link href="{{ URL::asset('css/bootstrap-low.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-low.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/user/profile.js') }}"></script>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.ttf')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff')}}"/>
    <link href="{{URL::asset('fonts/glyphicos-halflings-regular.woff2')}}"/>
    <link href="{{ URL::asset('css/nav_top.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('css/user/profile.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        //填写资料
        $(document).ready(function () {
            $.ajax({
                url: "http://localhost:90/MyNote/public/getUserInfo",
                dataType: 'json',
                type: 'post',
                success: function (data) {
                    console.log(data);
                    $('#profile-mail-input').val(data.mail);
                    $('#profile-introduction-input').val(data.introduction);
                    $('#profile-password-new').val(data.password);
                    $('#profile-password-again').val(data.password);
                    $('#user-head-img').attr('src', data.headportrait);
                },
                error: function (data) {
                    console.log(data);
                }
            });
            $('#password-save').click(function () {
                var password = $('#profile-password-new').val();
                var password_again = $('#profile-password-again').val();
                if (password === '' || password_again === '') {
                    $("#profile-password-new").css('border-color', 'lightcoral');
                    $('#profile-password-new').val("");
                    $("#profile-password-again").css('border-color', 'lightcoral');
                    $('#profile-password-again').val("");
                    setTimeout(function () {
                        $("#profile-password-new").css('border-color', '');
                        $("#profile-password-again").css('border-color', '');
                    }, 4000);
                } else if (password !== password_again) {
                    $("#profile-password-again").css('border-color', 'lightcoral');
                    $('#profile-password-again').val("");
                    setTimeout(function () {
                        $("#profile-password-again").css('border-color', '');
                    }, 4000);
                } else {
                    $.ajax({
                        url: "http://localhost:90/MyNote/public/modifyPassword",
                        dataType: 'json',
                        type: 'post',
                        data: {
                            password: password
                        },
                        success: function (data) {
                            console.log(data);
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
            $('#profile-save-button').click(function () {
                var mail = $('#profile-mail-input').val();
                var introduction = $('#profile-introduction-input').val();
                if (mail === '' && introduction === '') {
                    $("#profile-mail-input").css('border-color', 'lightcoral');
                    $("#profile-introduction-input").css('border-color', 'lightcoral');
                    setTimeout(function () {
                        $("#profile-mail-input").css('border-color', '');
                        $("#profile-introduction-input").css('border-color', '');
                    }, 4000);
                } else if (mail === '') {
                    $("#profile-mail-input").css('border-color', 'lightcoral');
                    setTimeout(function () {
                        $("#profile-mail-input").css('border-color', '');
                    }, 4000);
                } else if(introduction === ''){
                    $("#profile-introduction-input").css('border-color', 'lightcoral');
                    setTimeout(function () {
                        $("#profile-introduction-input").css('border-color', '');
                    }, 4000);
                } else {
                    $.ajax({
                        url: "http://localhost:90/MyNote/public/modifyProfile",
                        dataType: 'json',
                        type: 'post',
                        data: {
                            mail: mail,
                            introduction: introduction
                        },
                        success: function (data) {
                            console.log(data);
                            if(data.result !== '邮箱格式不正确'){
                                alert('保存成功');
                            }else {
                                alert('请检查您的邮箱格式');
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }
            });
        });

        function selectImage(file) {
            var image = '';
            if (!/image\/\w+/.test(file.files[0].type)) {
                alert('请确保文件为图像类型');
                return;
            }
            var reader = new FileReader();
            reader.readAsDataURL(file.files[0]);
            reader.onload = function (e) {
                image = this.result;
                $.ajax({
                    url: 'http://localhost:90/MyNote/public/uploadHead',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        image: image
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.result === 'success') {
                            $('#user-head-img').attr('src', image);
                        } else {
                            alert('Oops, one error occur,please refresh')
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            };
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
    <div class="profile-tile">
        <p class="profile-title-p">个人资料</p>
    </div>
</div>
<div class="container">
    <div class="profilePanel">
        <div class="profile-input">
            <div class="mail">
                <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon1 ">您的邮箱:</span>
                    <input class="form-control" type="text" name="mail" placeholder="请输入邮箱" id="profile-mail-input"
                           aria-describedby="sizing-addon1" required/>
                </div>
            </div>
            <div class="introduction">
                <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon1">自我介绍:</span>
                    <input class="form-control" type="text" name="introduction" placeholder="一句话介绍一下自己"
                           id="profile-introduction-input"
                           aria-describedby="sizing-addon1" required/>
                </div>
            </div>
        </div>
        <div class="profile-save">
            <button class="btn btn-info btn-lg form-control" id="profile-save-button" type="button">保存</button>
        </div>
        <div class="user-head">
            <img class="img-thumbnail user-head-img-class" id="user-head-img"
                 src="{{URL::asset('images/default.jpg')}}">
            <input type="file" style="display: none" accept="image/jpeg,image/vnd.svf,image/png" name="file" id="file"
                   onchange="selectImage(this)"/>
            <button class="push-head btn btn-info" onclick="openUpload()">上传头像</button>
        </div>
    </div>
</div>
<div class="container">
    <div class="password-tile">
        <p class="password-title-p">修改密码</p>
    </div>
</div>
<div class="container">
    <div class="profile-password-panel" id="profile-password">
        <form method="POST">
            <div class="profile-input-modify_password">
                <div class="input-group-vertical">
                    <input id="profile-password-new" class="form-control" type="password" name="password"
                           placeholder="请输入密码" disabled='disabled' required/>
                    <input id="profile-password-again" class="form-control" type="password" name="password-again"
                           placeholder="请再输入密码" disabled="disabled" required/>
                </div>
            </div>
        </form>
        <div class="profile-password-button">
            <div class="profile-password-modify" id="password-modify" onclick="showSave()">
                <button class="btn btn-info btn-lg">修改</button>
            </div>
            <div class="profile-password-save" id="password-save" onclick="showModify()" hidden="hidden">
                <button class="btn btn-info btn-lg">保存</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>