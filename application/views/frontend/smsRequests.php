<script src="<?php echo base_url(); ?>assets/src/js/SmsRequests.js"></script>
<script src="<?php echo base_url(); ?>assets/src/js/SmsRequestView.js"></script>
<style>
    .overflow-ellipsis{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 600px;
        position: relative;
        display: block;
        width: 100%;
    }
    .tool{
        position: relative;
    }
    .tooltip {
        visibility: hidden;
        /* width: 120px; */
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        top: 100%;
    }

    .tool:hover .tooltip {
        visibility: visible;
    }
</style>

<div class="page">

	<div class="container">
		<div class="row result_top">
			<div class="col-sm-3 mb-2">
				<div class="input-group">
					<span class="prepend">
						<i data-feather="search" width="16" height="16"></i>
					</span>
					<input type="search" class="form-control round" id="searcResult" name="" value="" placeholder="검색어 입력하세요">
				</div>
			</div>
			<div class="col-sm-9">
				<div class="flex align-center">
					<p class="ml-auto">총 <span class="txt-primary"><?php echo $total ?></span> 건의 내용이 검색되었습니다</p>
					<div class="input-group">
						<select class="select" name="per_pg" id="per_pg">
							<option value="10" <?php if ($per_pg == 10): ?> selected <?php endif; ?>>10</option>
							<option value="20" <?php if ($per_pg == 20): ?> selected <?php endif; ?>>20</option>
						</select>
						<div class="append" style="right: 8px">
							<i data-feather="chevron-down" width="14"></i>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div class="row result_bot">
			<div class="col-sm-12">


				<div class="card">
					<div class="card_header">
						<h4 class="m-0">발송 리스트</h4>
					</div>
					<table class="table">
                        <colgroup>
                           <col width="5%">     
                           <col width="">     
                           <col width="10%">     
                           <col width="10%">     
                           <col width="10%">     
                           <col width="10%">     
                        </colgroup>
						<thead>
							<tr>
								<th><label class="checkbox">
										<input type="checkbox" id="checkAll">
										<span></span>
									</label></th>
								<th>내용</th>
								<th>발송시간</th>
								<th>발신번호</th>
								<th>상태</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($messages as $msg){
								//$success_msgs = $this->users_model->get_success_msgs($msg->id);
								$success_msgs = null;
								$pending_msgs = null;
								$error_msgs = null;
							?>
							<tr data-link="<?php echo base_url(); ?>users/SmsRequestView/<?php echo $msg->id; ?>"
								data-id="<?php echo $msg->id; ?>">
								<td>
									<label class="checkbox">
										<input type="checkbox" class="delete" name="" value="<?php echo $msg->id; ?>">
										<span></span>
									</label>
								</td>

								<td name="detail" class="bold tool" data-send-id="<?php echo $msg->id ?>">
									<a class="overflow-ellipsis">
                                        <?php
                                            $out = mb_strlen($msg->message) > 50 ? mb_substr($msg->message,0,50)."..." : $msg->message;
											echo $msg->message;
										?>
                                    </a>
                                    <span class="tooltip">
                                    <?php echo $msg->message;?>
                                    </span>
								</td>
								<td class="text-muted">
									<small><?php echo date('d/m/Y', strtotime($msg->created_date)); ?></small>
								</td>
								<td class="bold">
									<?php echo $msg->sender ?>
								</td>
								<td><?php echo $msg->split_count * $msg->delivered_count; ?></td>
								<td class="text-right details">
									<?php
										$datetime1 = date_create($msg->created_date);
										$datetime2 = date_create(date("Y-m-d"));
										$interval = date_diff($datetime1, $datetime2);
										if ($interval->format('%a') < 7 ) {
									?>
									<input class="send_request" type="hidden" name="" value="<?php echo $msg->id ?>">
									<?php }; ?>
									<div class="badge-wrapper">
                                    <span class="badge total primary circle" data-hover="text" data-content="발송">
                                                            <?php echo $msg->quantity;?>
                                                       </span>
                                                       <span class="badge success circle" data-hover="text" data-content="성공">
                                                            <?php echo $msg->delivered_count;?>
                                                       </span>
                                                       <span class="badge danger circle" data-hover="text" data-content="실패">
                                                            <?php echo $msg->error_count;?>
                                                       </span>
                                    </div>
								</td>

							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="table_action">
					<button type="button" id="delete-checked" class="btn primary" name="button">선택된 결과 삭제</button>
					<!-- <button type="button" id="delete-all" class="btn primary outline" name="button">전체 결과 삭제</button> -->
					<?php echo $pagination; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="test"></div>
<script type="text/javascript">
	// $(window).on('load', function () {
	// 	requestResult();
	// 	setInterval(function () {
	// 		count++;
	// 		if (!stop) {
	// 			requestResult()
	// 		}
	// 	}, 5000);
	// });
	var count = 0;
	var stop = false;

	function requestResult() {

          var $data = [];
          $el = $('.send_request');
          var ajaxCounter = 0;
          for (var i = 0; i < $el.length;i++) {
               $($el[i]).next('.badge-wrapper').addClass('loading');
               if ($el.length>0) {
                    $.ajax({
                         url: '/users/get_detail_old',
                         type: "POST",
                         async: true,
                         cache: false,
                         data: {id: $($el[i]).val(),},
                         beforeSend: function(){
                              console.time('time'+i);
                         },
                         success: function(data){
                              //$('.lottie_wrapper').hide()
                              var result = JSON.parse(data);
                              var id;
                              for (var j = 0; j < result.length; j++) {
                                   id = parseInt(result[j].id);
                                   $('tr[data-id='+id+']').find('.success').text(result[j].delivrd);
                                   $('tr[data-id='+id+']').find('.info').text(result[j].pending);
                                   $('tr[data-id='+id+']').find('.warning').text(result[j].error);
                                   $('tr[data-id='+id+']').find('.danger').text(result[j].undeliv);
                              };
                              setTimeout(function () {
                                   $('tr[data-id='+id+']').find('.badge-wrapper').removeClass('loading');
                              }, 1000);
                              ajaxCounter++;
                              if (ajaxCounter==$el.length) {
                                   setTimeout(function () {
                                        requestResult();
                                   }, 5000);
                              }

                         }
                    });
               };
          };


     };

</script>
