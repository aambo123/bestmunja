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
				<span>회원관리</span>
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
						<span class="caption-subject font-green sbold uppercase">회원관리</span>
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
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<input class="form-control" type="text" name="mb_id" id="mb_id"
									value="<?php if(isset($_POST['mb_id'])){ echo "".$_POST['mb_id'].""; }else{ echo $user->mb_id;} ?>"
									 maxlength="20">
									<span class="error_user_add"><?php echo form_error('mb_id') ?></span>
							</div>
							<div class="col-12 col-sm-3 flex align-center">
								<span class="small">(최대20자 이내로 입력하세요)</span>
							</div>
						</div>
						<!-- /User id -->

						<!-- Name -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="control-label" for="name">이름</label>
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<input class="form-control" type="text" name="mb_name" id="mb_name"
									value="<?php if(isset($_POST['mb_name'])){ echo "".$_POST['mb_name'].""; }else{ echo $user->mb_name;} ?>"
									required maxlength="20">
									<span class="error_user_add"><?php echo form_error('mb_name') ?></span>
							</div>
						</div>
						<!-- /Name -->

						<!-- Password -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2" for="password">비밀번호</label>
							</div>
							<div class="col-12 col-sm-6">
								<input type="hidden" name="old_mb_password" value="<?php echo $user->mb_password; ?>">
								<input class="form-control" type="password" name="mb_password" id="mb_password" maxlength="20" disabled>
								<span class="error_user_add"><?php echo form_error('mb_password') ?></span>
							</div>
							<div class="col-12 col-sm-3 flex align-center">
								<div class="mt-checkbox-inline">
									<label class="mt-checkbox mt-checkbox-outline">
										<input type="checkbox" name="pass_change" id="pass_change" value="1"
											onchange="myFunction(this.value)"> Change
										<span></span>
									</label>
								</div>
								<script>
									function myFunction(val) {
										if ($('#pass_change').is(":checked")) {
											$('#mb_password').prop('disabled', false);
										} else {
											$('#mb_password').val('');
											$('#mb_password').prop('disabled', true);
										}
									}
								</script>
							</div>
						</div>
						<!-- /Password -->
						
						<!-- Level -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2">수평</label>
							</div>
							<div class="col-12 col-sm-6 ">
								<div class="mt-radio-inline">
									<?php if ($this->session->userData('user_level') == 'Super admin') {?>
									<label class="mt-radio mt-radio-outline">
										<input type="radio" id="level_reseller" name="mb_level" value="Reseller" <?php if ($user->mb_level == 'Reseller'): ?>
											checked <?php endif; ?>>
										Reseller
										<span></span>
									</label>
									<?php }?>
									<label class="mt-radio mt-radio-outline ml-2">
										<input type="radio" id="level_customer" name="mb_level" value="Customer" <?php if ($user->mb_level == 'Customer'): ?>
											checked <?php endif; ?>>
										Customer
										<span></span>
									</label>
								</div>
							</div>
						</div>
						<!-- /Level -->
						
						<!-- email -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2 control-label" for="phone">이메일</label>
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<input type="hidden" name="old_mb_email" value="<?php echo $user->mb_email; ?>">
								<input class="form-control" type="text" name="mb_email" id="mb_email"
									value="<?php if(isset($_POST['mb_email'])){ echo "".$_POST['mb_email'].""; }else{ echo $user->mb_email;} ?>"
									required maxlength="15">
							</div>
						</div>
						<!-- /email -->
						
						<!-- Recommend -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2" for="mb_recommend">추천 코드</label>
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<select class="form-control" name="mb_recommend" id="recommendation">
									<?php foreach ($rec_code as $rec){ ?>
										<?php 
										if($rec->rec_code == $user->mb_recommend)
										{ 
											$selected = "selected";
										} else {
											$selected = "none";
										}
									?>	
									<option value="<?php echo $rec->rec_code; ?>" <?php echo $selected; ?>>
										<?php echo $rec->rec_code.' ('.$rec->msg_price.'원)'; ?></option>
									<?php }?>
								</select>
								<span class="error_user_add"><?php echo form_error('mb_recommend') ?></span>
							</div>
						</div>
						<!-- /Recommend -->

						<!-- Reseller code -->
						<div class="form-group row reseller_code">
							<div class="col-12 col-sm-3 text-right">
								<label class="control-label" for="reseller_code">Reseller code</label>
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<input class="form-control" id="reseller_code" type="text" name="mb_reseller_code" 
									value="<?php if(isset($_POST['mb_reseller_code'])){ echo "".$_POST['mb_reseller_code'].""; }else{ echo $user->reseller_code;} ?>"
									 maxlength="20">
									<span class="error_user_add"><?php echo form_error('mb_reseller_code') ?></span>
							</div>
						</div>
						<!-- Reseller code -->

						<!-- Calculator -->
						<div class="form-group row ">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2" for="calculator">등록 링크</label>
							</div>
							<div class="col-12 col-sm-6">
								<input class="form-control" id="calculator" type="calculator" name="mb_calculator"
									autocomplete="new-calculator">
							</div>
						</div>
						<!-- /Calculator -->

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
								<div class="mt-radio-inline">
									<label class="mt-radio mt-radio-outline">
										<input type="radio" name="mb_open" value="0" <?php if ($user->mb_open == 0): ?> checked
											<?php endif; ?>>
										정상
										<span></span>
									</label>
									<label class="mt-radio mt-radio-outline ml-2">
										<input type="radio" name="mb_open" value="1" <?php if ($user->mb_open == 1): ?> checked
											<?php endif; ?>>
										중지
										<span></span>
									</label>
								</div>
							</div>
						</div>
						<!-- End Open/Stop -->

						<!-- Button group -->
						<div class="form-group row">
							<div class="col-12 col-sm-3">
							</div>
							<div class="col-12 col-sm-6 text-right">
								<button type="submit" class="btn btn-success mr-2" name="button">저장</button>
								<a href="/admin/members" class="btn dark" name="button">취소</a>
							</div>
						</div>
						<!-- /Button group -->
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
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-info font-green"></i>
						<span class="caption-subject font-green sbold uppercase">케시 지급</span>
					</div>
				</div>
				<!-- Portlet body -->
				<div class="portlet-body">
					<div class="form-group row">

						<!-- Title -->
						<div class="col-sm-2">
							<label class="control-label">
								케시 부여
							</label>
						</div>
						<!-- /Title -->

						<!-- Recharge -->
						<div class="col-sm-4">
							<input type="number" class="form-control" id="charge" name="" value="">
						</div>
						<button type="button" class="btn success" onclick="admin_charge()" name="button">확인</button>
						<!-- /Recharge -->
					</div>
				</div>
				<!-- /Portlet body -->

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
	<!-- <?php 
		$reseller = $this->users_model->get_user_one($this->session->userData('id'));
		$reseller_price = $this->settings_model->get_recommendation_one_by_code($reseller->mb_recommend);
		$reseller_msg_num = floor($reseller->msg_quantity / $reseller_price->msg_price);

		$customer_price = $this->settings_model->get_recommendation_one_by_code($user->mb_recommend);
		
	?> -->
	<script>
		function admin_charge() {
			var $val = $('#charge').val()
			console.log($val);


			var $val_msg_sum = Math.floor($val / <?php echo $customer_price->msg_price; ?>);

			var $total_price1 = <?php echo $reseller_price->msg_price ?> * $val_msg_sum;
			var answer1 = "";
			var answer = "";
			<?php
			if($this->session->userData('user_level') == 'Reseller') {
			?>
				//answer1 = window.confirm("이 사용자의 현금으로 " + $val + "을 청구 하시겠습니까? 현금에서 " + $total_price1 + "가 공제되고 " + $val_msg_sum + " 개의 메시지가 공제됩니다!")
			<?php } else { ?>
				//answer1 = window.confirm("이 사용자의 현금으로 " + $val + "을 청구 하시겠습니까?");
			<?php } ?>
			answer = window.confirm("이 사용자의 현금으로 " + $val + "을 청구 하시겠습니까?");
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
						} else {
							alert(result);
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
