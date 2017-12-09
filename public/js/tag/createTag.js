function changeConfirm() {
    $('#tag-name-input').bind('input propertychange', function () {
        if ($('#tag-name-input').val() === "") {
            $('#confirm').attr('disabled', true);
        } else {
            $('#confirm').removeAttr('disabled');
        }
    })
}