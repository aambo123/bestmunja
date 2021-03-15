<div class="home">
    <video muted autoplay loop id="main_video" src="/assets/main.mov"></video>
    <div class="container">
    <h2 class="txt-center">
    GhostSMS<small>는 최고의</small> 익명성<small>과</small> 보안<small>을 중요시합니다</small>
    </h2>
    </div>
</div>

<script>
    $(function(){
        $('header').addClass("fixed");
        $('.app-footer').addClass("fixed");
    })
    

</script>
<style>
    #loading.playing {
        opacity: 1;
        transition: opacity 3s ease;
    }

    #loading {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin: auto;
        height: 100%;
        z-index: 100;
        opacity: 0;
        transition: opacity 3s ease;
    }
</style>

<script src="/assets/js/jquery.tmpl.min.js"></script>
<script id="popupTmpl" type="text/x-jquery-tmpl">
	<div class="modal large">
		<div class="modal_header">
			<h5 class="modal_title">${subject} </h5>
			<button type="button" onclick="closeModal(${popup_seq})" class="close">
			</button>
		</div>
		<div class="modal_body">
            <a href="${link_url}" target="_blank">
			{{html body}} 
            </a>
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