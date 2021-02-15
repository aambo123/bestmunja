<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8'">
	<title>로그인 | 글로벌문자</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/assets/css/blue.css?v=2.2">

	<!-- Best munja custom css -->
	<link rel="stylesheet" href="/assets/css/custom.css?v=2.2">


	<link rel="stylesheet" href="/assets/src/js/font-awesome/css/font-awesome.min.css">

	<script src="https://kit.fontawesome.com/a076d05399.js"></script>

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

<body>
	<?php $this->session->userData('id') ? null : $this->load->view('frontend/template/menu') ?>

	<div class="container page">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-sm-12">
						
						<div class="card">
							<div class="card_header">
								<h3 class="my-0 notice_card_header">공지사항</h3>
							</div>
							<div class="card_body">
								<?php
									if (!empty($notices)){
										foreach ($notices as $i => $row){
											echo '
												<button class="collapsible " rel="collap'.$row->id.'">
												<i class="fas fa-plus"></i>'. $row->title .'</button>
												<div class="content" id="collap'.$row->id.'">
													<p>'. $row->content .'</p>
												</div>
											';
										}
									} else {
										echo '<p class="no-notice" style="padding-top: 60px; padding-bottom: 80px; text-align:center; color: #cacaca">공지 사항 없음.</p>';
									}
									
									?>
							</div>
						</div>

						<div class="table_action">
							<?php echo $pagination; ?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<?php $this->session->userData('id') ? null : $this->load->view('frontend/template/footer'); ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function () {
			var url = window.location.href;
			var urlTarget = url.split("#");

			if (urlTarget.length != 1) {
				$('#' + urlTarget[1]).css('display', 'block');
				$('button[rel="' + urlTarget[1] + '"] i').removeClass("fas fa-plus").addClass("fas fa-minus");
			} 

			// when open 
			// if (urlTarget.length == 1) {
			// 	$(".content").first().css('display', 'block');
			// 	$("i", ".collapsible ").first().removeClass("fas fa-plus").addClass("fas fa-minus");
			// } else {
			// 	$('#' + urlTarget[1]).css('display', 'block');
			// 	$('button[rel="' + urlTarget[1] + '"] i').removeClass("fas fa-plus").addClass("fas fa-minus");
			// }
			
			$(".collapsible").click(function () {
				var target = '#' + $(this).attr('rel');

				$(".collapsible i").removeClass("fas fa-minus").addClass("fas fa-plus");
				if ($(target).css('display') == 'none') {
					$(".content").hide();
					$(target).show();
					$("i", this).removeClass("fas fa-plus").addClass("fas fa-minus");
				} else {
					$(target).hide();
					$("i", this).removeClass("fas fa-minus").addClass("fas fa-plus");
				}
			});
		});

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
</body>

</html>
