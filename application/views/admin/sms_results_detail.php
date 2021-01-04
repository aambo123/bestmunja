<div class="page-content">

    <!-- Page bar -->
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo base_url(); ?>admin">Admin</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<span>발송 결과</span>
			</li>
		</ul>
    </div>
    <!-- /Page bar -->

	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN PORTLET-->
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-info font-green"></i>
						<span class="caption-subject font-green sbold uppercase">발송 결과</span>
					</div>
					<div class="actions">
						<div class="btn-group btn-group-devided">
							<b style="background-color: #26C281; font-size: 13px; padding: 4px 10px; color:white; margin-right: 5px;">
								성공
							</b>
							<!-- <a class="btn blue btn-sm">
                                    대기
                                </a>
                                <a class="btn yellow btn-sm">
                                    확인불가
                                </a> -->
							<b style="background-color: #e7505a; font-size: 13px; padding: 4px 10px; color:white;">
								실패
							</b>
						</div>
					</div>
				</div>
				<div class="portlet-body " id="table_id">

					<div class="table-scrollable table-scrollable-borderless">
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="text-align: center" width="3%">번호</th>
									<th style="text-align: center" width="">회원아이디</th>
									<th style="text-align: center" width="">발신번호</th>
									<th style="text-align: center" width="">메시지</th>
									<th style="text-align: center" width="7%">모든 전화 번호</th>
									<th style="text-align: center" width="7%">성공</th>
									<!-- <th width="7%">확인불가</th> -->
									<th style="text-align: center" width="7%">대기 중</th>
									<th style="text-align: center" width="7%">실패</th>
									<th style="text-align: center" width="10%">등록일</th>

								</tr>
							</thead>
							<tbody class="bg-white" style="text-align: center">
								<?php
									$member = $this->users_model->get_user_one($sms_results->member_id);

									if($member != null) {
											$sms_account = $this->settings_model->get_sms_account_one($member->sms_account_id);
									} else {
											$sms_account = $this->settings_model->get_sms_account_default();
									}
								?>
								<tr>
									<th>1</th>
									<td>
										<?php 
											if ($member != null) { 
												echo $member->mb_id; 
											} else { 
												echo "삭제 된 사용자";
											} 
										?>
									</td>
									<td>
										<?php echo $sms_results->sender; ?>
									</td>
									<td>
										<?php echo $sms_results->message; ?>
									</td>
									<td style="background-color: #3598dc; color: white">
										<?php echo $sms_results->quantity; ?> 건
									</td>
									
									<td style="background-color: #26C281; color: white"> 
										<?php echo $sms_results->delivered_count; ?> 건
									</td>
									
									<td style="background-color: #c3c3c3; color: white"> 
										<?php 
											$pendingNumber = $sms_results->delivered_count + $sms_results->error_count;
											$result = $sms_results->quantity - $pendingNumber;

											echo $result; 
										?> 건
									</td>

									<!-- <td> <?php echo $sms_results->undelivered_count; ?> 건</td> -->
									<td style="background-color: #e7505a; color: white"> 
										<?php echo $sms_results->error_count; ?> 건
									</td>
									<td>
										<?php echo $sms_results->created_date; ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="row">
						<label class="col-md-12 ">
							<h3 class="font-green bold">모든 전화 번호 <button class="btn blue"><?php echo $sms_results->quantity; ?></button></h3>
						</label>
						<div class="scrolling-box">
							<?php 
								foreach ($numbers as $nb) { 
									echo '<div class="col-sm-1" style="padding-bottom: 10px; padding-top: 10px; width: 120px;">';
									echo '<button class="btn blue" style="width: 100%; padding-left: 0; padding-right: 0;">';
									echo $nb->phone_number;
									echo '</button>';
									echo '</div>';
								}
							?>
						</div>
					</div>

					<div class="row">
						<label class="col-md-12 ">
							<h3 class="font-green bold">성공 <button class="btn green-jungle"><?php echo $sms_results->delivered_count; ?></button></h3>
						</label>
						<div class="scrolling-box">
							<?php 
								foreach ($numbers as $nb) { 
									if ($nb->success == 1) {
										echo '<div class="col-sm-1" style="padding-bottom: 10px; padding-top: 10px; width: 120px;">';
										echo '<button class="btn green-jungle" style="width: 100%; padding-left: 0; padding-right: 0;">';
										echo $nb->phone_number;
										echo '</button>';
										echo '</div>';
									}
								}
							?>
						</div>
					</div>

					<div class="row">
						<label class="col-md-12 ">
							<h3 class="font-green bold">실패한 <button class="btn red"><?php echo $sms_results->error_count; ?></button></h3>
						</label>
						<div class="scrolling-box">
							<?php 
								foreach ($numbers as $nb) { 
									if ($nb->success == 3) {
										echo '<div class="col-sm-1" style="padding-bottom: 10px; padding-top: 10px; width: 120px;">';
										echo '<button class="btn red" style="width: 100%; padding-left: 0; padding-right: 0;">';
										echo $nb->phone_number;
										echo '</button>';
										echo '</div>';
									}
								}
							?>
						</div>
					</div>

					<div class="row">
						<label class="col-md-12 ">
							<h3 class="font-green bold">
								실패한 
								<button class="btn" style="background: #c3c3c3; color:white">
									<?php 
										echo $result; 
									?>
								</button>
							</h3>
						</label>
						<div class="scrolling-box">
							<?php 
								foreach ($numbers as $nb) {

									if(empty($nb->success == 1)){
										$a1 = array("");
									} else {
										$a1 = array($nb->phone_number);
									}
									
									if(empty($nb->success == 3)){
										$a2 = array("");
									} else {
										$a2 = array($nb->phone_number);
									} 
									$pending = array_merge($a1, $a2);

									$b1 = array($nb->phone_number);

									$result = array_diff($b1, $pending);

									foreach ($result as $r) {
										echo '<div class="col-sm-1" style="padding-bottom: 10px; padding-top: 10px; width: 120px;">';
										echo '<button class="btn" style="background: #c3c3c3; width: 100%; padding-left: 0; padding-right: 0;">';
										echo $r;
										echo '</button>';
										echo '</div>';
									}
								}
							?>
						</div>
					</div>


					<?php if($sms_results->error_count != 0 || $sms_results->undelivered_count != 0){ ?>
					<div class="row">
						<div class="form-group col-md-12 bg-grey-steel-opacity "
							style=" margin-top: 50px; margin-bottom: 50px;">
							<input type="hidden" value="english" name="english">
							<label class="col-md-12 ">
								<h3 class="font-green bold">재전송</h3>
							</label>

						</div>

						<form class="" action="" method="post">
							<input type="hidden" id="msg_id" value="<?php echo $sms_results->id; ?>">
							<input type="hidden" value="<?php echo $sms_results->delivered_count; ?>"
								id="success_count">
							<div class="form-group row ">
								<div class="col-12 col-sm-3 text-right">

									<label class="my-2" for="id">SMS account</label>
									<span class="font-red-mint bold">*</span>
								</div>
								<div class="col-12 col-sm-6">

									<div class="mt-checkbox-inline">
										<?php foreach ($account as $ac){ ?>
										<label class="mt-radio mt-radio-outline">

											<input type="hidden" value="" id="sms_account_value">
											<input type="radio" class="radio-class" name="sms_account"
												id="sms_account<?php echo $ac->id; ?>" required
												value="<?php echo $ac->id; ?>"
												<?php if($ac->default == 1){ echo "checked";} ?>>
											<?php echo $ac->username; ?>
											<span></span>
										</label>
										<?php }?>
									</div>

								</div>
								<div class="col-12 col-sm-3 flex align-center">

								</div>
							</div>
							<div class="form-group row ">
								<div class="col-12 col-sm-3 text-right">

									<label class="my-2" for="id">발신번호</label>
									<span class="font-red-mint bold">*</span>
								</div>
								<div class="col-12 col-sm-6">

									<input required class="form-control sett" type="text" name="sid" id="sender-number"
										value="<?php echo $sms_results->sender; ?>" required>
									<?php
										echo "<span style='color: #ff0000; font-size: 11px;'>";
										echo form_error('z_id');
										echo "</span>";
									?>
								</div>
								<div class="col-12 col-sm-3 flex align-center">

								</div>
							</div>

							<div class="form-group row">
								<div class="col-12 col-sm-3 text-right">
									<label class="my-2" for="password">수신번호</label>

								</div>
								<div class="col-12 col-sm-6">

									<textarea class="form-control" name="mno" id="recipient-number"
										placeholder="전화번호1&#10;전화번호2&#10;전화번호3&#10;..."
										rows="10"><?php foreach ($numbers as $nb_errors){ if($nb_errors->success != 1){ echo "".$nb_errors->phone_number."&#10;"; }} ?></textarea>
								</div>
								<div class="col-12 col-sm-3 flex align-center">


								</div>
							</div>

							<div class="form-group row">
								<div class="col-12 col-sm-3 text-right">
									<label class="my-2" for="message">메시지</label>

								</div>
								<div class="col-12 col-sm-6">

									<textarea class="form-control" name="body" id="msg1" placeholder="메시지를 입력해주세요"
										rows="10"><?php echo $sms_results->message; ?></textarea>
								</div>
								<div class="col-12 col-sm-3 flex align-center">


								</div>
							</div>
							<div class="form-group row">
								<div class="col-12 col-sm-3">

								</div>
								<div class="col-12 col-sm-6 text-right">

									<button type="button" class="btn btn-success mr-2" id="submitbtn"
										name="button">발송</button>
									<button type="reset" class="btn dark" name="button">취소</button>

								</div>
							</div>
						</form>
						<style>
							.visible {
								display: flex !important;
								display: -ms-flex !important;
							}

						</style>
						<div style="position: fixed; text-align: center; z-index: 99; height: 100vh; width: 100%; top: 0; left:0; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center; display: none;"
							id="loader" class="hide">
							<img src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="50"
								style="z-index: 999;">
							<div style="font-size: 40px; color: #fff;">문자 발송 중 입니다.</div>
						</div>
						<script>
							$('#submitbtn').on('click', function () {
								$('#loader').addClass('visible');

								// if ($('#excel').get(0).files.length === 0) {
								//     var fl = 0;
								// }else{
								//     var fl = 1;
								// }

								var data = new FormData();

								var sms_account = $('.radio-class:checked').val()

								data.append("msg_id", $('#msg_id').val());
								data.append("body", $('#msg1').val());
								data.append("sms_account", sms_account);
								data.append('mno', $('#recipient-number').val());
								data.append('sid', $('#sender-number').val());
								data.append('success_count', $('#success_count').val());
								//data.append("fl", fl);
								//data.append("file", $('input:file')[0].files[0]);

								$.ajax({
									url: '/users/smsResend',
									type: "POST",
									data: data,
									contentType: false,
									processData: false,
									cache: false,
									async: true,
									success: function (data) {
										$('#loader').removeClass('visible');
										console.log(data);
										if (data == 3) {
											alert('메시지를 입력해주세요.');
										}
										if (data == 4) {
											alert('수신번호가 비어있다. ');
										}

										if (data == 5) {
											alert('MSG limit 부족합니다');
										}

										if (data == 6) {
											alert('발신번호가 입력해주세요.');
										}


										if (data == 7) {
											alert('SMS Account 입력해주세요.');
										}

										if (data == 2) {

											alert('메시지가 발송되었습니다.');

											location.reload();
										}
										if (data == 8) {
											alert('비밀번호 및 아이디가 일치하지 않습니다.');
											location.reload();
										}
										//alert(data);
									}
								});

								// alert("메세지 전송요청에 성공하였습니다. 결과페이지에서 결과 확인이 가능합니다.");
								// location.replace(window.location.origin+'/bbs/board.php?bo_table=SmsRequests');
							})

						</script>
					</div>
					<?php }?>
				</div>
			</div>
			<!-- END PORTLET-->
		</div>
	</div>

    <!-- Custom css -->
	<script>
		$(".alert").fadeTo(2000, 500).slideUp(500, function () {
			$(".alert").slideUp(500);
		});
    </script>
    <!-- /Custom css -->

</div>
