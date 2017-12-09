function changeConfirm() {
    $('#notebook-name-input').bind('input propertychange', function () {
        if($('#notebook-name-input').val() === ""){
            $('#confirm').attr('disabled',true);
        } else{
            $('#confirm').removeAttr('disabled');
        }
    })
}