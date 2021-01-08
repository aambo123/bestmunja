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
									<th style="text-align: center" width="7%">발송</th>
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
							<h3 class="font-green bold">발송<button class="btn blue"><?php echo $sms_results->quantity; ?></button></h3>
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
