<?php $text = array(
    "동종업계 최저가격","높은수신률과 정확한 결과 ","수신의 빠른 메시지","70글자의 여유있는 메시지","편리한 대량문자 발송","간편한 캐쉬충전"
)?>
<div class="main_banner">
    <div class="container">
        <h1>
            24시간 발송 제한 없는 <br>
            최저가격 국제문자 발송!
        </h1>
        <p>
대량문자도 한 번의 업로드로 손 쉽게 발송 가능!
        </p>
    </div>
</div>
<div class="container">
    <div class="row">
<?php
    for ($x = 0; $x < count($text); $x++) {
?>
        <div class="col-6 col-sm-4">
            <div class="home-col">
                <div class="img">
                    <img src="/assets/images/main_icon<?php echo $x+1?>.png" alt="">
                </div>
                <p class="">
                    <?php echo $text[$x]?>
                </p>
            </div>
        </div>
<?php
    }
?>
    </div>
</div>
<div class="telegram-wrap">
    <img src="/assets/images/telegram.png" alt="">
    <h1>텔레그램 상담 ID : tagoplus</h1>
</div>

<script src="/assets/js/jquery.tmpl.min.js"></script>
<script id="popupTmpl" type="text/x-jquery-tmpl">
	<div class="modal large">
		<div class="modal_header">
			<h5 class="modal_title">${subject} </h5>
			<button type="button" onclick="closeModal(${popup_seq})" class="close">
			</button>
		</div>
		<div class="modal_body">
			{{html body}} 
		</div>
		<div class="modal_footer">
			<a onclick="javascript:closePopupNotToday(${popup_seq});"  class="btn-link mr-auto text-sm font-weight-400">오늘 하루동안 보지 않기</a>
			<button type="button" style="float:right" class="btn btn-secondary"  onclick="closeModal(${popup_seq})">닫기</button>
		</div>
	</div>
</script>

<script>
	$(function(){
		$.ajax({
			url: '/ajax/get_popup',
			type: "POST",
			contentType: false,
			processData: false,
			cache: false,
			async: true,
			success: function(data){
				data = JSON.parse(data);
				console.log(data)
				try {
					$(data).each(function(i, el) {
						if (GetCookie('popCookie' + el.popup_seq) == 'Y')
							return true;

						var $layer = $('<div id="popup'+ el.popup_seq +'" class="modal_wrapper '+ el.popup_seq +'">');
						$('#popupTmpl').tmpl(el).appendTo($layer);
						$(document.body).append($layer);
						$('#popup'+el.popup_seq).addClass("show")
						
					});
				} catch (error) {
					console.log(error)
				}
			}
		})

	})

	function closePopupNotToday(seq) {
		$('#popup' + seq).removeClass("show")
		var expired = getDateByjQueryDateFormat('1d');
		SetCookie('popCookie' + seq, 'Y', null, null, expired);
	}

	function closeModal(seq){
		$('#popup' + seq).removeClass("show")
	}
</script>