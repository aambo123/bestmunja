<div class="page-content">

	<!-- User edit bar -->
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo base_url(); ?>admin">Admin</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<span>회원 관리 쇼</span>
			</li>
		</ul>
	</div>
	<!-- /User edit bar -->

	<!-- User edit row -->
	<div class="row">

		<!-- User col 6 -->
		<div class="col-lg-6">
			<!-- BEGIN PORTLET-->
			<div class="portlet light ">

				<!-- Caption -->
				<div class="portlet-title">

					<div class="caption">
						<i class="icon-info font-green"></i>
						<span class="caption-subject font-green sbold uppercase">회원 관리 쇼</span>
					</div>

				</div>
				<!-- /Caption -->

				<!-- Body -->
				<div class="portlet-body form">
					<!-- Form action -->
					<form class="" action="<?php echo base_url(); ?>admin/user_edit_set" method="post">

						<!-- User id -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<input type="hidden" name="user_id" value="<?php echo $user->mb_no; ?>">
								<label class="control-label" for="name">아이디</label>
							</div>
							<div class="col-12 col-sm-6">
                <span class="normal"><?php echo $user->mb_id ? $user->mb_id : '' ?></span>
							</div>
						</div>
						<!-- /User id -->

						<!-- Name -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="control-label" for="name">이름</label>
							</div>
							<div class="col-12 col-sm-6">
                <span class="normal"><?php echo $user->mb_name ? $user->mb_name : '' ?></span>
							</div>
						</div>
						<!-- /Name -->
						
						<!-- Level -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2">수평</label>
							</div>
							<div class="col-12 col-sm-6 ">
                <span class="normal"><?php echo $user->mb_level ? $user->mb_level : '' ?></span>
							</div>
						</div>
						<!-- /Level -->
						
						<!-- email -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2 control-label" for="phone">이메일</label>
							</div>
							<div class="col-12 col-sm-6">
                <span class="normal"><?php echo $user->mb_email ? $user->mb_email : '' ?></span>
							</div>
						</div>
						<!-- /email -->
						
						<!-- Recommend -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2" for="mb_recommend">추천 코드</label>
							</div>
							<div class="col-12 col-sm-6">
									<?php foreach ($rec_code as $rec){ ?>
                    
										<span class="normal"> <?php if($rec->rec_code == $user->mb_recommend){ echo "$rec->rec_code";}?></span>
									<?php }?>
							</div>
						</div>
						<!-- /Recommend -->

						<!-- Reseller code -->
						<!-- <div class="form-group row reseller_code">
							<div class="col-12 col-sm-3 text-right">
								<label class="control-label" for="reseller_code">Reseller code</label>
							</div>
							<div class="col-12 col-sm-6">
                <span class="normal"><?php echo $user->reseller_code ? $user->reseller_code : 'None' ?></span>
							</div>
						</div> -->
            <!-- Reseller code -->
            
						<!-- Quantity -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2" for="cash">잔여 캐쉬</label>
							</div>
							<div class="col-12 col-sm-6">
								<?php echo $user->msg_quantity; ?>
							</div>
						</div>
						<!-- /Quantity -->

						<!-- Open/Stop -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2">발송 중지</label>
							</div>
							<div class="col-12 col-sm-6 ">
                <span class="normal"><?php echo $user->mb_open == 0 ? '정상' : '중지' ?></span>
							</div>
						</div>
						<!-- End Open/Stop -->
					</form>
					<!-- /Form action -->
				</div>
				<!-- /Body -->
			</div>
			<!-- END PORTLET-->

		</div>
		<!-- /User col 6 -->

		<!-- User col 6 -->
		<div class="col-lg-6">
			<div class="portlet light">

				<!-- Portlet title -->
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-info font-green"></i>
						<span class="caption-subject font-green sbold uppercase">결제내역</span>
					</div>
				</div>
				<!-- /Portlet title -->

				<div class="portlet-body">
					<!-- Table payment -->
					<table class="table table-striped text-center">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">결제금액(충전 CASH)</th>
								<th class="text-center">결제방법</th>
								<th class="text-center">결제일</th>
								<th class="text-center">결제 상테</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach ($history as $row){
							?>
							<tr>
								<th class="text-center"><?php echo $total--;?></th>
								<td>
									<?php if ($row->type == null || $row->type == 0){ ?>
									<?php echo number_format($row->total_price).' 원('.number_format($row->num_send).' Cash)' ?>
									<?php } elseif ($row->type == 1) {?>
									<?php echo number_format($row->num_send).' Cash)' ?>
									<?php } ?>

								</td>
								<td>
									<?php if ($row->type == null || $row->type == 0){ ?>
									무통장
									<?php } elseif ($row->type == 1) {?>
									관리자 부여
									<?php } ?>
								</td>
								<td>
									<?php echo $row->created_date ?>
								</td>
								<td>
									<?php if ($row->status == 0){ ?>
									결제대기
									<?php } elseif ($row->status == 2) {?>
									결제완료
									<?php } ?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<!-- /Table payment -->
				</div>
				
				<!-- Caption -->
				<div class="caption">
					<i class="icon-info font-green"></i>
					<span class="caption-subject font-green sbold uppercase">현금 이력</span>
				</div>
				<!-- /Caption -->

				<!-- Table Cash -->
				<?php
					echo '
					<table class="table table-striped text-center">
						<thead>
							<tr>
								<th style="text-align:center">ID</th>
								<th style="text-align:center">현금</th>
								<th style="text-align:center">환불하다/현금 인출</th>
								<th style="text-align:center">체계</th>
								<th style="text-align:center">작성일</th>
							</tr>
						</thead>
						<tbody>
					';
					$i = 1;
					foreach ($cash as $row){
						echo '
							<tr>
								<td>'. $total1-- .'</td>
								<td style="text-align:center">'. $row->cash .'</td>
								<td>'. $row->success .'</td>
								<td>'. $row->system .'</td>
								<td>'. $row->created_date .'</td>
							</tr>
						';
					}
					echo '
						</tdbody>     
					</table>
					';
				?>
				<!-- /Table Cash -->
			</div>
				
			<!-- Pagination -->
			<?php echo $pagination ?>
			<!-- /Pagination -->
		</div>
		<!-- /User col 6 -->

	</div>
	<!-- /User edit row -->

	<script>
		$(".alert").fadeTo(2000, 500).slideUp(500, function () {
			$(".alert").slideUp(500);

		});

	</script>
	<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
	<script>
		function admin_charge() {
			var $val = $('#charge').val()
			console.log($val);
			var answer = window.confirm($val + "Cash 충전하시겠습니까??")
			if (answer) {
				$.ajax({
					url: '/admin/recharge_user',
					type: "POST",
					async: true,
					cache: false,
					data: {
						id: <?php echo $user->mb_no ?> ,
						cash: $val,
					},
					success: function (result) {
						if (result == 'success') {
							location.reload();
							console.log(result);
						} else {
							alert('잔액이 충분하지 않습니다.');
						}
					}
				})
			} else {
				//some code
			}
		}

		function findZip() {
			new daum.Postcode({
				oncomplete: function (data) {
					// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

					// 각 주소의 노출 규칙에 따라 주소를 조합한다.
					// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
					var addr = ''; // 주소 변수
					var extraAddr = ''; // 참고항목 변수

					//사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
					if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
						addr = data.roadAddress;
					} else { // 사용자가 지번 주소를 선택했을 경우(J)
						addr = data.jibunAddress;
					}

					// 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
					if (data.userSelectedType === 'R') {
						// 법정동명이 있을 경우 추가한다. (법정리는 제외)
						// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
						if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
							extraAddr += data.bname;
						}
						// 건물명이 있고, 공동주택일 경우 추가한다.
						if (data.buildingName !== '' && data.apartment === 'Y') {
							extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
						}
						// 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
						if (extraAddr !== '') {
							extraAddr = ' (' + extraAddr + ')';
						}
						// 조합된 참고항목을 해당 필드에 넣는다.
						document.getElementById("user_address").value = addr + extraAddr;

					} else {
						document.getElementById("user_address").value = addr;
					}

					// 우편번호와 주소 정보를 해당 필드에 넣는다.
					document.getElementById('user_postcode').value = data.zonecode;
					// document.getElementById("user_address").value = addr;
					// 커서를 상세주소 필드로 이동한다.
					document.getElementById("user_detailAddress").focus();
				}
			}).open();
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function () {

			$('#user_mobile_number').mask('000-0000-0000');

			var options = {
				onKeyPress: function (cep, e, field, options) {
					var masks = ['000-000-0000', '00-000-00000'];
					console.log(cep.length);
					var mask = (cep.length > 11) ? masks[0] : masks[1];
					$('#user_phone_number').mask(mask, options);
				}
			};
			$('#user_phone_number').mask('000-000-0000', options);
		});

		// $('#user_name').mask('KKK',{'translation': {
		//           K : {pattern: /[\u3131-\uD79DA-Za-z]/},
		//      }
		// })

	</script>

	<!-- Create link -->
	<script>
		$(".alert").fadeTo(2000, 500).slideUp(500, function () {
			$(".alert").slideUp(500);
		});

		function createLink(recommendationCode, resellerCode){
			var linkk = "<?php echo base_url(); ?>home/register_form#" + recommendationCode + resellerCode;
			$('#calculator').val(linkk);
		}

		$(document).ready(function () {

			$('#reseller_code').on('keyup', function() {
				if($('#recommendation').val() != ''){
					//createLink($('#recommendation').val(), '#' + $(this).val());
					var reseller_code = '';
					if($('#reseller_code').val() != ''){
						reseller_code = '#' + $('#reseller_code').val();
					}
					createLink($('#recommendation').val(), reseller_code);
				} else {
					$('#calculator').val("");
				}
			});

			$('#recommendation').on('change', function() {
				if($(this).val() != ""){
					var reseller_code = '';
					if($('#reseller_code').val() != ''){
						reseller_code = '#' + $('#reseller_code').val();
					}
					createLink($(this).val(), reseller_code);
				} else {
					$('#calculator').val("");
				}
			});

			// RESELLER
			if ($('input[name=mb_level]:checked').val() == 'Reseller') {
				$(".reseller_code").show();

				if($('#recommendation').val() != ''){
					//createLink($('#recommendation').val(), '#' + $(this).val());
					var reseller_code = '';
					if($('#reseller_code').val() != ''){
						reseller_code = '#' + $('#reseller_code').val();
					}
					createLink($('#recommendation').val(), reseller_code);
				} else {
					$('#calculator').val("");
				}
			}
			
			// CUSTOMER
			if($('input[name=mb_level]:checked').val() == 'Customer') {
				$(".reseller_code").hide();

				if($('#recommendation').val() != ''){
					//createLink($('#recommendation').val(), '#' + $(this).val());
					var reseller_code = '';
					
					createLink($('#recommendation').val(), reseller_code);
				} else {
					$('#calculator').val("");
				}
			}

			$("input[name='mb_level']").click(function() {
				if ($("#level_reseller").is(":checked")) {
					$(".reseller_code").show();
					if($('#recommendation').val() != ''){
						var reseller_code = '';
						if($('#reseller_code').val() != ''){
							reseller_code = '#' + $('#reseller_code').val();
						}
						createLink($('#recommendation').val(), reseller_code);
					}
				} else {
					$(".reseller_code").hide();
					$('#reseller_code').val("");
					if($('#recommendation').val() != ''){
						createLink($('#recommendation').val(), '');
					}
				}
			});
		});
	</script>
	<!-- /Create link -->
</div>
