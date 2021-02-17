<header>
	<div class="container">
		<nav>
			<a href="/" target="_self" class="nav_logo">
				WOLRD BULK
			</a>
			<?php if ($this->session->userdata('logged_in')){ ?>
				<ul class="navbar-nav">
					<li data-href="smsSend" class="nav-item">
						<a href="<?php echo base_url() ?>users/smsSend" class="nav-link" target="_self">발송</a>
					</li>
					<li data-href="SmsRequests" class="nav-item">
						<a href="<?php echo base_url() ?>users/SmsRequests" class="nav-link" target="_self">결과</a>
					</li>
					<li data-href="smsAdd" class="nav-item">
						<a href="<?php echo base_url() ?>users/smsAdd" class="nav-link" target="_self">충전</a>
					</li>
					<li data-href="notice" class="nav-item">
						<a href="<?php echo base_url() ?>users/notice" class="nav-link" target="_self">공지사항</a>
                    </li>
				</ul>
				<div class="login_wrap">
					<?php if($this->session->userdata('user_level') == 'Reseller' || $this->session->userdata('user_level') == 'Super admin'){?>
						<a href="/admin" class="admin" target="_self">
							<img src="/assets/images/gear.png" alt="">	
						관리자</a>
					<?php }?>
						<a href="<?php echo base_url() ?>users/mypage" class="btn btn-sm outline" target="_self">마이페이지</a>
						<a href="<?php echo base_url() ?>home/logout" class="btn btn-sm" target="_self">로그아웃</a>
				</div>
            <?php }else{?>
				<div class="login_wrap">
					<a href="<?php echo base_url() ?>home/login" target="_self" class="btn btn-sm outline">로그인</a>
					<a href="<?php echo base_url() ?>home/register_form" target="_self" class="btn btn-sm">회원가입</a>
				</div>
			<?php }?>
			<button class="menu_button">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</nav>
	</div>
	<?php if ($this->session->userdata('logged_in')){
		$account_limit = $this->settings_model->get_account_limit();
	?>
		<div class="balance_wrapper">
			<div class="container">
				
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
				
			</div>
		</div>
	<?php }?>
	
	<div class="mobile_wrap">
		<div class="mobile_menu">
	<?php if ($this->session->userdata('logged_in')){ ?>
		<div class="balance_wrap">
			<p class="balance">
			Balance :
			<span>
			<?php
				if ($user != null) { echo $user->msg_quantity;}
				
				$member = $this->users_model->get_user_one($this->session->userData('id'));
				$price =  $this->settings_model->get_recommendation_one_by_code($member->mb_recommend);

				if($price != null){
					echo " / ". floor($user->msg_quantity / $price->msg_price);
				}
				?>
			</span>
			</p>
			<p class="balance">
			<?php
				if($this->session->userdata('user_level') == 'Super admin'){
					echo "Total Balance: <span>".$account_limit->msg_limit_count."</span>";
				}
			?>
			</p>
		</div>
		<ul>
			<li data-href="smsSend" class="nav-item">
				<a href="<?php echo base_url() ?>users/smsSend" class="nav-link" target="_self">발송</a>
			</li>
			<li data-href="SmsRequests" class="nav-item">
				<a href="<?php echo base_url() ?>users/SmsRequests" class="nav-link" target="_self">결과</a>
			</li>
			<li data-href="notice" class="nav-item">
				<a href="<?php echo base_url() ?>users/notice" class="nav-link" target="_self">공지사항</a>
			</li>
		</ul>
		<div class="login_wrap">
			<?php if($this->session->userdata('user_level') == 'Reseller' || $this->session->userdata('user_level') == 'Super admin'){?>
				<a href="/admin" class="admin" target="_self">
					<img src="/assets/images/icon_gear.png" alt="">	
				관리자</a>
			<?php }?>
				<a href="<?php echo base_url() ?>users/mypage" class="btn btn-sm outline" target="_self">마이페이지</a>
				<a href="<?php echo base_url() ?>home/logout" class="btn btn-sm" target="_self">로그아웃</a>
		</div>
	<?php } else{?>
		<div class="login_wrap">
			<a href="<?php echo base_url() ?>home/login" target="_self" class="btn btn-sm outline">로그인</a>
			<a href="<?php echo base_url() ?>home/register_form" target="_self" class="btn btn-sm">회원가입</a>
		</div>
	<?php }?>
		</div>
	</div>
</header>

<script type="text/javascript">

	$(function () {
		var path = window.location.pathname;
		var seg = path.substring(path.lastIndexOf("/")+1)
		$('.nav-item').each(function (index, element) {
			$(element).data('href') == seg ? $(element).addClass('active'):$(element).removeClass('active');
		});
	});
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

	$('.menu_button').click(function(){
		$(this).toggleClass('open');
		$('.mobile_wrap').toggleClass('open');
	})


</script>
