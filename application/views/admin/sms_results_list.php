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

	<!-- Chart -->
	<div class="row">
		<div class="col-sm-3 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 green" href="#">
				<div class="visual">
					<i class="fa fa-comments"></i>
				</div>
				<div class="details">
					<div class="number">
						<span data-counter="counterup" data-value="" id="msg_count_today"><img
								src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="15" style="z-index: 999;"></span>
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
						<span data-counter="counterup" data-value="" id="msg_count_month"><img
								src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="15" style="z-index: 999;"> </span>
					</div>
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
						<span data-counter="counterup" data-value="" id="msg_count_all"><img
								src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="15" style="z-index: 999;"></span>
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
							$reseller_id = ($this->session->userData('user_level') == 'Reseller') ? $this->session->userData('id') : null;
							echo $this->users_model->get_total_revenue($reseller_id);
						?>
						<!-- <span data-counter="counterup" data-value="" id="reseller_count_revenue_all"></span> -->
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
			$(document).ready(function () {
				var id = 0;
				$.ajax({
					type: 'POST',
					url: '/home/all_msg_count',
					dataType: "JSON",
					async: true,
					data: {
						msg_id: id
					},
					success: function (data) {
						console.log(data.msg_count_all);
						$('#msg_count_all').html(data.msg_count_all);
						$('#msg_count_month').html(data.msg_count_month);
						$('#msg_count_today').html(data.msg_count_today);
					}
				});
			});

		</script>
	</div>
	<!-- /Chart -->
	<div class="clearfix"></div>

	<!-- Main container -->
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
							<!--                        <a href="--><?php //echo base_url(); ?>
							<!--admin_panel/banner/add" class="btn btn-success btn-sm">-->
							<!--                            <i class="glyphicon glyphicon-plus"></i> New-->
							<!--                        </a>-->
							<form form class="" action="<?php echo base_url() ?>admin/downloadMessageResults" method="post">

								<!-- Select level -->
								<div class="col-sm-2" style="display:none;">
									<select name="mb_level_excel" class="form-control mbLevel" tabindex="1">
										<option value="all">회원 코드 선택</option>
										<option value="Customer"
											<?php echo ($this->session->userData('search_mb_level') == "Customer") ? 'selected' : ''; ?>>
											Customer</option>
										<option value="Reseller"
											<?php echo ($this->session->userData('search_mb_level') == "Reseller") ? 'selected' : ''; ?>>
											Reseller</option>
										<option value="Organization"
											<?php echo ($this->session->userData('search_mb_level') == "Organization") ? 'selected' : ''; ?>>
											Organization</option>
									</select>
								</div>
								<!-- /Select level -->

								<!-- Select code -->
								<div class="col-sm-2" style="display:none;">
									<select name="" class="form-control" tabindex="2">
										<option value="all">코드를 선택하십시오</option>
									</select>

									<!-- Select Customer -->
									<select name="code_customer_excel" class="form-control codeCustomer" tabindex="2">
										<option value="all">--Select Customer--</option>
										<?php
										foreach ($codeCustomers as $codeCustomer){
										?>
										<option value="<?php echo $codeCustomer->mb_code; ?>"
											<?php echo ($this->session->userData('search_code_customer') == $codeCustomer->mb_code) ? 'selected' : ''; ?>>
											<?php echo $codeCustomer->mb_code; ?></option>
										<?php
										}
										?>
									</select>
									<!-- Select Customer -->

									<!-- Select Reseller -->
									<select name="code_reseller_excel" class="form-control codeReseller" tabindex="2">
										<option value="all">--Select Reseller--</option>
										<?php
										foreach ($codeResellers as $codeReseller){
										?>
										<option value="<?php echo $codeReseller->mb_code; ?>"
											<?php echo ($this->session->userData('search_code_reseller') == $codeReseller->mb_code) ? 'selected' : ''; ?>>
											<?php echo $codeReseller->mb_code; ?></option>
										<?php
										}
										?>
									</select>
									<!-- Select Reseller -->

									<!-- Select Organization -->
									<select name="code_organization_excel" class="form-control codeOrganization" tabindex="2">
										<option value="all">--Select Organization--</option>
										<?php
										foreach ($codeOrganizations as $codeOrganization){
										?>
										<option value="<?php echo $codeOrganization->mb_code; ?>"
											<?php echo ($this->session->userData('search_code_organization') == $codeOrganization->mb_code) ? 'selected' : ''; ?>>
											<?php echo $codeOrganization->mb_code; ?></option>
										<?php
										}
										?>
									</select>
									<!-- /Select Organization -->
								</div>
								<!-- /Select code -->

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
								<input type="hidden" id="searchDate" name="excel_date" class="datepicker-here form-control"
									data-language='kr' data-range="true" data-multiple-dates-separator="~" placeholder="발송일"
									autocomplete="off" value="<?php 
										
											if(is_array( $date) && count($date) == 1) {
												echo $date[0];
											} 
											
											if (is_array($date) && count($date) == 2){
												
												echo $date[0] .'~'. $date[1];
											}

										?>" />

								<button type="submit" class="btn btn-primary btn-sm" id="submitSearch">
									<i class="fa fa-file-excel-o"></i> 엑셀 다운로드
								</button>
							</form>
						</div>
					</div>
				</div>
				<div class="portlet-body " id="table_id">
					<div class="searchby">
						<form class="" action="<?php echo base_url() ?>admin/sms_search" method="post">
							<div class="row">
								<?php 
								if($this->session->userData('user_level') == 'Super admin') {
								?>
								<!-- Select level -->
								<div class="col-sm-2">
									<select name="mb_level" class="form-control" id="dateselector_parent" tabindex="1">
										<option value="all">회원 코드 선택</option>
										<option value="Customer"
											<?php echo ($this->session->userData('search_mb_level') == "Customer") ? 'selected' : ''; ?>>
											Customer</option>
										<option value="Reseller"
											<?php echo ($this->session->userData('search_mb_level') == "Reseller") ? 'selected' : ''; ?>>
											Reseller</option>
										<option value="Organization"
											<?php echo ($this->session->userData('search_mb_level') == "Organization") ? 'selected' : ''; ?>>
											Organization</option>
									</select>
								</div>
								<!-- /Select level -->

								<!-- Select code -->
								<div class="col-sm-2">
									<select name="" class="form-control" id="dateselector_child_all" tabindex="2">
										<option value="all">코드를 선택하십시오</option>
									</select>

									<!-- Select Customer -->
									<select name="code_customer" class="form-control codeCustomer" id="dateselector_child_Customer"
										tabindex="2">
										<option value="all">--Select Customer--</option>
										<?php
										foreach ($codeCustomers as $codeCustomer){
										?>
										<option value="<?php echo $codeCustomer->mb_code; ?>"
											<?php echo ($this->session->userData('search_code_customer') == $codeCustomer->mb_code) ? 'selected' : ''; ?>>
											<?php echo $codeCustomer->mb_code; ?></option>
										<?php
										}
										?>
									</select>
									<!-- Select Customer -->

									<!-- Select Reseller -->
									<select name="code_reseller" class="form-control codeReseller" id="dateselector_child_Reseller"
										tabindex="2">
										<option value="all">--Select Reseller--</option>
										<?php
										foreach ($codeResellers as $codeReseller){
										?>
										<option value="<?php echo $codeReseller->mb_code; ?>"
											<?php echo ($this->session->userData('search_code_reseller') == $codeReseller->mb_code) ? 'selected' : ''; ?>>
											<?php echo $codeReseller->mb_code; ?></option>
										<?php
										}
										?>
									</select>
									<!-- Select Reseller -->

									<!-- Select Organization -->
									<select name="code_organization" class="form-control codeOrganization"
										id="dateselector_child_Organization" tabindex="2">
										<option value="all">--Select Organization--</option>
										<?php
										foreach ($codeOrganizations as $codeOrganization){
										?>
										<option value="<?php echo $codeOrganization->mb_code; ?>"
											<?php echo ($this->session->userData('search_code_organization') == $codeOrganization->mb_code) ? 'selected' : ''; ?>>
											<?php echo $codeOrganization->mb_code; ?></option>
										<?php
										}
										?>
									</select>
									<!-- /Select Organization -->
								</div>
								<!-- /Select code -->


								<?php 
								} else {
								?>
								<input type="hidden" name="reseller" value="all" />
								<?php	
								}
								?>

								<div class="col-sm-2">
									<input type="text" class="form-control userId" id="searchUserId" name="user_id" placeholder="회원아이디"
										value="<?php echo $this->session->userdata('search_user_id'); ?>">
								</div>


								<div class="col-sm-2">
									<?php $date = $this->session->userdata('search_date');?>
									<?php 
										if ($this->session->userdata('search_date') != null){
											$date = $this->session->userdata('search_date');
										} else {
											$date = '';
										}
									?>
									<input type="text" id="searchDate" name="date" class="datepicker-here form-control" data-language='kr'
										data-range="true" data-multiple-dates-separator=" ~ " placeholder="발송일" autocomplete="off" value="<?php 
										
											if(is_array( $date) && count($date) == 1) {
												echo $date[0];
											} 
											
											if (is_array($date) && count($date) == 2){
												
												echo $date[0] .'~'. $date[1];
											}

										?>" />
								</div>

								<div class="col-sm-4">
									<button type="submit" class="btn blue" id="submitSearch">
										<i class="icon-magnifier"></i>검색
									</button>
									<a type="reset" class="btn blue btn-outline" href="<?php echo base_url() ?>admin/smsResults">
										<i class="icon-refresh"></i>초기화
									</a>
								</div>
							</div>
						</form>
					</div>

					<div class="table-scrollable table-scrollable-borderless">
						<table class="table table-striped  table-light">
							<thead>
								<tr>
									<th style="text-align: center" width="3%">번호</th>
									<th style="text-align: center" width="8%">회원아이디</th>
									<th style="text-align: center" width="4%">발신번호</th>
									<th style="text-align: center" width="3%">SMS count</th>
									<th style="text-align: center" width="24%">메시지</th>
									<th style="text-align: center" width="7%">발송 </th>
									<th style="text-align: center" width="7%">성공</th>
									<!-- <th width="7%">대기</th>
