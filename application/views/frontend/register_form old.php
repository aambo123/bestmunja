<div class="main_wrapper with_image">
	<div class="container h-100">
		<div class="row h-100">
			<div class="col-sm-7">
				<div class="intro_wrapper">
					<div class="intro_box">
						<div class="swiper-container">
							<div class="swiper-wrapper">
								<h1 class="swiper-slide">
									광고 문구 무료수신거부 삽입을 하지않으셔도 됩니다.
								</h1>
								<h1 class="swiper-slide">
									본인인증 필요 없이 회원가입 하시면 됩니다.
								</h1>
								<h1 class="swiper-slide">
									발신번호 마음대로 변경 가능.
								</h1>
								<h1 class="swiper-slide">
									도메인 주소 발송문구 제한이 없습니다.
								</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="left_wrapper" id="mb_login">

		<div class="login_box">
			<h2 class="login_title">
				회원가입
			</h2>
			<form id="fregisterform" name="fregisterform" action="<?php echo base_url(); ?>home/register_send" method="post"
				enctype="multipart/form-data" autocomplete="off">
				<div class="form-group">
					<input id="user_id" type="text" placeholder="아이디" autocomplete="username" name="mb_id"
						value="<?php if(isset($_POST['mb_id'])){ echo "".$_POST['mb_id'].""; }?>" class="form-control large">
					<span class="validation"></span>
					<span class="error_msg"><?php echo form_error('mb_id') ?></span>
				</div>
				<div class="form-group">
					<input id="user_name" type="text" placeholder="이름" autocomplete="name" name="mb_name"
						value="<?php if(isset($_POST['mb_name'])){ echo "".$_POST['mb_name'].""; }?>" class="form-control large">
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
					<input id="pass_check" type="password" placeholder="비밀번호 확인" name="mb_password_re" autocomplete="new-password"
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
				<div class="form-group">
					<input id="reseller_code" type="text" placeholder="리셀러 코드" name="reseller_code" autocomplete="reseller_code"
						value="<?php if(isset($_POST['reseller_code'])){ echo "".$_POST['reseller_code'].""; }?>"
						class="form-control large " />
					<span class="validation"></span>
					<span class="error_msg"><?php echo form_error('reseller_code') ?></span>
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
			<!-- Skype section -->
			<!-- <div class="skype" style="margin-top: 60px;">
				<a class="telegram telegram-static-main" href="https://t.me/smsmaster">
				<img src="/assets/images/telegram.png" alt="">
				<div>
				<h3>가입상담</h3>
				<p><span>Telegram id:</span> smsmaster</p>
				</div>
				</a>
			</div> -->
			<div class="padding-top-30">
				<a class="telegram telegram-static" href="https://t.me/smsmaster">
					<img src="/assets/images/telegram.png" alt="">
					<div>
						<h3>가입상담</h3>
						<p><span>Telegram id:</span> smsmaster</p>
					</div>
				</a>
			</div>
			<!-- /Skype section -->
	</div>
</div>
<script type="text/javascript">
	var swiper = new Swiper('.swiper-container', {
		autoplay: {
			delay: 5000,
		},
		effect: 'fade',
		fadeEffect: {
			crossFade: true
		},
		loop: true,
	})

</script>
<script type="text/javascript">
	$(document).ready(function () {
		var url = window.location.href;
		var urlTarget = url.split("#");

		if(urlTarget[1] != null) {
			document.getElementById("referral").value = urlTarget[1];
			document.getElementById('referral').readOnly = true;
		}
		
		if(urlTarget[1] != null && urlTarget[2] != null) {
			document.getElementById("referral").value = urlTarget[1];
			document.getElementById('referral').readOnly = true;
			document.getElementById("reseller_code").value = urlTarget[2];
			document.getElementById('reseller_code').readOnly = true;
		}
	});
</script>
<script src="<?php echo base_url(); ?>assets/js/form.js" charset="utf-8"></script>
