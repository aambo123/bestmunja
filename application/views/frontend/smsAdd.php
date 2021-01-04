<link rel="stylesheet" href="<?php echo base_url(); ?>assets/src/css/smsAdd.css">
<script src="<?php echo base_url(); ?>assets/src/js/smsAdd.js"></script>
<div class="page">
	<div class="main_wrapper" style="background:#EAF5FC">
		<?php
          $sandbox_acc = 'sb-kaks1631984@personal.example.com';
          $sandbox_cred = 'Af7AuARnTOgEvqsg-iMiCA4NktfvTd3QINDQSsECe4fUTMUqsqtMMaQsSY0TRAnQTjlIE4zmCNadUj_s';
          $sandbox_secret = 'EC8SN04Yuu1QKuQP2OXFspxOuTvcPLA1d92PBT1NBbw2Vtvoj6dm1c3kvJMSeADjh1PgVAcG2yOyHKlg';
     ?>
		<div class="container recharge_con">
			<div class="row h-100">
				<div class="col-md-6">
					<div class="flex h-100 h-m align-center">
						<div class="recharge_wrapper">
							<h1>원하는 발송량만큼 충전해 주세요.</h1>
							<p>건당 <span><?php if($msg_price != null){ echo $msg_price->msg_price; }else{ echo "0";}?></span>원/
								한글, 영문 <span>70</span>자까지 입력</p>
							<div class="input-group w-50">
								<div class="form-control" id="text">0</div>
								<input type="hidden" name="" value="0" id="target">
								<span class="append">건</span>
							</div>
							<ul class="add_wrapper">
								<li>
									<div class="add" data-value="10000">
										<i data-feather="plus" width="14"></i>
										10,000 건
									</div>
								</li>
								<li>
									<div class="add" data-value="50000">
										<i data-feather="plus" width="14"></i>
										50,000 건
									</div>
								</li>
								<li>
									<div class="add" data-value="100000">
										<i data-feather="plus" width="14"></i>
										100,000 건
									</div>
								</li>
								<li>
									<div class="add" data-value="300000">
										<i data-feather="plus" width="14"></i>
										300,000 건
									</div>
								</li>
								<li>
									<div class="add" data-value="500000">
										<i data-feather="plus" width="14"></i>
										500,000 건
									</div>
								</li>
								<li>
									<div class="add" data-value="1000000">
										<i data-feather="plus" width="14"></i>
										1,000,000 건
									</div>
								</li>
								<li>
									<div class="add" data-value="2000000">
										<i data-feather="plus" width="14"></i>
										2,000,000 건
									</div>
								</li>
								<li>
									<div class="refresh">
										<i data-feather="refresh-cw" width="14"></i>
										초기화
									</div>
								</li>
							</ul>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="left_wrapper">
			<div class="recharge_box">
				<div class="price">
					충전금액 : <span id="price">0</span>
				</div>
				<div class="price">
					<!--                    부가세 (10%) : <span id="tax">0</span>-->
				</div>
				<div class="total">
					결제금액 : <span id="total" class="ml-auto">0</span><span>원</span>
					<div class="flex align-center w-100 message">
						<span class="txt-primary ml-auto" id="total_message">0</span>
						<span class="">건 발송가능</span>
					</div>
				</div>

				<div class="total_message">
					<!-- <p>결제 후 잔액 :</p>
                    <div class="flex">
                         <?php echo $user->mb_id; ?>
                         <span class="txt-primary ml-auto" id="total_message">0</span>
                         <span class="txt-primary">건</span>
                    </div> -->
					<p>입금계좌 :</p>
					<div class="flex">
						<?php if($settings != null){ echo $settings->account_name;} ?>
						<span
							class="txt-primary ml-auto"><?php if($settings != null){ echo $settings->account_number; }?></span>
					</div>
				</div>

				<button type="button" class="btn btn-lg wide primary" onclick="send_request()"
					name="button">충전하기</button>
				<div id="paypal-button-container"></div>

			</div>
		</div>
	</div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=<?php echo $sandbox_cred ?>">
	// Required. Replace SB_CLIENT_ID with your sandbox client ID.

</script>


<!--  <script>-->
<!--    paypal.Buttons({-->
<!---->
<!--    }).render('#paypal-button-container');-->
<!--    // This function displays Smart Payment Buttons on your web page.-->
<!--  </script>-->

<script type="text/javascript">
	var total_price;
	var total_message;
	var $text = $('#text');
	var price_per_msg = <?php
	if ($msg_price != null) {
		echo $msg_price->msg_price;
	} else {
		echo "0";
	} ?>;
	$.fn.digits = function () {
		return this.each(function () {
			$(this).text($(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		})
	}
	$('.add').on('click', function () {
		var $val = $('#target').val();
		var addition = $val * 1 + $(this).data('value') * 1;
		var tax = 0;
		total_price = Math.round(addition * price_per_msg);
		total_message = addition + tax;



		$('#target').val(addition);
		$('#text').text(addition).digits();
		$('#price').text(addition).digits();
		$('#tax').text(addition / 10).digits();
		$('#total').text(total_price).digits();
		$('#total_message').text(total_message).digits();

	});
	$('.refresh').on('click', function () {
		var target = $('#target');
		target.val(0);
		$text.text(0);
		$('#price').text(0);
		$('#tax').text(0);
		$('#total').text(0);
		$('#total_message').text(0);
	})

	function send_request() {
		$.ajax({
			type: "POST",
			data: {
				'total_price': total_price,
				'num_send': $('#target').val()
			},
			url: "/users/smsAddSend",
			cache: false,
			dataType: 'html',
			async: true,
			success: function (data) {
				$('.loader_wrapper').removeClass('show');
				alert('충전요청에 성공하였습니다.');
				location.reload();
			}
		});
		return false;

	}

</script>
