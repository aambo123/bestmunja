<?php //$notification = $this->action_model->get_notification();
//$count = sizeof($notification);
//function elapsed_time($time){// Nekadar zaman geçmiş
//    date_default_timezone_set("Asia/Ulaanbaatar");
//    $diff = time() - strtotime($time);
//
//    $sec = $diff;
//    $min = floor($diff/60);
//    $hour = floor($diff/(60*60));
//    $hour_min = floor($min - ($hour*60));
//    $day = floor($diff/(60*60*24));
//    $day_hour = floor($hour - ($day*24));
//    $week = floor($diff/(60*60*24*7));
//    $mon = floor($diff/(60*60*24*7*4));
//    $year = floor($diff/(60*60*24*7*4*12));
//
//    //difference calculate to string
//    if($sec < (60*2)){
//        return 'just now';
//    }elseif($min < 60){
//        return ''.$min.' mins';
//    }elseif($hour < 24){
//        return $hour.' hours '.$hour_min.' mins.';
//    }elseif($day < 7){
//        if($day_hour!=0){$day_hour=$day_hour.' hours ';}else{$day_hour='';}
//        return $day.' days '.$day_hour.'';
//    }elseif($week < 4){
//        return $week.' weeks.';
//    }elseif($mon < 12){
//        return $mon.' months.';
//    }else{
//        return $year.' years.';
//    }
//}
//?>
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner ">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="/users/smsSend" style="color: #fff; margin-top: 19px; font-size: 20px;">
				<span class="logo-default"><?php echo $this->config->item("site_name") ?></span>

			</a>
			<div class="menu-toggler sidebar-toggler">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
			data-target=".navbar-collapse"> </a>

		<div class="page-top">
			<audio id="myAudio">
				<source src="<?php echo base_url(); ?>assets/src/img/notif.mp3" type="audio/mpeg">
			</audio>
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">

				<div id="message">

				</div>
				<div id="demo">

				</div>
				<script>
					$('body').click(function () {
						var x = document.getElementById("myAudio");
						x.autoplay = true;
						x.muted = true;
						x.load();
					});

					function hideNotif(el) {
						el.closest($('.notif')).remove();
					}

				</script>

				<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8">
				</script>
				<script>
					//Enable pusher logging - don't include this in production
					Pusher.logToConsole = true;

					var pusher = new Pusher('86886ac93a23bc33e419', {
						cluster: 'ap3',
						forceTLS: true
					});

					var channel = pusher.subscribe('smsallline');
					channel.bind('my-event', function (data) {

						$('<div class="notif" id="notif' + data.id + '">' + data.message + ' </div>').prependTo("#message");
						var x = document.getElementById("myAudio");
						x.autoplay = true;
						x.muted = false;
						x.load();

						var timer;
						timer = setTimeout(function () {
							$('#notif' + data.id + '').hide(500);
						}, 5000);
					});

				</script>

				<ul class="nav navbar-nav pull-right">

					<li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
						<a href="<?php echo base_url(); ?>" class="dropdown-toggle" data-hover="dropdown"
							data-close-others="true">
							<i class="icon-home"></i>

						</a>
						<ul class="dropdown-menu">


						</ul>
					</li>
					<li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
						<a href="#" class="dropdown-toggle" data-hover="dropdown" data-close-others="true">
							Balance :
							<?php
								// Get customers quantity
								$member = $this->users_model->get_user_one($this->session->userData('id'));
								$price =  $this->settings_model->get_recommendation_one_by_id($member->mb_recommend);
								if ($member != null) {
                                    echo number_format($member->msg_quantity / 1, 0, ",", ",").' 건';
                                }
                            ?>

						</a>
					</li>
					<?php 
                        if($this->session->userData('user_level' == 'Super admin')) {
                    ?>
					<li class="dropdown dropdown-user">
						<?php
                        $account_limit = $this->settings_model->get_account_limit();
                        ?>
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
							data-close-others="true">

							<span class="username username-hide-on-mobile"> Total balance:
								<?php echo $account_limit->msg_limit_count; ?> </span>

						</a>

					</li>
					<?php } ?>
					<li class="dropdown dropdown-user">

						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
							data-close-others="true">
							<img alt="" class="img-circle"
								src="<?php echo base_url(); ?>assets/admin/layouts/layout2/img/avatar2.jpg" />
							<span class="username username-hide-on-mobile">
								<?php echo $this->session->userdata('user_name'); ?> </span>
							<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<!--                            <li>-->
							<!--                                <a href="">-->
							<!--                                    <i class="icon-user"></i> My Profile </a>-->
							<!--                            </li>-->

							<li class="divider"> </li>

							<li>
								<a href="<?php echo base_url(); ?>admin_panel/home/logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
									<i class="icon-key"></i> Log Out </a>

								<form id="logout-form" action="<?php echo base_url() ?>home/logout" method="POST"
									style="display: none;">
									@csrf
								</form>
							</li>
						</ul>
					</li>

					<!--                    <li class="dropdown dropdown-extended quick-sidebar-toggler">-->
					<!--                        <span class="sr-only">Toggle Quick Sidebar</span>-->
					<!--                        <i class="icon-logout"></i>-->
					<!--                    </li>-->
					<!-- END QUICK SIDEBAR TOGGLER -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END PAGE TOP -->
	</div>
	<!-- END HEADER INNER -->
</div>