<th width="7%">확인불가</th> -->

									<th style="text-align: center" width="7%">보류 중</th>
									<th style="text-align: center" width="7%">실패</th>
									<th style="text-align: center" width="15%">등록일</th>
									<th style="text-align: center" width="15%">Action</th>

								</tr>
							</thead>
							<tbody class="bg-white" style="text-align: center">
								<?php
									$count = $countstart;
									foreach ($sms_results as $row){ $count++;
									$member = $this->users_model->get_user_one($row->member_id);
								?>
								<tr data-id="<?php echo $row->id ?>">
									<td><?php echo $count; ?>
										<?php
											$datetime1 = date_create($row->created_date);
											$datetime2 = date_create(date("Y-m-d"));
											$interval = date_diff($datetime1, $datetime2);
											if ($interval->format('%a') < 7 ) {
										?>
										<input class="send_request" type="hidden" name="" value="<?php echo $row->id ?>">
										<?php 
											}; 
										?>
									</td>
									<td>
										<a href="<?php echo base_url(); ?>admin/sms_detail/<?php echo $row->id; ?>">
											<?php 
												if($member != null) { 
													echo $member->mb_id;
												} else { 
													echo "삭제 된 사용자";
												} 
											?>
										</a>
									</td>
									<td>
										<a href="<?php echo base_url(); ?>admin/sms_detail/<?php echo $row->id; ?>">
											<?php echo $row->sender; ?>
										</a>
									</td>
									<td>
										<?php echo $row->split_count * $row->delivered_count; ?>
									</td>
									<td style="text-align: left">
										<?php
										echo $row->message;
										?>
									</td>
									<td style="background-color: #3598dc; color: white">
										<span id="total<?php echo $row->id; ?>">
											<?php echo $row->quantity; ?>
										</span> 건
									</td>

									<td style="background-color: #26C281; color: white">
										<span id="successmsg<?php echo $row->id; ?>">
											<?php echo $row->delivered_count; ?>
										</span> 건
									</td>

									<td style="background-color: #c3c3c3; color: white">
										<span id="total<?php echo $row->id; ?>">
											<?php 
												$pendingNumber = $row->delivered_count + $row->error_count;
												$result = $row->quantity - $pendingNumber;
												echo $result; ?> 건
										</span>
									</td>

									<td style="background-color: #e7505a; color: white">
										<span id="errormsg<?php echo $row->id; ?>"><?php echo $row->error_count; ?></span>
										건
									</td>
									<td>
										<?php echo $row->created_date; ?>
									</td>
									<td>
										<a href="<?php echo base_url(); ?>admin/sms_detail/<?php echo $row->id ?>"
											class="btn btn-sm blue-hoki">
											<i class="icon-paper-plane"></i> 발송 상세
										</a>
										<a href="<?php echo base_url(); ?>admin/downloadMessageResult/<?php echo $row->id ?>"
											class="btn btn-primary btn-sm">
											<i class="fa fa-file-excel-o"></i>
										</a>
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
	<!-- End Container -->
	
	<script>
		$(document).ready(function () {
			$().ready(function () {

				var selectedOnLoad = $('#dateselector_parent').val();
				setChild(selectedOnLoad);

				$('#dateselector_parent').change(function () {
					var selectedValue = $('#dateselector_parent').val();
					setChild(selectedValue);
				});

				});

				function setChild(value) {
				//Have your three child selector names as follows in your markup as well and assuming they are not in divs
				var arr = ["dateselector_child_all", "dateselector_child_Customer", "dateselector_child_Reseller",
					"dateselector_child_Organization"
				];

				jQuery.each(arr, function () {
					if (this == "dateselector_child_" + value) {

						$("#" + this).show();

						if($("#" + this).val() != "all"){
							$('.userId').prop('disabled', 'disabled');
						}else {
							$('.userId').prop('disabled', '');
						}
					} else {
						$("#" + this).hide();
						$("#" + this).val("all");
					}
				});
			}

			$('.codeCustomer').change(function () {
				var select_value = $(this).val();

				if (select_value !== 'all') {
					$('.userId').prop('disabled', 'disabled');
				} else {
					$('.userId').prop('disabled', '');
				}
			});


			$('.codeReseller').change(function () {
				var select_value = $(this).val();

				if (select_value !== 'all') {
					$('.userId').prop('disabled', 'disabled');
				} else {
					$('.userId').prop('disabled', '')
				}
			});

			 
			$('.codeOrganization').change(function () {
				var select_value = $(this).val();

				if (select_value !== 'all') {
					$('.userId').prop('disabled', 'disabled');
				} else {
					$('.userId').prop('disabled', '');
				}
			});

		});
	</script>

	<script>
		$(".alert").fadeTo(2000, 500).slideUp(500, function () {
			$(".alert").slideUp(500);

		});

		$(window).on('load', function () {
			requestResult();
			setInterval(function () {
				count++;
				if (!stop) {
					requestResult()
				}
			}, 5000);
		});
		var count = 0;
		var stop = false;

		function requestResult() {
			var $data = [];
			$el = $('.send_request');
			if ($el.length > 0) {
				for (var i = 0; i < $el.length; i++) {
					$data.push($el.eq(i).val())
				};
				$.ajax({
					url: '/users/get_detail_new',
					type: "POST",
					async: true,
					cache: false,
					data: {
						id: $data,
					},
					success: function (result) {
						if (result == 0) {
							stop = true;
						} else {
							result = $.parseJSON(result);
							for (var j = 0; j < result.length; j++) {
								id = parseInt(result[j].message_id);
								$('tr[data-id=' + id + ']').find('.success span').text(result[j].delivered_count);
								$('tr[data-id=' + id + ']').find('.danger span').text(result[j].error_count);
							};
						}


					}
				})
			}


		};

	</script>
</div>
