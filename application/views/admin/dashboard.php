<div class="page-content">
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo base_url(); ?>admin">Admin</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<span>관리자홈</span>
			</li>
		</ul>

	</div>
	<div class="row">
		<div class="col-sm-3 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 green" href="#">
				<div class="visual">
					<i class="fa fa-comments"></i>
				</div>
				<div class="details">
					<div class="number">
						<span data-counter="counterup" data-value="" id="msg_count_today"><img src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="15" style="z-index: 999;"></span>
					</div>
					<div class="desc"> 오늘의 총 문자 </div>
				</div>
			</a>
		</div>
		<div class="col-sm-3 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 blue" href="#">
				<div class="visual">
					<i class="fa fa-bar-chart-o"></i>
				</div>
				<div class="details">
					<div class="number">
						<span data-counter="counterup" data-value="" id="msg_count_month"><img src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="15" style="z-index: 999;"></span> </div>
					<div class="desc"> 이번달의 총 문자 </div>
				</div>
			</a>
		</div>
		<div class="col-sm-3 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 grey-bold" href="#">
				<div class="visual">
					<i class="icon-bar-chart"></i>
				</div>
				<div class="details">
					<div class="number">
						<span data-counter="counterup" data-value="" id="msg_count_all"><img src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="15" style="z-index: 999;"></span>
					</div>
					<div class="desc"> 총 문자 </div>
				</div>
			</a>
		</div>
		<div class="col-sm-3 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 orange" href="#">
				<div class="visual">
					<i class="fa fa-money"></i>
				</div>
				<div class="details">
					<div class="number">
						<?php
							echo $this->users_model->get_total_revenue();
						?>
					</div>
					<?php if($this->session->userData('user_level') == 'Super admin') { ?>
						<div class="desc"> 리셀러 총 수익 </div>
					<?php } ?>
					<?php if($this->session->userData('user_level') == 'Reseller') { ?>
						<div class="desc"> 총 수익 </div>
					<?php } ?>	
				</div>
			</a>
		</div>
		<script>
			$(document).ready(function() {
				var id = 0;
				$.ajax({
					type: 'POST',
					url: '/home/all_msg_count',
					dataType: "JSON",
					async: true,
					data: {
						msg_id: id
					},
					success: function(data) {
						console.log(data.msg_count_all);
						$('#msg_count_all').html(data.msg_count_all);
						$('#msg_count_month').html(data.msg_count_month);
						$('#msg_count_today').html(data.msg_count_today);
					}

				});
			});
		</script>
	</div>
	<div class="clearfix"></div>
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
<!--                        <a href="--><?php //echo base_url(); ?><!--admin_panel/banner/add" class="btn btn-success btn-sm">-->
<!--                            <i class="glyphicon glyphicon-plus"></i> New-->
<!--                        </a>-->
							<input type="hidden" id="dates">
							<input type="hidden" id="data">
						</div>
					</div>
				</div>
				<?php

				?>
				<div class="portlet-body " id="table_id">
					<div style="text-align: center;">
					<img src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="80" style=" z-index: 999;">
					</div>
				</div>

				<div class="portlet-body " id="customer_id">
					<!-- Achievment -->
				</div>
				<script>
					$(document).ready(function() {
						var id = 0;
						$.ajax({
							type: 'POST',
							url: '/admin/date_count',

							dataType: "json",
							async: true,
							data: {
								msg_id: id
							},
							success: function(data) {
								var dates = data.dates;
								var counts = data.counts;
								var a =  dates.split(',');
								var b = counts.split(',');
								var c = b.map(Number);
								console.log(c)
								var chart = Highcharts.chart('table_id', {
									title: {
										text: '발송 결과'
									},
									subtitle: {
										text: 'Last 7 days'
									},
									yAxis: {
										title: {
											text: '총 문자'
										}
									},
									xAxis: {
										categories: a
									},
									series: [{
										name: '보낸 메시지',
										color: 'rgba(153,158,255,1)',
										type: 'column',
										data: c,
										showInLegend: false
									}]
								});


								$('#plain').click(function () {
									chart.update({
										chart: {
											inverted: false,
											polar: false
										},
										subtitle: {
											text: 'Plain'
										}
									});
								});

								$('#inverted').click(function () {
									chart.update({
										chart: {
											inverted: true,
											polar: false
										},
										subtitle: {
											text: 'Inverted'
										}
									});
								});

								$('#polar').click(function () {
									chart.update({
										chart: {
											inverted: false,
											polar: true
										},
										subtitle: {
											text: 'Polar'
										}
									});
								});
							}

						});
					});

				</script>
			</div>
		<!-- END PORTLET-->
		</div>
	</div>

<script>
	$(".alert").fadeTo(2000, 500).slideUp(500, function(){
		$(".alert").slideUp(500);
	});
</script>
</div>

