<?php 
if($this->session->userData('id')){
	redirect("/users/smsSend");
}
?>

	<div class="container">
        <div class="row align-center"  style="height: calc(100vh - 60px)">
            <div class="col-md-6 mx-auto">
                <h2 class="login_title">
							회원가입
						</h2>
						<form id="fregisterform" name="fregisterform" action="<?php echo base_url(); ?>home/register_send"
							method="post" enctype="multipart/form-data" autocomplete="off">
							<div class="form-group">
								<input id="user_id" type="text" placeholder="아이디" autocomplete="username" name="mb_id"
									value="<?php if(isset($_POST['mb_id'])){ echo "".$_POST['mb_id'].""; }?>" class="form-control large">
								<span class="validation"></span>
								<span class="error_msg"><?php echo form_error('mb_id') ?></span>
							</div>
							<div class="form-group">
								<input id="user_name" type="text" placeholder="이름" autocomplete="name" name="mb_name"
									value="<?php if(isset($_POST['mb_name'])){ echo "".$_POST['mb_name'].""; }?>"
									class="form-control large">
								<span class="validation"></span>
								<span class="error_msg"><?php echo form_error('mb_name') ?></span>
							</div>
							<div class="form-group">
								<input id="mb_email" type="text" placeholder="이메일" autocomplete="email"
									value="<?php if(isset($_POST['mb_email'])){ echo "".$_POST['mb_email'].""; }?>" name="mb_email"
									class="form-control large">
								<span class="validation"></span>
								<span class="error_msg"><?php echo form_error('mb_email') ?></span>
							</div>
							<div class="form-group">
								<input id="pass" type="password" placeholder="비밀번호" name="mb_password" autocomplete="new-password"
									value="<?php if(isset($_POST['mb_password'])){ echo "".$_POST['mb_password'].""; }?>"
									class="form-control large" aria-autocomplete="list">
								<span class="validation"></span>
								<span class="error_msg"><?php echo form_error('mb_password') ?></span>
							</div>
							<div class="form-group">
								<input id="pass_check" type="password" placeholder="비밀번호 확인" name="mb_password_re"
									autocomplete="new-password"
									value="<?php if(isset($_POST['mb_password_re'])){ echo "".$_POST['mb_password_re'].""; }?>"
									class="form-control large">
								<span class="validation"></span>
								<span class="error_msg"><?php echo form_error('mb_password_re') ?></span>
							</div>
							<div class="form-group">
								<input id="referral" type="text" placeholder="추천코드" name="referral" autocomplete="recommend-code"
									value="<?php if(isset($_POST['referral'])){ echo "".$_POST['referral'].""; }?>"
									class="form-control large " />
								<span class="validation"></span>
								<span class="error_msg"><?php echo form_error('referral') ?></span>
							</div>
							<!-- <div class="form-group">
                         <label class="checkbox">
                              <input type="checkbox" name="term_accept" value="1">
                              <span>
                                   <a href="" class="form_link">개인정보처리방침</a> 동의
                              </span>
                         </label>
                         <span class="validation"></span>
                         <span class="error_msg"><?php echo form_error('term_accept') ?></span>
                    </div> -->
							<button type="submit" class="btn btn-lg primary wide" id="register_btn">회원가입</button>

						</form>
            </div>
        </div>
    </div>

	<script type="text/javascript">
		$(document).ready(function () {
			var url = window.location.href;
			var urlTarget = url.split("#");

			if (urlTarget[1] != null) {
				document.getElementById("referral").value = urlTarget[1];
				document.getElementById('referral').readOnly = true;
			}

			if (urlTarget[1] != null && urlTarget[2] != null) {
				document.getElementById("referral").value = urlTarget[1];
				document.getElementById('referral').readOnly = true;
				document.getElementById("reseller_code").value = urlTarget[2];
				document.getElementById('reseller_code').readOnly = true;
			}
		});

	</script>
	<script src="<?php echo base_url(); ?>assets/js/form.js" charset="utf-8"></script>

