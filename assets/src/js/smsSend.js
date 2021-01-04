$(document).ready(function () {
    $('#message').on('keyup', function(){
        var countText = $(this).val().length;
        var ct = countText / 70;
        var buhel = Math.ceil(ct);
        $('.inner-bytes').text(countText + ' : '+ buhel + ' SMS Message(s)');
        $('#text_lenght').val(countText);

        if (countText >= 70) {
            $(".message-count").css("display", "block");
        } else {
            $(".message-count").css("display", "none");
        }
    });

    $('#btn-upload').click(function(){
        $("input:file").click();
    });

    $('input:file').on('change', function(){
        var val = $(this)[0].files[0].name;
        $('#file-name').text(val);
    })

    $('#send-btn').on('click', function(){
        var text_lenght = $('#text_lenght').val();
        if(text_lenght > 70){
            if(confirm("입력한 문자가 70자를 넘어가면 매 70자마다 추가로 과금이 됩니다. 계속 진행 하시겠습니까?") === true){
                $('#loader').addClass('visible');
                if ($('#excel').get(0).files.length === 0) {
                    var fl = 0;
                }else{
                    var fl = 1;
                }
                var data = new FormData();
                data.append("body", $('#message').val());
                data.append('mno', $('#recipient-number').val());
                data.append('sid', $('#sender-number').val());
                data.append("fl", fl);
                data.append("file", $('input:file')[0].files[0]);

                
                $.ajax({
                    url: '/users/send_msg',
                    type: "POST",
                    data: data,
                    contentType: false,
                    processData: false,
                    cache: false,
                    async: true,

                    success: function(data){

                        $('#loader').removeClass('visible');
                        console.log(data);
                        if(data == 3){
                            alert('메시지를 입력해주세요.');
                        }
                        if(data == 4){
                            alert('수신번호가 비어있다. ');
                        }
                        if(data == 5){
                            alert('CASH 부족합니다');
                        }
                        if(data == 6){
                            alert('발신번호가 입력해주세요.');
                        }
                        if(data == 11){
                            alert('잔액이 부족합니다. 관리자에게 문의를 하세요.');
                        }
                        if(data == 2){
                            min = Math.ceil('10000000000');
                            max = Math.floor('99999999999');
                            var random_number = Math.floor(Math.random() * (max - min + 1)) + min;
                            //console.log(random_number);
                            $('#sender-number').val(random_number);
                            alert('문자 발송 완료 했습니다.');
                            $('#recipient-number').val('');
                            $("#excel").val('');

                            //location.reload();
                        }
                        if(data == 10){
                            alert('전화번호가 중복되어 생략되었습니다.');
                        }
                        if(data == 12){
                            alert('추천 가격이 없습니다. 관리자에게 문의하십시오.');
                        }
                        //alert(data);
                    }
                });
            }else{
                return false;
            }

        }else{
            $('#loader').addClass('visible');
            if ($('#excel').get(0).files.length === 0) {
                var fl = 0;
            }else{
                var fl = 1;
            }
            var data = new FormData();
            data.append("body", $('#message').val());
            data.append('mno', $('#recipient-number').val());
            data.append('sid', $('#sender-number').val());
            data.append("fl", fl);
            data.append("file", $('input:file')[0].files[0]);
            $.ajax({
                url: '/users/send_msg',
                type: "POST",
                data: data,
                contentType: false,
                processData: false,
                cache: false,
                async: true,

                success: function(data){

                    $('#loader').removeClass('visible');
                    console.log(data);
                    if(data == 3){
                        alert('메시지를 입력해주세요.');
                    }
                    if(data == 4){
                        alert('수신번호가 비어있다. ');
                    }
                    if(data == 5){
                        alert('CASH 부족합니다');
                    }
                    if(data == 6){
                        alert('발신번호가 입력해주세요.');
                    }
                    if(data == 11){
                        alert('잔액이 부족합니다. 관리자에게 문의를 하세요.');
                    }
                    if(data == 2){
                        min = Math.ceil('10000000000');
                        max = Math.floor('99999999999');
                        var random_number = Math.floor(Math.random() * (max - min + 1)) + min;
                        //console.log(random_number);
                        $('#sender-number').val(random_number);
                        alert('메시지를 보냈습니다. 통신사 사정에 따라 조금 지연될수도 있습니다.');
                        $('#recipient-number').val('');
                        $("#excel").val('');

                        //location.reload();
                    }

                    if(data == 10){
                        alert(' 전화번호가 중복되어 생략되었습니다.');
                    }
                    if(data == 12){
                        alert('추천 가격이 없습니다. 관리자에게 문의하십시오.');
                    }
                }
            });

        }


        // alert("메세지 전송요청에 성공하였습니다. 결과페이지에서 결과 확인이 가능합니다.");
        // location.replace(window.location.origin+'/bbs/board.php?bo_table=SmsRequests');
    })

    function toUnicode(theString) {
        var unicodeString = '';
        for (var i=0; i < theString.length; i++) {
            var theUnicode = theString.charCodeAt(i).toString(16).toUpperCase();
            while (theUnicode.length < 4) {
                theUnicode = '0' + theUnicode;
            }
            unicodeString += theUnicode;
        }
        return unicodeString;
    }
});
