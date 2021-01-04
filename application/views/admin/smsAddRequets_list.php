<div class="page-content">

	<!-- Breadcrumbs -->
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo base_url(); ?>admin">Admin</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<span>SMS 승인 요청</span>
			</li>
		</ul>
	</div>

	<!-- Notification messages -->
	<?php if($msg == 'success_added'){ ?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		<strong>Successfully</strong> added.
	</div>
	<?php }?>
	<?php if($msg == 'success_updated'){ ?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		<strong>성공적으로 업데이트되었습니다.</strong>
	</div>
	<?php }?>
	<?php if($msg == 'success_deleted'){ ?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		<strong>Successfully</strong> deleted.
	</div>
	<?php }?>
	<?php if($msg == 'error_updated'){ ?>
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		<strong>잔액이 충분하지 않습니다.</strong>
	</div>
	<?php }?>


	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN PORTLET-->
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-info font-green"></i>
						<span class="caption-subject font-green sbold uppercase">SMS 승인 요청</span>
					</div>
					<div class="actions">
						<div class="btn-group btn-group-devided">
							<!--                        <a href="--><?php //echo base_url(); ?>
							<!--admin_panel/banner/add" class="btn btn-success btn-sm">-->
							<!--                            <i class="glyphicon glyphicon-plus"></i> New-->
							<!--                        </a>-->
							<a href="<?php echo base_url(); ?>admin/downloadMessageRequests" class="btn btn-primary btn-sm">
								<i class="fa fa-file-excel-o"></i> 엑셀 다운로드
							</a>
						</div>
					</div>
				</div>
				<div class="portlet-body " id="table_id">

					<div class="table-scrollable table-scrollable-borderless" style="padding-bottom: 50px;">
						<table class="table table-striped  table-light">
							<thead>
								<tr style="text-align: left;">
									<th width="5%">번호</th>
									<th width="20%">회원아이디</th>
									<th width="15%">상태</th>
									<th width="12%">충전금액</th>
									<th width="12%">CASH</th>
									<!-- <th width="12%">Reseller cash change</th> -->
									<th width="10%">승인 된 사용자</th>
									<th width="14%">날짜</th>

								</tr>
							</thead>
							<tbody class="bg-white">
								<?php
						$count = $countstart;
						foreach ($smsAddRequets as $row){
							$count++;
							// $today_count = $this->users_model->get_today_count($row->id);
							// $all_count = $this->users_model->get_all_count($row->id);

                            // Check Resellers Customer
							$member = $this->users_model->get_user('mb_no', $row->member_id);
							$reseller = ($member) ? $this->users_model->get_user('mb_no', $member->reseller_id) : null;
							$disabled = '';

							// Reseller cant access own request
							if ($this->session->userdata('user_level') == 'Reseller' && $row->member_id == $this->session->userdata('id')){
								$disabled = 'disabled';
							}

							// Super admin
							if ($this->session->userdata('user_level') == 'Super admin' && $reseller){
								if ($row->member_id == $member->reseller_id) {
									$disabled = '';
								} else {
									$disabled = 'disabled';
								}
							}

							// Get approve user
							$approve_user = $this->users_model->get_user('mb_no', $row->approve_id);
							$approve_name = ($approve_user) ? $approve_user->mb_id : '';

							// Reseller cash change
							if ($member->mb_level == 'Customer'){
								// // Check reseller's message quantity and number
								// $reseller = $this->users_model->get_user('mb_no', $member->reseller_id);
								// $reseller_msg_quantity = $reseller->msg_quantity;
								// $recommendation = $this->settings_model->get_msg_price($reseller->mb_recommend);
								// $msg_price = $recommendation->msg_price;
								// $msg_num = floor($reseller_msg_quantity / $msg_price);

								// // Get customer's requested quantity and number
								// $member_recommendation = $this->settings_model->get_msg_price($member->mb_recommend);
								// $member_msg_price = $member_recommendation->msg_price;
								// $member_msg_num = floor($row->num_send / $member_msg_price);

								// Calculate reseller cash change
								// $reseller_cash_change = $msg_price * $member_msg_num;

								$member_msg_quantity = $this->users_model->get_member_msg_quantity_by_request($row->id);
								// print_r($member_msg_quantity);
								// die();
								$reseller_cash_change = ($member_msg_quantity) ? $member_msg_quantity->reseller_cash_change : NULL;
							} else {
								$reseller_cash_change = NULL;
							}

						?>
								<tr>
									<td><span
											<?php if($row->status == 0){ echo "class='bold font-blue-chambray'"; } ?>><?php echo $count; ?></span>
									</td>
									<td><span
											<?php if($row->status == 0){ echo "class='bold font-blue-chambray'"; } ?>><?php echo $row->member_name; ?></span>
									</td>
									<td>
										<div class="btn-group" style="width: 100%;">
											<?php if($row->status == 2){ ?>
											<button class="btn green-jungle dropdown-toggle " type="button" <?php echo $disabled; ?>
												data-toggle="dropdown" style="min-width: 100px;"> 승인
											</button>
											<?php }else{?>
											<button class="btn blue-hoki btn-sm dropdown-toggle" type="button" <?php echo $disabled; ?>
												data-toggle="dropdown" style="min-width: 100px;"> 대기
												<i class="fa fa-angle-down"></i>
											</button>
											<ul class="dropdown-menu" role="menu" style="z-index: 9999;">
												<li>

													<?php
													if($this->session->userData('user_level') == 'Reseller') {
														$reseller = $this->users_model->get_user_one($this->session->userData('id'));
                                                        $reseller_price = $this->settings_model->get_recommendation_one_by_id($reseller->mb_recommend);
                                                        
														$reseller_msg_num = floor($reseller->msg_quantity / $reseller_price->msg_price);

														$customer_price = $this->settings_model->get_recommendation_one_by_id($member->mb_recommend);
														
														$total_msg_num = floor($row->total_price/$customer_price->msg_price);
														$total_cash_num = $reseller_price->msg_price * $total_msg_num;

														$msg = "현금에서 " . $total_cash_num . "가 공제되고 " . $total_msg_num . " 개의 메시지가 공제됩니다!";
													} else {
														$msg = '';
													}
													$msg = 'Are you sure';
												?>

													<a href="<?php echo base_url(); ?>admin/requestaccept/<?php echo $row->id; ?>"
														data-toggle="confirmation" data-original-title="<?php echo $msg; ?>" data-placement="top custom_pos">
														승인
													</a>
												</li>
											</ul>

											<?php }?>
										</div>
									</td>
									<td><span
											<?php if($row->status == 0){ echo "class='bold font-blue-chambray'"; } ?>><?php echo number_format($row->total_price); ?></span>
									</td>

									<td><span
											<?php if($row->status == 0){ echo "class='bold font-blue-chambray'"; } ?>><?php echo number_format($row->num_send); ?></span>
									</td>

									<!-- <td><span
											<?php if($row->status == 0){ echo "class='bold font-blue-chambray'"; } ?>><?php echo ($reseller_cash_change) ? number_format($reseller_cash_change) : $reseller_cash_change; ?></span>
									</td> -->

									<td><span
											<?php if($row->status == 0){ echo "class='bold font-blue-chambray'"; } ?>><?php echo $approve_name; ?></span>
									</td>

									<td><span
											<?php if($row->status == 0){ echo "class='bold font-blue-chambray'"; } ?>><?php echo $row->created_date; ?></span>
									</td>


								</tr>
								<?php }?>
							</tbody>
						</table>
					</div>

					<?php echo $pagination; ?>
				</div>
			</div>
			<!-- END PORTLET-->
		</div>
	</div>

	<script>
		$(".alert").fadeTo(2000, 500).slideUp(500, function () {
			$(".alert").slideUp(500);
		});

	</script>
</div>
