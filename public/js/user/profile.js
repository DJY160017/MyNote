function showSave() {
    document.getElementById('password-save').style.display = 'inline';
    document.getElementById('password-modify').style.display = 'none';
    $("#profile-password-new").removeAttr('disabled');
    $("#profile-password-again").removeAttr('disabled');
}

function showModify() {
    document.getElementById('password-save').style.display = 'none';
    document.getElementById('password-modify').style.display = 'inline';
    $("#profile-password-new").attr('disabled', true);
    $("#profile-password-again").attr('disabled', true);
}

function openUpload() {
    $('#file').click();
}