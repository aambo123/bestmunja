<div class="page-content">
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
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN PORTLET-->
			<div class="portlet light " style="z-index: 1;">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-info font-green"></i>
						<span class="caption-subject font-green sbold uppercase">회원관리</span>
					</div>
					<div class="actions">
						<div class="btn-group btn-group-devided">
							<!--                        <a href="--><?php //echo base_url(); ?>
							<!--admin_panel/banner/add" class="btn btn-success btn-sm">-->
							<!--                            <i class="glyphicon glyphicon-plus"></i> New-->
							<!--                        </a>-->
							<form form class="" action="<?php echo base_url() ?>admin/downloadMembers" method="post">

								<!-- Select level -->
								<div class="col-sm-2" style="display:none;">
									<select name="mb_level_excel" class="form-control" tabindex="1">
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
									data-language='kr' data-range="false" data-multiple-dates-separator="~" placeholder="발송일"
									autocomplete="off" value="<?php 
										
											if(is_array( $date) && count($date) == 1) {
												echo $date[0];
											} 
											
											if (is_array($date) && count($date) == 2){
												
												echo $date[0] .'~'. $date[1];
											}

										?>" />
								<a href="<?php echo base_url(); ?>admin/userAdd" class="btn btn-success btn-sm">
									<i class="glyphicon glyphicon-plus"></i> New
								</a>
								<button type="submit" class="btn btn-primary btn-sm" id="submitSearch">
									<i class="fa fa-file-excel-o"></i> 엑셀 다운로드
								</button>
							</form>
						</div>
					</div>
				</div>
				<div class="portlet-body " id="table_id">
					<div class="searchby">
						<form class="" action="<?php echo base_url() ?>admin/member_search" method="post">
							<div class="row">
								<?php 
								if($this->session->userData('user_level') == 'Super admin') {
								?>
								<!-- Select level -->
								<div class="col-sm-2">
									<select name="mb_level" class="form-control mbLevel" id="dateselector_parent" tabindex="1">
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
									<a type="reset" class="btn blue btn-outline" href="<?php echo base_url() ?>admin/members">
										<i class="icon-refresh"></i>초기화
									</a>
								</div>

							</div>

						</form>
					</div>

					<form action="/admin/members_account_change" method="post" name="listfrm" id="listfrm" class="form-inline"
						role="list">
						<input type="hidden" name="idx" />
						<input type="hidden" name="account_id" id="account_id" />
						<div class="table-scrollable table-scrollable-borderless">
							<table class="table table-striped table-light" style="z-index: 999 !important;">
								<thead>
									<tr style="text-align: left;">
										<th width="3%"><input type="checkbox" name="chkAll" id="chkAll" /></th>
										<th width="4%">번호</th>
										<th width="8%">회원아이디</th>
										<?php if($this->session->userData('user_level') == 'Super admin') {?>
										<th width="8%">Member code</th>
										<?php } ?>
										<th width="8%">이메일</th>
										<th width="8%">Level</th>
										<th width="8%"> 추천 코드</th>

										<th width="8%">금일</th>
										<th width="8%">전체</th>
										<th width="8%">남은 CASH</th>

										<th width="10%">등록일</th>
										<th width="10%">표시 / 편집 / 삭제</th>
									</tr>
								</thead>
								<tbody class="bg-white">
									<?php
							$count = $countstart;
							foreach ($users as $row){ $count++;
								$member = $this->users_model->get_user_one($row->reseller_id);
								$today_count = $this->users_model->get_today_count($row->mb_no);
								$all_count = $this->users_model->get_all_count($row->mb_no);


								// print_r($smsAddRequets);
								// die();
								$resellerDisabled = ($row->reseller_id) ? $this->users_model->get_user('mb_no', $row->reseller_id) : null;
								$disabled = '';
								$disabledStyle = '';

								// Super admin
								if ($this->session->userdata('user_level') == 'Super admin' && $resellerDisabled){
									if ($row->mb_no == $row->reseller_id) {
										$disabled = '';
										$disabledStyle = '';
									} else {
										$disabled = 'disabled';
										$disabledStyle = 'pointer-events: none;';
									}
								}

								$sms_account = $this->users_model->get_sms_account($row->sms_account_id);
								?>
									<tr <?php if ($row->mb_open == 1): ?> style="background: #ffdbdb" <?php endif; ?>>
										<td><input type="checkbox" name="idx[]" class="input_chk" value="<?php echo $row->mb_no ?>" /></td>
										<td><?php echo $count; ?></td>
										<td><?php echo $row->mb_id; ?></td>
										<?php if($this->session->userData('user_level') == 'Super admin') {?>
										<td><?php 
											if($row->mb_code != null) { 
												echo $row->mb_code;
											} else { 
												echo "회원 코드가 없습니다";
											} 
										?>
										</td>
										<?php }?>
										<td><?php echo $row->mb_email; ?></td>
										<td><?php echo $row->mb_level; ?></td>
										<?php $recommend_price = $this->settings_model->get_recommendation_one_by_id($row->mb_recommend); 
									?>
										<td>
											<?php 
									if($recommend_price) {
										echo $row->mb_recommend. ' (' . $recommend_price->msg_price .')';
									} else {
										echo $row->mb_recommend;
									}
									?>
										</td>

										<td><span id="today_count<?php echo $row->mb_no; ?>"><img
													src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="15"
													style="z-index: 999;"></span> 건</td>
										<td><span id="all_count<?php echo $row->mb_no; ?>"><img
													src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="15"
													style="z-index: 999;"></span> 건</td>
										<td> <?php echo $row->msg_quantity; ?> Cash</td>

										<td><?php echo $row->mb_datetime; ?></td>
										<td>
											<a href="<?php echo base_url();?>admin/user_Show/<?php echo $row->mb_no; ?>"
												class="btn btn-xs green"><i class="glyphicon glyphicon-eye-open"></i> </a>
											<a href="<?php echo base_url();?>admin/user_Edit/<?php echo $row->mb_no; ?>"
												class="btn btn-xs blue" style="<?php echo $disabledStyle ?>" <?php echo $disabled ?>><i
													class="glyphicon glyphicon-edit"></i> </a>
											<a href="<?php echo base_url();?>admin/usersDelete/<?php echo $row->mb_no; ?>"
												data-toggle="confirmation" data-original-title=" " data-placement="top" class="btn btn-xs red"
												style="<?php echo $disabledStyle ?>" <?php echo $disabled ?>><i
													class="glyphicon glyphicon-trash"></i> </a>
										</td>
									</tr>

									<script>
										$(document).ready(function () {
											$.ajax({
												type: 'POST',
												url: '/home/member_msg_count',
												dataType: "JSON",
												async: true,
												data: {
													member_id: <?php echo $row->mb_no; ?>
												},
												success: function (data) {
													console.log(data.success_msgs);
													$('#all_count<?php echo $row->mb_no; ?>').html(data.count_all);
													$('#today_count<?php echo $row->mb_no; ?>').html(data.count_today);

												}

											});
										});

									</script>
									<?php }?>
								</tbody>
							</table>

						</div>

						<?php echo $pagination; ?>


					</form>
				</div>
			</div>
			<!-- END PORTLET-->
		</div>
	</div>

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
		function goChange(val) {

			if ($("input[name='idx[]']:checkbox:checked").length < 1) {
				alert("글을 1개이상 체크해주세요");
				return;
			}

			var aMsg = confirm("통신사 계정을 변경 하시겠습니까?");

			if (aMsg == true) {
				$("#account_id").val(val);
				$("#listfrm").submit();
			} else {

			}
		}

	</script>
	<script>
		$(document).ready(function () {
			// ========================================
			// 전체선택 / 전체해제 하기
			$("#chkAll").click(function () {
				//만약 전체 선택 체크박스가 체크된상태일경우
				if ($("#chkAll").prop("checked")) {
					//해당화면에 전체 checkbox들을 체크해준다
					$("input[type=checkbox]").prop("checked", true);
					// 전체선택 체크박스가 해제된 경우
				} else {
					//해당화면에 모든 checkbox들의 체크를해제시킨다.
					$("input[type=checkbox]").prop("checked", false);
				}
			});

			$("#lan01").trigger("click");

			$("#search_title_content").keydown(function (e) {
				if (e.keyCode == 13) {
					e.preventDefault();
					goSearch();
				}
			});

		});

		$(".alert").fadeTo(2000, 500).slideUp(500, function () {
			$(".alert").slideUp(500);

		});

	</script>
</div>
