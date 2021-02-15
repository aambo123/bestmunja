<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8'">
	<title>로그인 | 글로벌문자</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">



	<!-- Best munja custom css -->
	<link rel="stylesheet" href="/assets/css/login.css?v=2.8">
	<link rel="stylesheet" href="/assets/css/login-general.css?v=2.8">
	<link rel="stylesheet" href="/assets/css/blue.css?v=2.8">

	<link rel="stylesheet" href="/assets/css/custom.css?v=2.8">

	<link rel="stylesheet" href="/assets/src/js/font-awesome/css/font-awesome.min.css">

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

<body
	class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed"
	style="background-color: #ffffff;">
	<div class="kt-subheader   kt-grid__item" id="kt_subheader" style="border-bottom: 10px #ddd">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title" style="color: #009bfa; font-size: 21px; font-weight: 700;">

					BEST MUNJA </h3>


			</div>
			<div class="kt-subheader__toolbar">
				<div class="kt-subheader__wrapper" style="font-size: 18px; font-weight: 700;">
					<a href="/home/login" style="padding-right: 20px;">
						로그인

						<!--<i class="flaticon2-calendar-1"></i>-->
					</a>
					<a href="/home/register_form">
						회원가입
						<!--<i class="flaticon2-calendar-1"></i>-->
					</a>
				</div>
			</div>
		</div>
	</div>


	<!-- begin:: Page -->
	<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
		<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v6 kt-login--signin" id="kt_login">
			<div
				class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid__item--center kt-grid kt-grid--ver kt-login__content">
					<div class="kt-login__section">
						<div class="kt-login__block">
							<h3 class="kt-login__title">You don't have to insert the ad rejection.</h3>
						</div>
					</div>
				</div>
				<div class="kt-grid__item  kt-grid__item--order-tablet-and-mobile-2  kt-grid kt-grid--hor kt-login__aside">
					<div class="kt-login__wrapper">
						<div class="kt-login__container">
							<div class="kt-login__body">

								<div class="kt-login__signin">
									<div class="kt-login__head" style="border-bottom: 1px solid #cacaca;">
										<h3 class="kt-login__title" style="font-size: 30px; font-weight: 700;">로그인</h3>
									</div>
									<div class="kt-login__form">
										<form class="" action="<?php echo base_url(); ?>home/login_check"
											onsubmit="return flogin_submit(this);" method="post" name="flogin">
											<?php if($msg == 'error'){ echo "<script type='text/javascript'>alert('아이디 및 비밀번호가 틀리거나 회원이 중지 됬습니다.');</script>";} ?>
											<div class="form-group">
												<input type="text" class="form-control " required name="mb_id" id="login_id" placeholder="아이디"
													value="<?php if(isset($_COOKIE["loginId"])) { echo $_COOKIE["loginId"]; } ?>" size="20"
													maxLength="20">
											</div>

											<div class="form-group">
												<input type="password" class="form-control " required name="mb_password" id="login_pw"
													placeholder="비밀번호"
													value="<?php if(isset($_COOKIE["loginPass"])) { echo $_COOKIE["loginPass"]; } ?>" size="20"
													maxLength="20">
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

										<div class="kt-login__logo padding-top-30">
                         <a class="telegram telegram-static" href="https://t.me/smsmaster">
                              <img src="/assets/images/telegram.png" alt="">
                              <div>
                                   <h3>가입상담</h3>
                                   <p><span>Telegram id:</span> smsmaster</p>
                              </div>
                         </a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="kt-login__account">
							<span class="kt-login__account-msg">
								아직 계정이 없습니까?
							</span>&nbsp;&nbsp;
							<a href="/home/register_form" class="kt-login__account-link">가입하기!</a>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>
	<!-- end:: Page -->


	<!-- begin::Global Config(global config for global JS sciprts) -->

	<!-- end::Global Config -->

	<script>
		var swiper = new Swiper('.swiper-container');

	</script>

	<!-- end::Body -->

	<iframe name="_hjRemoteVarsFrame" title="_hjRemoteVarsFrame" id="_hjRemoteVarsFrame"
		src="https://vars.hotjar.com/box-469cf41adb11dc78be68c1ae7f9457a4.html"
		style="display: none !important; width: 1px !important; height: 1px !important; opacity: 0 !important; pointer-events: none !important;"></iframe>
</body>

</html>
