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
							로그인
						</h2>
						<form class="" action="<?php echo base_url(); ?>home/login_check" onsubmit="return flogin_submit(this);"
							method="post" name="flogin">
							<?php if($msg == 'error'){ echo "<script type='text/javascript'>alert('아이디 및 비밀번호가 틀리거나 회원이 중지 됬습니다.');</script>";} ?>
							<div class="form-group">
								<input type="text" class="form-control large" required name="mb_id" id="login_id" placeholder="아이디"
									value="<?php if(isset($_COOKIE["loginId"])) { echo $_COOKIE["loginId"]; } ?>" size="20"
									maxLength="20">
							</div>

							<div class="form-group">
								<input type="password" class="form-control large" required name="mb_password" id="login_pw"
									placeholder="비밀번호" value="<?php if(isset($_COOKIE["loginPass"])) { echo $_COOKIE["loginPass"]; } ?>"
									size="20" maxLength="20">
							</div>

							<div class="form-group">
								<label class="checkbox">
									<input id="login_auto_login" type="checkbox" name="auto_login" value="1"
										<?php if(isset($_COOKIE["loginId"])) { ?> checked="checked" <?php } ?>>
									<span>자동로그인</span>
								</label>
							</div>
							<button type="submit" class="btn btn-lg primary wide" name="button">로그인</button>
						</form>

						<div class="padding-top-30">
							
						</div>
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

		$(function(){
			setBackgroundHeight();
		});

		$(window).on('resize', function(){
			setBackgroundHeight();
		});

		function setBackgroundHeight(){
			if($(window).width() > 991){
				var formHeight = $('.login-form-container').height();

				if($(window).height() < formHeight){
					if( formHeight > $('.mainbg').height() ) {

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
</body>

</html>
