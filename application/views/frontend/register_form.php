<?php 
if($this->session->userData('id')){
	redirect("/users/smsSend");
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8'">
	<title>로그인 | 글로벌문자</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">


	<link rel="stylesheet" href="/assets/css/style.css?v=3.0">

	<!-- Best munja custom css -->
	<link rel="stylesheet" href="/assets/css/custom.css?v=3.0">

	<link rel="stylesheet" href="/assets/src/js/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/assets/css/swiper.min.css">
	<script src="/assets/src/js/jquery-1.8.3.min.js"></script>
	<script src="/assets/src/js/jquery.menu.js"></script>
	<script src="/assets/src/js/common.js"></script>
	<script src="/assets/src/js/wrest.js"></script>
	<script src="/assets/src/js/placeholders.min.js"></script>
	<script src="/assets/js/feather.js"></script>
	<script src="/assets/js/swiper.min.js"></script>

	<?php
    $dat['general_info'] = $this->settings_model->get_meta();
    $this->load->view('frontend/template/meta',$dat); ?>
</head>

<body class="bgbody">
	<?php $this->load->view('frontend/template/menu') ?>
	<div class="mainbg"></div>
	<div class="lfw"></div>

	<div class="container">
		<div class="row h-100">
			<div class="col-md-7 login-left">
				<!-- <div class="intro_wrapper">
					<div class="intro_box"> -->
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<h1 class="swiper-slide">
							광고 문구 <br class="hide1"> 무료수신거부 <br class="hide1"> 삽입을 <br class="hide1"> 하지않으셔도 <br class="hide1"> 됩니다.
						</h1>
						<h1 class="swiper-slide">
							본인인증 필요 <br class="hide1"> 없이 회원가입<br class="hide1"> 하시면 됩니다.
						</h1>
						<h1 class="swiper-slide">
							발신번호 마음대로<br class="hide1"> 변경 가능.
						</h1>
						<h1 class="swiper-slide">
							도메인 주소 <br class="hide1"> 발송문구 <br class="hide1"> 제한이 없습니다.
						</h1>
					</div>
					<!-- </div>
					</div> -->
				</div>
			</div>
			<div class="col-md-5 login-right">
				<div class="login-form-container">
					<div class="" id='content'>
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

					
						<!-- /Skype section -->
					</div>
				</div>

			</div>
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
		});

		$(function () {
			setBackgroundHeight();
		});

		$(window).on('resize', function () {
			setBackgroundHeight();
		});

		function setBackgroundHeight() {
			if ($(window).width() > 991) {
				var formHeight = $('.login-form-container').height();

				if ($(window).height() < formHeight) {
					if (formHeight > $('.mainbg').height()) {

						$('.mainbg').height(formHeight + 80);
						$('.login-right').height(formHeight + 80);
						$('.login-left').height(formHeight + 80);
						$('.lfw').height(formHeight + 80);

					}
				} else {
					$('.mainbg').height($(window).height());
					$('.login-right').height($(window).height());
					$('.login-left').height($(window).height());
					$('.lfw').height($(window).height());
				}

				// console.log(
				// 	"mainbg: " + $('.mainbg').height() + " | " + 
				// 	"lfw: " + $('.lfw').height() + " | " + 
				// 	"login-form-container: " + formHeight + " | " + 
				// 	"login-right: " + $('.login-right').height() 
				// );
			} else {
				$('.mainbg').height(550);
				$('.login-left').height(550);
			}

		}

	</script>

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
</body>

</html>
