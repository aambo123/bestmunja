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
												<i class="fa fa-plus"></i>'. $row->title .'</button>
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

	

	<script type="text/javascript">
		$(document).ready(function () {
			var url = window.location.href;
			var urlTarget = url.split("#");

			if (urlTarget.length != 1) {
				$('#' + urlTarget[1]).css('display', 'block');
				$('button[rel="' + urlTarget[1] + '"] i').removeClass("fa fa-plus").addClass("fa fa-minus");
			} 

			// when open 
			// if (urlTarget.length == 1) {
			// 	$(".content").first().css('display', 'block');
			// 	$("i", ".collapsible ").first().removeClass("fa fa-plus").addClass("fa fa-minus");
			// } else {
			// 	$('#' + urlTarget[1]).css('display', 'block');
			// 	$('button[rel="' + urlTarget[1] + '"] i').removeClass("fa fa-plus").addClass("fa fa-minus");
			// }
			
			$(".collapsible").click(function () {
				var target = '#' + $(this).attr('rel');

				$(".collapsible i").removeClass("fa fa-minus").addClass("fa fa-plus");
				if ($(target).css('display') == 'none') {
					$(".content").hide();
					$(target).show();
					$("i", this).removeClass("fa fa-plus").addClass("fa fa-minus");
				} else {
					$(target).hide();
					$("i", this).removeClass("fa fa-minus").addClass("fa fa-plus");
				}
			});
		});

	</script>
