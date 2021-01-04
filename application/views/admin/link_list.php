<!-- Main content -->
<div class="page-content">

	<!-- Bar -->
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo base_url(); ?>admin">Admin</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<span>등록 링크</span>
			</li>
		</ul>
	</div>
	<!-- /Bar -->

	<!-- Message -->
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
	<!-- /Message -->

	<!-- Row -->
	<div class="row">
		<!-- Col 12 -->
		<div class="col-md-12">
			<!-- BEGIN PORTLET-->
			<div class="portlet light ">

				<!-- Portlet title -->
				<div class="portlet-title">

					<!-- Caption -->
					<div class="caption">
						<i class="icon-info font-green"></i>
						<span class="caption-subject font-green sbold uppercase">등록 링크</span>
					</div>
					<!-- /Caption -->

					<!-- Action -->
					<div class="actions">
						<div class="btn-group btn-group-devided">
							<a href="<?php echo base_url(); ?>admin/linkAdd" class="btn btn-success btn-sm">
								<i class="glyphicon glyphicon-plus"></i> New
							</a>
						</div>
					</div>
					<!-- /Action -->
				</div>
				<!-- /Portlet title -->

				<!-- Portlet body -->
				<div class="portlet-body " id="table_id">
					<style>
						.visible {
							display: flex !important;
							display: -ms-flex !important;
						}

					</style>
					<div
						style="position: fixed; text-align: center; z-index: 99; height: 100vh; width: 100%; top: 0; left:0; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center; display: none;"
						id="loader" class="hide">

						<img src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="50" style="z-index: 999;">
						<div style="font-size: 40px; color: #fff;">데이터 처리 중 입니다</div>
					</div>

					<!-- Table scrollable -->
					<div class="table-scrollable table-scrollable-borderless">
						<!-- Table -->
						<table class="table table-striped table-light">
							<!-- Thead -->
							<thead>
								<tr style="text-align: left;">
									<th width="5%">번호</th>
									<th width="">링크</th>
									<th width="20%">생성 된 사용자 이름</th>

									<th width="15%">수정 / 삭제</th>
								</tr>
							</thead>
							<!-- /Thead -->
							<!-- Tbody -->
							<tbody class="bg-white">
								<?php
									$count = 0;
									foreach ($link as $row){ $count++;
								?>
								<tr>
									<th><span><?php echo $count; ?></span></th>
									<td><span class='bold '><?php echo $row->link; ?></span></td>
									<td><span class='bold '><?php echo $row->created_id; ?></span></td>
									<td>
										<a href="<?php echo base_url();?>admin/linkEdit/<?php echo $row->id; ?>"
											class="btn btn-xs blue"><i class="glyphicon glyphicon-edit"></i> </a>
										<a href="<?php echo base_url();?>admin/linkDelete/<?php echo $row->id; ?>"
											data-toggle="confirmation" data-original-title=" " data-placement="top" class="btn btn-xs red"><i
												class="glyphicon glyphicon-trash"></i> </a>
									</td>
								</tr>
								<?php }?>
							</tbody>
							<!-- /Tbody -->
						</table>
						<!-- /Table -->
					</div>
					<!-- /Table scrollable -->

				</div>
				<!-- /Portlet body -->

			</div>
			<!-- END PORTLET-->
		</div>
		<!-- /Col 12 -->
	</div>
	<!-- /Row -->
	
	<!-- Custom script -->
	<script>
		$(".alert").fadeTo(2000, 500).slideUp(500, function () {
			$(".alert").slideUp(500);
		});
	</script>
	<!-- /Custom script -->
</div>
<!-- /Main content -->