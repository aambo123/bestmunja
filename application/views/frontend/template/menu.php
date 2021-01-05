<header>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<nav>
					<a href="/" target="_self" class="nav_logo">
						1STBULK
					</a>
					<?php 
						if ($this->session->userdata('logged_in')) 
						{
						$account_limit = $this->settings_model->get_account_limit();
						?>
					<?php 
						$link = $this->uri->segment(2, 0); 
					?>
					<ul class="navbar-nav">
						<?php 
							if($this->session->userdata('user_level') == 'Reseller' || $this->session->userdata('user_level') == 'Super admin') 
							{
						?>
						<li class="nav-item "><a href="/admin" class="nav-link" target="_self">관리자</a></li>
						<?php 
							} 
						?>
						<li class="nav-item <?php if ($link == 'smsSend') {echo "active";}?>">
							<a href="<?php echo base_url() ?>users/smsSend" class="nav-link" target="_self">발송</a>
						</li>


						<li class="nav-item <?php if ($link == 'SmsRequests') {echo "active";}?>">
							<a href="<?php echo base_url() ?>users/SmsRequests" class="nav-link" target="_self">결과</a>
						</li>
						<li class="nav-item <?php if ($link == 'mypage') {echo "active";}?>">
							<a href="<?php echo base_url() ?>users/mypage" class="nav-link" target="_self">마이페이지</a>
						</li>
						<li class="nav-item <?php if ($link == 'notice') {echo "active";}?>">
							<a href="<?php echo base_url() ?>users/notice" class="nav-link" target="_self">공지사항</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url() ?>home/logout" class="nav-link" target="_self">로그아웃</a>
						</li>
					</ul>
					<div class="balance_wrapper ml-auto">

						<span class="balance">
                            <?php
                                if($this->session->userdata('user_level') != 'Super admin'){
                                    $send_cnt = number_format($user->msg_quantity / 1, 0, ",", ",").' 건';
                                    $name = $this->session->userdata('user_name');
                                    $member = $this->users_model->get_user_one($this->session->userData('id'));
                                    $price =  $this->settings_model->get_recommendation_one_by_id($member->mb_recommend);
                                    $msg = "{$name} 남은건수 : {$send_cnt} (1건당 {$price->msg_price}원)";
                                     if ($user != null) {
                                         echo  $msg;
                                     }
                                }
								
								?>
						</span>
						<!-- <span class="balance">
							<?php
								if($this->session->userdata('user_level') == 'Super admin'){
									echo "Total Balance: ".$account_limit->msg_limit_count."";
								}
							?>
						</span> -->
						<a href="<?php echo base_url() ?>users/smsAdd" class="btn outline btn-sm primary">충전</a>
					</div>
					<?php } else {  ?>
					<ul class="navbar-nav">
						<li class="nav-item ml-auto">
							<a href="<?php echo base_url() ?>home/login" target="_self" class="nav-link">
								로그인
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url() ?>home/register_form" target="_self" class="nav-link">
								회원가입
							</a>
						</li>
					</ul>
					<?php }  ?>
				</nav>
			</div>
		</div>
	</div>
</header>

<script type="text/javascript">
	$('body').on('click', function (e) {
		var $tgt = $(e.target);
		if (!$tgt.closest(".dropdown").length) {
			$('.dropdown_content').slideUp();
		};
	});
	$('.dropdown_button').on('click', function () {
		$(this).next('.dropdown_content').slideToggle("fast");
	})


	var mobile = window.matchMedia('(max-width: 991px)').matches;


	$('.toggle_menu').on('click', function () {
		$(this).toggleClass('on');
		$('.navbar-nav').toggleClass('show')
	})
	var lastScroll = 0;
	$(window).scroll(function (event) {
		var height = window.innerHeight;
		var top = $(window).scrollTop();
		var perc = (top * 100) / height;
		$('.intro_box').css('transform', 'translateY(' + perc + '%)');
		if (top > lastScroll) {
			$('.navbar-nav').addClass('hide')
		} else if (top < lastScroll) {
			$('.navbar-nav').removeClass('hide')
		}
		lastScroll = top;
	});

</script>
