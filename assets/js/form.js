$('#pass').keyup(function(){
     var $this = $(this);
     var val = $this.val();
     var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
     var mediumRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");
     var score;

     if (mediumRegex.test(val)) {
          valid($this)
     }else {
          invalid($this,'비밀번호 약합니다.')
     }
})
$('#pass_check').keyup(function(){
     var $this = $(this);
     var pass = $('#pass').val();
     var pass_check = $this.val()
     if (pass==pass_check) {
          valid($this)
     }else {
          invalid($this,'not same')
     }
})
$('input.form-control').focusin(function(){
     $(this).removeClass('valid invalid');
     $(this).next('.validation').html('');
     $(this).nextAll('.error_msg').html('');
})

$('#user_id').focusout(function(id){
     var user_id = $('#user_id').val();
     var $this = $(this);
     $.ajax({
          type: "POST",
          data: {'mb_id':user_id},
          url: "/home/check_user_id",
          cache: false,
          dataType:'html',
          async: true,
          success: function (data) {
               if(data != true) {
                    invalid($this,data);
               }else {
                    valid($this);
               }
          }
     });
     return false;
});
function valid(e){
     e.removeClass('invalid')
     e.addClass('valid');
     e.next('.validation').html('<i data-feather="check-square" color="#4bb5b3"></i>')
     e.nextAll('.error_msg').html('');
     feather.replace();
};
function invalid(e,data){
     e.removeClass('valid');
     e.addClass('invalid');
     e.next('.validation').html('<i data-feather="alert-circle" color="#f44336"></i>')
     feather.replace();
     e.parent().find('.error_msg').html(data);
};
$('#mb_email').focusout(function(id){
    var mb_email = $('#mb_email').val();
    var $this = $(this);
    $.ajax({
        type: "POST",
        data: {'mb_email':mb_email},
        url: "/home/check_user_email",
        cache: false,
        dataType:'html',
        async: true,
        success: function (data) {
             if(data != true) {invalid($this,data);}else {valid($this);}
        }
    });
    return false;
})

$('#referral').focusout     (function(id){
     var $this = $(this);
     var referral = $('#referral').val();
     $.ajax({
          type: "POST",
          data: {'referral':referral},
          url: "/home/check_user_referral",
          cache: false,
          dataType:'html',
          async: true,
          success: function (data) {
               if(data != true) {invalid($this,data);}else {valid($this);}
          }
    });
    return false;
})

$('#reseller_code').focusout(function(id){
     var $this = $(this);
     var reseller_code = $('#reseller_code').val();
     $.ajax({
          type: "POST",
          data: {'reseller_code':reseller_code},
          url: "/home/check_user_reseller_code",
          cache: false,
          dataType:'html',
          async: true,
          success: function (data) {
               if(data != true) {invalid($this,data);}else {valid($this);}
          }
    });
    return false;
})