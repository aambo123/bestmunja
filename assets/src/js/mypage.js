$(document).ready(function () {
    $('#back-btn').on('click', function(){
        history.back();

    });

    $('#edit-btn').on('click', function(){
        var name = $('#__BVID__25').val();
        var curr_pass = $("#__BVID__26").val();
        var new_pass = $('#__BVID__27').val();
        var mb_id = $('#mb_id').val();

        if(!curr_pass){
            alert("기존 비밀번호를 입력해주세요.");
            return false;
        }

        if(!new_pass){
            alert("새 비밀번호를 입력해주세요.");
            return false;
        }

        $.ajax({
            url: '/users/mypage_save',
            type: "POST",
            data: {'mb_id': mb_id, 'name': name, 'curr_pass': curr_pass, 'new_pass': new_pass},
            dataType:'json',
            async: true,
            success: function(data){
                 if(data.status == 'done'){
                     alert('Succefully updated');
                     window.location.reload();

                 } else {
                     alert(data.status);
                 }
            }
        });

    });
});