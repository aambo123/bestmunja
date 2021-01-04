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
				<span>지불 통계</span>
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
		<div class="col-md-6">
			<!-- BEGIN PORTLET-->
			<div class="portlet light " >
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-info font-green"></i>
						<span class="caption-subject font-green sbold uppercase">결제 로그</span>
					</div>
					<div class="actions">
						<div class="btn-group btn-group-devided">
						<form form class="" action="<?php echo base_url() ?>admin/downloadPaymentStatistic" method="post">
									<input type="hidden" class="form-control" id="searchUserId" name="user_id_excel" placeholder="회원아이디"
										value="<?php echo $this->session->userdata('search_user_id'); ?>">
									<?php $date = $this->session->userdata('search_date');?>
									<?php 
										if ($this->session->userdata('search_date') != null){
											$date = $this->session->userdata('search_date');
										} else {
											$date = '';
										}
									?>
									<input type="hidden" id="searchDate" name="excel_date" class="datepicker-here form-control" data-language='kr'
										data-range="true" data-multiple-dates-separator="~" placeholder="발송일" autocomplete="off" 
										value="<?php 
										
											if(is_array( $date) && count($date) == 1) {
												echo $date[0];
											} 
											
											if (is_array($date) && count($date) == 2){
												
												echo $date[0] .'~'. $date[1];
											}

										?>"/>
								<button type="submit" class="btn btn-primary btn-sm" id="submitSearch">
									<i class="fa fa-file-excel-o"></i> 엑셀 다운로드
								</button>
							</form>
						</div>
					</div>
				</div>
				<div class="portlet-body">
					<div class="searchby">
					<form class="" action="<?php echo base_url() ?>admin/statisticPayment_search" method="post">
							<div class="row">
								<div class="col-sm-2">
									<input type="text" class="form-control" id="searchUserId" name="user_id" placeholder="회원아이디"
										value="<?php echo $this->session->userdata('search_user_id'); ?>">
								</div>
								<div class="col-sm-3">
									<?php $date = $this->session->userdata('search_date');?>
									<?php 
										if ($this->session->userdata('search_date') != null){
											$date = $this->session->userdata('search_date');
										} else {
											$date = '';
										}
									?>
									<input type="text" id="searchDate" name="date" class="datepicker-here form-control" data-language='kr'
										data-range="true" data-multiple-dates-separator="~" placeholder="발송일" autocomplete="off" 
										value="<?php 
										
											if(is_array( $date) && count($date) == 1) {
												echo $date[0];
											} 
											
											if (is_array($date) && count($date) == 2){
												
												echo $date[0] .'~'. $date[1];
											}

										?>"/>
								</div>

								<div class="col-sm-6">
									<button type="submit" class="btn blue">
										<i class="icon-magnifier"></i>검색
									</button>

									
									<a type="reset" class="btn blue btn-outline" href="<?php echo base_url() ?>admin/statisticPayment">
										<i class="icon-refresh"></i>초기화
									</a>
								</div>
							</div>
						</form>
					</div>

					<div class="table-scrollable table-scrollable-borderless" style="padding-bottom: 50px;">
						<table class="table table-striped  table-light" >
							<thead>
							<tr style="text-align: left;">
								<th width="5%">번호</th>
								<th>회원아이디</th>
								<th>Action</th>
								<th>Current</th>
								<!-- <th>Reseller revenue</th>
								<th>SMS quantity</th> -->
								<th>Date</th>
							</tr>
							</thead>
							<tbody class="bg-white">
							<?php
							$count = $countstart;
							$sum_msg_quantity = 0;
							$sum_action_quantity = 0;
							$sum_reseller_revenue = 0;

							foreach ($payments as $row){
								$count++;
								// Get member
								$member = $this->users_model->get_user('mb_no', $row->member_id);
								// Set mesage quantity
								$recommendation = $recommendation = $this->settings_model->get_recommendation_one_by_id($member->mb_recommend);
								$diff = ($row->current_quantity > $row->last_quantity) ? "+" : "";
								$msg_quantity = $recommendation ? floor($row->action_quantity / $recommendation->msg_price) : '';
							?>
								<tr >
									<td><span <?php if($row->status == 0){ echo "class='bold font-blue-chambray'"; } ?> ><?php echo $count; ?></span></td>
									<td><span <?php if($row->status == 0){ echo "class='bold font-blue-chambray'"; } ?> ><?php echo ($member) ? $member->mb_id : ''; ?></span></td>
									<td><span <?php if($row->status == 0){ echo "class='bold font-blue-chambray'"; } ?> ><?php echo $diff . number_format($row->action_quantity); ?></span></td>
									<td><span <?php if($row->status == 0){ echo "class='bold font-blue-chambray'"; } ?> ><?php echo number_format($row->current_quantity); ?></span></td>
									<!-- <td><span <?php if($row->status == 0){ echo "class='bold font-blue-chambray'"; } ?> ><?php echo number_format($row->reseller_revenue); ?></span></td>
									<td><span <?php if($row->status == 0){ echo "class='bold font-blue-chambray'"; } ?> ><?php echo number_format(floor($msg_quantity)); ?></span></td> -->
									<td><span <?php if($row->status == 0){ echo "class='bold font-blue-chambray'"; } ?> ><?php echo $row->created_date; ?></span></td>
								</tr>
							<?php
							}
							
							// $dates = ['Apr 1', 'Apr 2', 'Apr 3', 'Apr 4', 'Apr 5', 'Apr 6', 'Apr 7', 'Apr 8', 'Apr 9', 'Apr 10'];
							// $revenues = ['9140', '0', '5140', '9140', '120', '741', '99', '51700', '0', '15000'];
							$dates = [];
							$revenues = [];

							foreach ($chart as $row){
								$dt = explode(" ", $row->created_date);
								array_push($dates, $dt[0]);
								array_push($revenues, $row->action_quantity);
								// Sum action quantity
								$sum_action_quantity += $row->action_quantity;
								// Sum reseller revenue
								$sum_reseller_revenue += $row->reseller_revenue;


								// Get member
								// $member = $this->users_model->get_user('mb_no', $row->member_id);
								// // Set mesage quantity
								// $recommendation = $recommendation = $this->settings_model->get_msg_price($member->mb_recommend);
								// $msg_quantity = floor($row->action_quantity / $recommendation->msg_price);
								$sum_msg_quantity += $row->message_quantity;
							}

							$start_date = explode(" ", reset($dates));
							$end_date = explode(" ", end($dates));
							?>
							</tbody>
						</table>
					</div>

					<?php echo $pagination; ?>
				</div>
			</div>
		<!-- END PORTLET-->
		</div>
		<div class="col-md-6">
			<!-- BEGIN PORTLET-->
			<div class="portlet light " >
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-info font-green"></i>
						<span class="caption-subject font-green sbold uppercase">지불 통계</span>
					</div>
					<div class="actions">
						<div class="btn-group btn-group-devided">
						<!-- <a href="<?php echo base_url(); ?>admin/downloadMessageRequests" class="btn btn-primary btn-sm">
							<i class="fa fa-file-excel-o"></i> 엑셀 다운로드
						</a> -->
						</div>
					</div>
				</div>
				<?php
				// $colWidth = ($this->session->userdata('user_level') == 'Reseller') ? 'col-md-4' : 'col-md-6';
				$colWidth = 'col-md-12';
				?>
				<div class="portlet-body">
					<div class="row">
						<!-- <div class="<?php echo $colWidth; ?> col-xs-12">
							<a class="dashboard-stat dashboard-stat-v2 green" href="#">
								<div class="visual">
									<i class="fa fa-comments"></i>
								</div>
								<div class="details">
									<div class="number">
										<span data-counter="counterup" data-value=""> <?php echo number_format($sum_msg_quantity); ?></span>
									</div>
									<div class="desc"> 총 메시지 수량 </div>
								</div>
							</a>
						</div> -->
						<div class="<?php echo $colWidth; ?> col-xs-12">
							<a class="dashboard-stat dashboard-stat-v2 blue" href="#">
								<div class="visual">
									<i class="fa fa-bar-chart-o"></i>
								</div>
								<div class="details">
									<div class="number">
										<span data-counter="counterup" data-value=""> <?php echo number_format($sum_action_quantity);?></span> </div>
									<div class="desc"> 총 수익 </div>
								</div>
							</a>
						</div>
						<?php
						if ($this->session->userdata('user_level') == 'Reseller'){
						?>
						<!-- <div class="col-sm-4 col-xs-12">
							<a class="dashboard-stat dashboard-stat-v2 red" href="#">
								<div class="visual">
									<i class="icon-bar-chart"></i>
								</div>
								<div class="details">
									<div class="number">
										<span data-counter="counterup" data-value=""> <?php echo number_format($sum_reseller_revenue);?></span>
									</div>
									<div class="desc"> 리셀러 총 수익 </div>
								</div>
							</a>
						</div> -->
						<?php }?>
					</div>
					<div class="row padding-top-30">
						<div class="col-xs-12" id="chartt"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

<script>
	$(".alert").fadeTo(2000, 500).slideUp(500, function(){
		$(".alert").slideUp(500);
	});
</script>
<script>
	$(document).ready(function() {
		Highcharts.chart('chartt', {
			chart: {
					type: 'column'
			},
			title: {
					text: 'Daily revenue'
			},
			subtitle: {
					text: '<?php echo $start_date["0"] . " - " . $end_date["0"]; ?>'
			},
			xAxis: {
					categories: [<?php echo "'" . implode ( "', '", $dates ) . "'"; ?>],
					crosshair: true
			},
			yAxis: {
					min: 0,
					title: {
							text: 'Revenue (won)'
					}
			},
			tooltip: {
					headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
					pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
							'<td style="padding:0"><b>{point.y:.1f} (won)</b></td></tr>',
					footerFormat: '</table>',
					shared: true,
					useHTML: true
			},
			plotOptions: {
					column: {
							pointPadding: 0.2,
							borderWidth: 0
					}
			},
			series: [{
					name: 'Revenue',
					data: [<?php echo implode(",", $revenues); ?>]

			}]
		});
	});

</script>
</div>
