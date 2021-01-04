<div class="page-content">
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo base_url(); ?>admin">Admin</a>
				<i class="fa fa-angle-right"></i>
			</li>

			<li>
				<span>발송 단가</span>
			</li>
		</ul>
	</div>
	<?php if($msg == 'success_added'){ ?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
			<strong>Successfully</strong> added.
		</div>
	<?php }?>
	<?php if($msg == 'success_updated'){ ?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
			<strong>성공적으로 업데이트되었습니다.</strong>
		</div>
	<?php }?>
	<?php if($msg == 'success_deleted'){ ?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
			<strong>Successfully</strong> deleted.
		</div>
	<?php }?>
	<?php if($msg == 'price_more_than_yours'){ ?>
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
			<strong>추천 가격은 귀하의 가격보다 높아야합니다.</strong>
		</div>
	<?php }?>

	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN PORTLET-->
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-info font-green"></i>
						<span class="caption-subject font-green sbold uppercase">발송 단가</span>
					</div>
					<div class="actions">
						<div class="btn-group btn-group-devided">
						<a href="<?php echo base_url(); ?>admin/recommendationAdd" class="btn btn-success btn-sm">
							<i class="glyphicon glyphicon-plus"></i> New
						</a>
						<a href="<?php echo base_url(); ?>admin/downloadRecommendation" class="btn btn-primary btn-sm">
							<i class="fa fa-file-excel-o"></i> 엑셀 다운로드
						</a>
						</div>
					</div>
				</div>
				<div class="portlet-body " id="table_id">
					<style>
						.visible{
							display: flex !important;
							display: -ms-flex !important;
						}
					</style>
					<div style="position: fixed; text-align: center; z-index: 99; height: 100vh; width: 100%; top: 0; left:0; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center; display: none;" id="loader" class="hide" >
						<img src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="50" style="z-index: 999;">
						<div style="font-size: 40px; color: #fff;">데이터 처리 중 입니다</div>
					</div>

				
				<div class="table-scrollable table-scrollable-borderless">
					<table class="table table-striped table-light" >
						<thead>
						<tr style="text-align: left;">
							<th width="5%">번호</th>
							<th width="">가입 코드</th>
							<th width="20%">메시지 당 가격</th>
							<th width="">API 계정</th>

							<?php if($this->session->userData('user_level') == 'Super admin') {?>
							<?php } ?>
							<th width="15%">수정 / 삭제</th>
						</tr>
						</thead>
						<tbody class="bg-white">
						<?php
						$count = 0;
						foreach ($rec_code as $row){ $count++;

							$resellerDisabled = ($row->created_id) ? $this->users_model->get_user('mb_no', $row->created_id) : null;
							$disabled = '';
							$disabledStyle = '';

							// Super admin
							if ($this->session->userdata('user_level') == 'Super admin' && $resellerDisabled){
								if ($row->created_id == $resellerDisabled) {
									$disabled = '';
									$disabledStyle = '';
								} else {
									$disabled = 'disabled';
									$disabledStyle = 'pointer-events: none;';
								}
							}
							?>
							<tr >
								<td><span ><?php echo $count; ?></span></td>
								<td><span class='bold ' ><?php echo $row->rec_code; ?></span></td>
								<td><span class='bold ' ><?php echo $row->msg_price; ?></span></td>
								<td><span class='bold ' ><?php echo $row->username; ?></span></td>
								<!-- <?php if($this->session->userData('user_level') == 'Super admin') {?>
								<td><span class='bold ' ><?php echo $resellerDisabled ? $resellerDisabled->mb_id : ''; ?></span></td>
								<?php } ?> -->
								<td>
									<a href="<?php echo base_url();?>admin/recommendationShow/<?php echo $row->rec_id; ?>" class="btn btn-xs green"><i class="glyphicon glyphicon-eye-open"></i> </a>
									<a href="<?php echo base_url();?>admin/recommendationEdit/<?php echo $row->rec_id; ?>" class="btn btn-xs blue" style="<?php echo $disabledStyle ?>" <?php echo $disabled ?>><i class="glyphicon glyphicon-edit"></i> </a>
									<a href="<?php echo base_url();?>admin/recommendationDelete/<?php echo $row->rec_id; ?>" data-toggle="confirmation" data-original-title=" " data-placement="top" class="btn btn-xs red" style="<?php echo $disabledStyle ?>" <?php echo $disabled ?>><i class="glyphicon glyphicon-trash"></i> </a>
								</td>
							</tr>
						<?php }?>
						</tbody>
					</table>

				</div>
					<script>
						function myFunction(val) {
							$('#loader').addClass('visible');
							var data = new FormData();
							data.append("id", val);
							data.append("user", $('#user'+val+'').val());
							data.append("pass", $('#pass'+val+'').val());
							//alert(user);
							$.ajax({
								url: '/admin/getcredits',
								type: "POST",
								data: data,
								contentType: false,
								processData: false,
								cache: false,
								async: true,
								success: function(data){
									$('#loader').removeClass('visible');
									console.log(data);
									if(data != 0) {
										$('#too' + val + '').html(data);
									}
									// if(data == 8){
									//     alert('비밀번호 및 아이디가 일치하지 않습니다.');
									//     location.reload();
									// }
									//alert(data);
								}
							});

						}
					</script>

			</div>
			</div>
		<!-- END PORTLET-->
		</div>
	</div>

<script>
	$(".alert").fadeTo(2000, 500).slideUp(500, function(){
		$(".alert").slideUp(500);

	});

</script>
</div>

