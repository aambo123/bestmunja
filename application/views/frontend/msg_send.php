<script src="<?php echo base_url(); ?>assets/src/js/smsSend.js"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<section class="send_main">
	<div class="lottie_wrapper" style="display:none">
		<lottie-player src="https://assets8.lottiefiles.com/datafiles/DlRM2jtACyr4IX1u6l5rqtW1QWZKLCkNoBIXWeyH/loading.json"
			background="#fff" speed="1" style="height: 300px;width: 300px" loop autoplay>
		</lottie-player>
	</div>
	<div class="container h-100">
		<form action="" method="post" enctype="multipart/form-data" class="send_wrap">
			<input type="hidden" name="user_id" value="<?php echo $user->mb_no; ?>">

            <div class="phone_wrapper">
                <div class="message-count" style="display: none;">
                입력한 문자가 70자를 넘어가면 매 67자 마다 추가로 과금이 됩니다. 
                </div>
                <div class="phone">
                    <textarea required class="text_area" id="message" name="body" rows="8" cols="80"
                        required="required"></textarea>
                    <span class="line"></span>
                    <span class="inner-bytes">0 : 0 SMS Message(s)</span>
                    <div class="buttons">
                        <a href="javascript:reloadText()">새로입력</a>
                        <a href="javascript:openSpecial()">특수문자</a>
                    </div>
                </div>
            </div>

            <div class="send_wrapper">
                <h1><span>수신번호</span>를 직접 입력하거나 <br> <span>파일로 업로드</span>하여 문자를 발송하세요.</h1>
            
                        <style>
                            .visible {
                                display: flex !important;
                                display: -ms-flex !important;
                            }

                        </style>
                        <div
                            style="position: fixed; text-align: center; z-index: 99; height: 100vh; width: 100%; top: 0; left:0; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center; display: none;"
                            id="loader" class="hide">
                            <img src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="50" style="z-index: 999;">
                            <div style="font-size: 40px; color: #fff;">문자 발송 중 입니다.</div>
                        </div>


                        <div class="form-group row align-center">
                            <div class="col-auto">
                                <label class="form-label" for="">
                                    발신번호
                                </label>
                            </div>
                            <div class="col">
                                <input type="hidden" id="text_lenght">
                                <input type="text" id="sender-number" class="form-control" name="sid"
                                    value="<?php echo(rand(10000000000,99999999999)); ?>">
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-auto">
                                <label class="form-label" for="">
                                    수신번호
                                </label>
                            </div>
                            <div class="col">
                                <textarea name="mno" id="recipient-number" rows="8" cols="80" class="form-control"
                                    placeholder="전화번호1&#10;전화번호2&#10;전화번호3&#10;..."></textarea>
                                <p id="file-name"></p>
                                <a href="javascript:openPop()" class="btn outline primary mt-2">
                                파일선택
                                </a>
                                <button data-v-ef8b01ec="" id='send-btn' type="button" class="btn btn-lg primary wide send-btn mt-4">
                                    <span data-v-ef8b01ec="">발송</span>
                                </button>
                            </div>
                        </div>
                        
                    
            </div>


<div class="modal_wrapper" id="fileUpload">
    <div class="modal ">
            <div class="modal_header">
                <h5 class="modal_title"> FILE 입력</h5>
                <button type="button" onclick="closeModal()" class="close">
                </button>
            </div>
            <div class="modal_body">
                <div class="modal-row">
                    <a href="<?php echo base_url(); ?>download.php?file=sample.xlsx" class="">
                        <img src="/assets/images/excel.png" alt="">
                        엑셀 샘플</a>
                    <a href="<?php echo base_url(); ?>download.php?file=sample.txt" class="">
                        <img src="/assets/images/txt.png" alt="">
                        메모장 샘플</a>
                </div>
                <div class="modal-row">
                    <div class="file-wrapper">
                        <input type="file" accept=".xls,.xlsx,text/plain" id="excel" name="file" value="">
                        <span class="file-text">파일을 선택해주세요</span>
                        <button type="button" name="button">
                            <i class="fa fa-file"></i>
                            파일 선택</button>
                    </div>
                </div>
                <div class="modal-row">
                    <a href="javascript:applyFile()" class="btn primary">적용하기</a>
                    <a href="javascript:closeModal()" class="btn primary outline">닫기 </a>
                </div>
            </div>
        </div>
</div>
		</form>
	</div>
</section>
<script type="text/javascript">
	var data_type;
    
    function openPop(){
        $("#fileUpload").addClass("show")
    }
    function closeModal(){
		$('#fileUpload').removeClass("show")
	}
	$(document).ready(function () {
        $(".text_area").focus();
        
	});

    function applyFile(){
        var filename = document.getElementById("excel").files[0].name
        $("#recipient-number").hide()
        $("#file-name").text(filename)
        $('#fileUpload').removeClass("show")
    }
	$('.file-wrapper input[type="file"]').change(function (e) {
		$(this).siblings('.file-text').html(e.target.files[0].name);
	});
	$('#test_send').on('click', function () {
		var data = new FormData();
		if (data_type && $('input:file').val() == 0) {
			alert('파일 업로드하세요.')
		} else if (!data_type && $('#recipient-number').val() == 0) {
			alert('수신번호 입력하세요.')
		} else {
			data.append('msisdn', $('#recipient-number').val());
			data.append('sid', $('#sender-number').val());
			data.append('msg', $('#message').val());
			data.append('file', $('input:file')[0].files[0]);
			$('.lottie_wrapper').show()
			$.ajax({
				url: '/users/test_send',
				type: "POST",
				contentType: false,
				data: data,
				processData: false,
				success: function (data) {
					setTimeout(function () {
						$('.lottie_wrapper').hide()
						window.location.href =
							'<?php echo base_url(); ?>users/SmsRequests'
					}, 2000);
					//console.log(data);
				}
			});
		}

	})

	$(function () {
		$('.toggle input:checkbox').change(function () {
			var id = $(this).attr('id')
			var offEl = $('[data-toggle=' + id + '][data-toggle-set=off]');
			var onEl = $('[data-toggle=' + id + '][data-toggle-set=on]');
			var show = this.checked;
			onEl.toggle(show);
			offEl.toggle(!show);
			data_type = show;
		}).change();
	})


    function reloadText(){
        $("#message").val("").trigger("keyup")
    }

    function openSpecial(){
        $("#special").addClass("show")
    }
</script>
<?php $this->load->view('frontend/special_popup'); ?>