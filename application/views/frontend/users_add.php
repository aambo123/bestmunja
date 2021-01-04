<div class="container-fluid">

	<div class="row">
		<div class="col-12 col-lg-7">
			<div class="card bg-white p-2">
				<form class="" action="<?php echo base_url(); ?>admin/user_add_set" method="post">
					<div class="form-group row">
						<div class="col-12 col-sm-3">
							<label class="my-2" for="id">ID</label>
							<span class="txt-red">*</span>
						</div>
						<div class="col-12 col-sm-6">
							<input class="form-control" type="text" name="username" id="id" required maxlength="20">
						</div>
						<div class="col-12 col-sm-3 flex align-center">
						    <span class="small">(최대20자 이내로 입력하세요)</span>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12 col-sm-3">
							<label class="my-2" for="password">비밀번호</label>
							<span class="txt-red">*</span>
						</div>
						<div class="col-12 col-sm-6">
							<input class="form-control" type="password" name="password" id="password" required maxlength="20">
						</div>
					    <div class="col-12 col-sm-3 flex align-center">
						   <span class="small">(최대20자 이내로 입력하세요)</span>
					    </div>
					</div>
					<div class="form-group row">
						<div class="col-12 col-sm-3">
							<label class="my-2" for="name">이름</label>
							<span class="txt-red">*</span>
						</div>
						<div class="col-12 col-sm-6">
							<input class="form-control" type="text" name="name"  id="name" required maxlength="20">
						</div>
					    <div class="col-12 col-sm-3 flex align-center">
						   <span class="small">(최대20자 이내로 입력하세요)</span>
					    </div>
					</div>
					<div class="form-group row">
						<div class="col-12 col-sm-3">
							<label class="my-2" for="phone">전화번호</label>
							<span class="txt-red">*</span>
						</div>
						<div class="col-12 col-sm-6">
							<input class="form-control numbersOnly" type="phone" name="phone" id="phone" required maxlength="15">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12 col-sm-3">
							<label class="my-2" for="1s2u_username">연동 username</label>
							<span class="txt-red">*</span>
						</div>
						<div class="col-12 col-sm-6">
							<input class="form-control" type="text" name="z_username" id="z_username" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12 col-sm-3">
							<label class="my-2" for="1s2u_password">연동 password</label>
							<span class="txt-red">*</span>
						</div>
						<div class="col-12 col-sm-6">
							<input class="form-control" type="text" name="z_password" id="z_password" required>
						</div>
					</div>
					<div class="row mt-2 justify-center">
						<button type="submit" class="btn primary mr-2" name="button" >저장</button>
						<button type="reset" class="btn" name="button">취소</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
	$('.numbersOnly').keyup(function () {
		this.value = this.value.replace(/[^0-9\.]/g, '');
	});
</script>
