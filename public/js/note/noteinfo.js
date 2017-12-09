function show_note_modify() {
    $('#note-operation-id').hide();
    $('#confirm-note-id').show();
    $('#note-modify-title-input').removeAttr('disabled');
    $('#note-bookname-id').show();
    $('#note-tagname-id').show();
    $('#name-tag-show-id').hide();
    $('#showNotebook-note').html($('#name-tag-show-notebook').html());
    $('#showTag-note').html($('#name-tag-show-tag').html());
    $('#summernote-note').summernote({
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
            $('#notebook-menu').html("");
            var menu = document.getElementById('notebook-menu');
            for (var id in data) {
                var li = $("<li></li>");
                var a_id = 'notebook_' + id.toString();
                var a = $("<a onclick='menu_notebook_Click(\"" + a_id + "\",\"#showNotebook-note\")'></a>");
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
    $.ajax({
        url: "http://localhost:90/MyNote/public/note/getInitTagInfo",
        dataType: 'json',
        type: 'get',
        success: function (data) {
            console.log(data);
            $('#tag-menu').html("");
            var menu = document.getElementById('tag-menu');
            for (var id in data) {
                var li = $("<li></li>");
                var a_id = 'tag_' + id.toString();
                var a = $("<a onclick='menu_tag_Click(\"" + a_id + "\",\"#showTag-note\")'></a>");
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
}

function menu_notebook_Click(id, menuID) {
    var value = document.getElementById(id).innerHTML;
    $(menuID).html('笔记本：'+value);
}

function menu_tag_Click(id, menuID) {
    var value = document.getElementById(id).innerHTML;
    $(menuID).html('标签：'+value);
}

function modify_note_cancel() {
    $('#note-operation-id').show();
    $('#confirm-note-id').hide();
    $('#note-modify-title-input').attr('disabled', 'disabled');
    $('#note-bookname-id').hide();
    $('#note-tagname-id').hide();
    $('#name-tag-show-id').show();
    $('#summernote-note').summernote('destroy');
}

function remove_note_confirm(){
    var notebookID = $('#name-tag-show-notebook').html().split("：")[1];
    var noteID = $('#note-modify-title-input').val();
    $.ajax({
        url: "http://localhost:90/MyNote/public/note/removeNote",
        dataType: 'json',
        type: 'get',
        data:{
          notebookID: notebookID,
          noteID: noteID
        },
        success: function (data) {
            console.log(data);
            window.close();
            window.open('http://localhost:90/MyNote/public/note/notelist?notebookID='+notebookID,'_self')
        },
        error: function (data) {
            console.log(data);
        }
    });
}