$(document).ready(function () {
    $('td[name=detail]').on('click', function(){
        var send_id = $(this).data('send-id');
        window.location.href = window.location.origin+'/users/SmsRequestView/'+send_id;
    })
});