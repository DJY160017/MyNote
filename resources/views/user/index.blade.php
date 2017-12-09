<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>记你所想</title>

    <style>
        body {
            background-size: cover;
            background-image: url('{{URL::asset('images/background.png')}}');
            background-repeat: no-repeat;
            margin: auto;
        }
    </style>
    <script src="{{URL::asset("/")}}js/jquery-3.2.1.min.js"></script>
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/user/index.js') }}"></script>
    <link href="{{ URL::asset('css/user/index.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        //登录
        $(document).ready(function () {
            $("#login-button").click(function () {
                var username = $("#login-username").val();
                var password = $("#login-password").val();
                if (username === '') {
                    $("#login-username").css('border-color', 'lightcoral');
                    setTimeout(function () {
                        $("#login-username").css('border-color', '');
                    }, 4000);
                } else if (password === '') {
                    $("#login-password").css('border-color', 'lightcoral');
                    setTimeout(function () {
                        $("#login-password").css('border-color', '');
                    }, 4000);
                } else {
                    $.ajax({
                        url: "http://localhost:90/MyNote/public/login",
                        dataType: 'json',
                        type: 'post',
                        data: {
                            account: username,
                            password: password
                        },
                        success: function (data) {
                            console.log(data);
                            if (data.result === "success") {
                                window.close();
                                window.open('{{'note/create'}}', '_self');
                            } else if (data.result === '该用户不存在') {
                                $("#login-username").css('border-color', 'lightcoral');
                                setTimeout(function () {
                                    $("#login-username").css('border-color', '');
                                }, 4000);
                            } else {
                                $("#login-password").css('border-color', 'lightcoral');
                                setTimeout(function () {
                                    $("#login-password").css('border-color', '');
                                }, 4000);
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }
            });
        });

        //注册
        $(document).ready(function () {
            $("#signUp-button").click(function () {
                var username = $("#signUp-username").val();
                var password = $("#signUp-password").val();
                var password_again = $("#signUp-password-again").val();
                if (username === '') {
                    $("#signUp-username").css('border-color', 'lightcoral');
                    setTimeout(function () {
                        $("#signUp-username").css('border-color', '');
                    }, 4000);
                } else if (password !== password_again) {
                    $("#signUp-password").css('border-color', 'lightcoral');
                    $('#signUp-password').val("");
                    $("#signUp-password-again").css('border-color', 'lightcoral');
                    $('#signUp-password-again').val("");
                    setTimeout(function () {
                        $("#signUp-password").css('border-color', '');
                        $("#signUp-password-again").css('border-color', '');
                    }, 4000);
                } else {
                    $.ajax({
                        url: "http://localhost:90/MyNote/public/signUp",
                        dataType: 'json',
                        type: 'post',
                        data: {
                            account: username,
                            password: password
                        },
                        success: function (data) {
                            console.log(data);
                            if (data.result === "success") {
                                window.close();
                                window.open('{{'your_profile'}}', '_self');
                            } else {
                                $("#signUp-username").css('border-color', 'lightcoral');
                                $("#signUp-username").val("");
                                setTimeout(function () {
                                    $("#signUp-username").css('border-color', '');
                                }, 4000);
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }
            });
        });
    </script>
</head>
<body>
<div class="index-main">
    <div class="header">
        <div class="header-logo">
            <p class="logo" style="color: #0c5460;">E N O T E</p>
        </div>
        <div class="header-instruction">
            <p class="subtitle" style="color: #0c5460;">见你所见 记你所想</p>
        </div>
    </div>

    <div class="container">
        <div class="container-header">
            <a class="login-active" id="login-a" href="#Login" onclick="showLogIn()">登 录</a>
            <a class="signUp-active" id="signUp-a" href="#SignUp" onclick="showSignUp()">注 册</a>
        </div>
        <div class="loginPanel" id="logIn">
            <div class="index-input-login">
                <div class="input-group-vertical">
                    <input class="form-control" type="text" name="account" id="login-username" placeholder="请输入用户名"
                           required/>
                    <input class="form-control" type="password" name="password" id="login-password" placeholder="请输入密码"
                           required/>
                </div>
            </div>
            <div class="login">
                <button class="btn btn-info btn-lg form-control" id="login-button" type="button">登录</button>
            </div>
        </div>

        <div class="signUpPanel" id="signUp" style="display: none">
            <div class="index-input-signUp">
                <div class="input-group-vertical">
                    <input class="form-control" type="text" name="account" id="signUp-username" placeholder="请输入用户名"
                           required/>
                    <input class="form-control" type="password" name="password" id="signUp-password" placeholder="请输入密码"
                           required/>
                    <input class="form-control" type="password" name="password-again" id="signUp-password-again"
                           placeholder="请再输入密码"
                           required/>
                </div>
            </div>
            <div class="signUp">
                <button class="btn btn-info btn-lg form-control" id="signUp-button" type="submit">注册</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>