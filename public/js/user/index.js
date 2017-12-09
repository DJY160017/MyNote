function showLogIn() {
    document.getElementById('signUp').style.display = 'none';
    document.getElementById('logIn').style.display = 'inline';
    document.getElementById('login-a').style.textDecoration = 'underline';
    document.getElementById('signUp-a').style.textDecoration = 'none';
    document.getElementById('login-a').style.fontWeight = '600';
    document.getElementById('signUp-a').style.fontWeight = '100';
}

function showSignUp() {
    document.getElementById('signUp').style.display = 'inline';
    document.getElementById('logIn').style.display = 'none';
    document.getElementById('signUp-a').style.textDecoration = 'underline';
    document.getElementById('login-a').style.textDecoration = 'none';
    document.getElementById('login-a').style.fontWeight = '100';
    document.getElementById('signUp-a').style.fontWeight = '600';
}