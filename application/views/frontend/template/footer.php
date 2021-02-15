<div class="right-fixed">
    <a class="customer" href="https://t.me/ghostsms">
        <div class="img">
            <img src="/assets/images/telegram.png" alt="">
        </div>
        <p>고객센터</p>
    </a>
    <a class="telegram" href="https://t.me/ghostsms">
        <div class="img">
            <img src="/assets/images/customer.png" alt="">
        </div>
        <p>ID : ghostsms</p>
    </a>
</div>
<footer class="app-footer py-3">
	<div class="container">
		<div class="footer-copyright">
			<p class="font-weight-bold txt-center">© 2019 - <?php echo date('Y');?> 1stBulk. ALL RIGHTS RESERVED.</p>
		</div>
	</div>
</footer>
</div>
</main>

</div>

<script src="/assets/js/jquery.tmpl.min.js"></script>
<script id="popupTmpl" type="text/x-jquery-tmpl">
	<div class="modal modal-medium">
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
</body>

</html>