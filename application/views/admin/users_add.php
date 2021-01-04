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
				<span>회원 추가</span>
			</li>
		</ul>
	</div>
	<!-- /User edit bar -->

	<!-- User edit row -->
	<div class="row">

		<!-- User col 6 -->
		<div class="col-lg-12">
			<!-- BEGIN PORTLET-->
			<div class="portlet light ">

				<!-- Caption -->
				<div class="portlet-title">

					<div class="caption">
						<i class="icon-info font-green"></i>
						<span class="caption-subject font-green sbold uppercase">회원 추가</span>
					</div>

				</div>
				<!-- /Caption -->

				<!-- Body -->
				<div class="portlet-body form">
					<!-- Form action -->
					<form class="" action="/admin/userSave" method="post">

						<!-- Username -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="control-label" for="id">아이디</label>
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<input class="form-control" type="text" name="mb_id" autocomplete="username"
									value="<?php if(isset($_POST['mb_id'])){ echo "".$_POST['mb_id'].""; }?>">
								<span class="error_user_add"><?php echo form_error('mb_id') ?></span>
							</div>
						</div>
						<!-- Username -->

						<!-- Name -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="control-label" for="name">이름</label>
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<input class="form-control" type="text" name="mb_name" autocomplete="name"
									value="<?php if(isset($_POST['mb_name'])){ echo "".$_POST['mb_name'].""; }?>">
								<span class="error_user_add"><?php echo form_error('mb_name') ?></span>
							</div>
						</div>
						<!-- Name -->

						<!-- Email -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="control-label" for="email">이메일</label>
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<input class="form-control" type="text" name="mb_email" autocomplete="email"
									value="<?php if(isset($_POST['mb_email'])){ echo "".$_POST['mb_email'].""; }?>">
								<span class="error_user_add"><?php echo form_error('mb_email') ?></span>
							</div>
						</div>
						<!-- /Email -->

						<!-- Email -->

						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2">수평</label>
							</div>
							<div class="col-12 col-sm-6 ">
								<div class="mt-radio-inline">
									<?php if ($this->session->userData('user_level') == 'Super admin') {?>
									<label class="mt-radio mt-radio-outline">
										<input type="radio" id="level_reseller" name="mb_level" value="Reseller"
											<?php if(isset($_POST['mb_level']) && $_POST['mb_level'] == 'Reseller'){ echo "checked"; }?>>
										Reseller
										<span></span>
									</label>
									<label class="mt-radio mt-radio-outline">
										<input type="radio" id="level_organization" name="mb_level" value="Organization"
											<?php if(isset($_POST['mb_level']) && $_POST['mb_level'] == 'Organization'){ echo "checked"; }?>>
										Organization
										<span></span>
									</label>
									<?php }?>
									<label class="mt-radio mt-radio-outline ml-2">
										<input type="radio" id="level_customer" name="mb_level" value="Customer"
											<?php if(!isset($_POST['mb_level']) || (isset($_POST['mb_level']) && $_POST['mb_level'] == 'Customer') ){ echo "checked"; }?>>
										Customer
										<span></span>
									</label>	
								</div>
							</div>
						</div>
						<!-- /Email -->

						<!-- Password -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2" for="password">비밀번호</label>
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<input class="form-control" type="password" name="mb_password" autocomplete="new-password"
									value="<?php if(isset($_POST['mb_password'])){ echo "".$_POST['mb_password'].""; }?>">
								<span class="error_user_add"><?php echo form_error('mb_password') ?></span>
							</div>
						</div>
						<!-- /Password -->

						<!-- Confirm password -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2" for="password_re">비밀번호 확인</label>
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<input class="form-control" type="password" name="mb_password_re" autocomplete="new-password"
									value="<?php if(isset($_POST['mb_password_re'])){ echo "".$_POST['mb_password_re'].""; }?>">
								<span class="error_user_add"><?php echo form_error('mb_password_re') ?></span>
							</div>
						</div>
						<!-- /Confirm password -->

						<!-- Recommend -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2" for="mb_recommend">추천 코드</label>
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<select class="form-control" name="mb_recommend" id="recommendation">
                                    <?php foreach ($rec_code as $rec){ ?>
									
                                        <option value="<?php echo $rec->rec_id; ?>">
                                            <?php echo $rec->rec_code.' ('.$rec->msg_price.'원)'; ?>
                                        </option>
									<?php }?>
								</select>
							</div>
						</div>
						<!-- /Recommend -->
						
						<!-- Reseller for user -->
						<?php if ($this->session->userData('user_level') == 'Reseller') {?>
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2" for="reseller_id">리셀러 코드</label>
							</div>
							<div class="col-12 col-sm-6">
								<select class="form-control" name="reseller_id" readonly>
									<?php foreach ($resellers as $reseller){ ?>
									<option value="<?php echo $reseller->mb_no; ?>"
										<?php if($reseller->mb_no == $this->session->userData('id')){ echo "selected";} ?>>
										<?php echo $reseller->mb_id.'  ('.$reseller->reseller_code.')'; ?></option>
									<?php }?>
								</select>
							</div>
						</div>
						<?php }?>
						<!-- /Reseller for user -->

						<!-- reseller_code -->
						<?php
						$reseller_code = '';
						if(isset($_POST['mb_reseller_code'])){
							$reseller_code = $_POST['mb_reseller_code'];
						}
						if($this->session->userData('user_level') == 'Reseller') {
							$reseller = $this->users_model->get_user('mb_no', $this->session->userData('id'));
							$reseller_code = $reseller->reseller_code;
						}
						$generateNumber = $this->users_model->generateRandomString(2);
						?>
						<div class="form-group row reseller_code">
							<div class="col-12 col-sm-3 text-right">
								<label class="control-label" for="reseller_code">Reseller code</label>
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<input class="form-control" id="reseller_code" type="hidden" name="mb_reseller_code"
									autocomplete="reseller_code"
									value="<?php echo isset($_POST['mb_reseller_code']) ? $_POST['mb_reseller_code'] : $generateNumber; ?>">
								<span class="error_user_add"><?php echo form_error('mb_reseller_code') ?></span>
							</div>
						</div>
						<!-- reseller_code -->

						<!-- customer code -->
						<div class="form-group row customer_code">
							<div class="col-12 col-sm-3 text-right">
								<label class="control-label" for="customer_code">Customer code</label>
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<input class="form-control" id="customer_code" type="hidden" name="mb_customer_code"
									autocomplete="customer_code"
									value="<?php echo isset($_POST['mb_customer_code']) ? $_POST['mb_customer_code'] : $generateNumber; ?>">
								<span class="error_user_add"><?php echo form_error('mb_customer_code') ?></span>
							</div>
						</div>
						<!-- customer code -->

						<!-- organization code -->
						<div class="form-group row organization_code">
							<div class="col-12 col-sm-3 text-right">
								<label class="control-label" for="organization_code">Organization code</label>
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<input class="form-control" id="organization_code" type="hidden" name="mb_organization_code"
									autocomplete="organization_code"
									value="<?php echo isset($_POST['mb_organization_code']) ? $_POST['mb_organization_code'] : $generateNumber; ?>">
								<span class="error_user_add"><?php echo form_error('mb_organization_code') ?></span>
							</div>
						</div>
						<!-- organization code -->

						<!-- mb_open -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2">발송 중지</label>
							</div>
							<div class="col-12 col-sm-6 ">
								<div class="mt-radio-inline">
									<label class="mt-radio mt-radio-outline">
										<input type="radio" name="mb_open" value="0"
											<?php if(!isset($_POST['mb_open']) || (isset($_POST['mb_open']) && $_POST['mb_open'] == '0') ){ echo "checked"; }?>>
										정상
										<span></span>
									</label>
									<label class="mt-radio mt-radio-outline ml-2">
										<input type="radio" name="mb_open" value="1"
											<?php if(isset($_POST['mb_open']) && $_POST['mb_open'] == '1'){ echo "checked"; }?>>
										중지
										<span></span>
									</label>
								</div>
							</div>
						</div>
						<!-- mb_open -->

						<!-- Button group -->
						<div class="form-group row">

							<div class="col-12 col-sm-3">
							</div>
							<div class="col-12 col-md-6 text-right">

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
	</div>
	<!-- /User edit row -->

	<!-- Custom script -->
	<script>
		$(".alert").fadeTo(2000, 500).slideUp(500, function () {
			$(".alert").slideUp(500);
		});

		$(".reseller_code").hide();
		$(".customer_code").hide();
		$(".organization_code").hide();


		

	</script>
	<!-- /Custom script -->

	<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
</div>
