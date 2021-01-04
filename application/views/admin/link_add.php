<!-- Main content -->
<div class="page-content">

	<!-- Page bar -->
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo base_url(); ?>admin">Admin</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<span>등록 링크 작성</span>
			</li>
		</ul>
	</div>
	<!-- Page bar -->

	<!-- Row -->
	<div class="row">
		<!-- Col 12 -->
		<div class="col-md-12">
			<!-- BEGIN PORTLET-->
			<div class="portlet light ">
				<!-- Portlet title -->
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-info font-green"></i>
						<span class="caption-subject font-green sbold uppercase">등록 링크 작성</span>
					</div>
				</div>
				<!-- /Portlet title -->

				<!-- Body -->
				<div class="portlet-body form ">
          <form class="" action="<?php echo base_url(); ?>admin/linkSave" method="post">

            <!-- Recommendation for user -->
						<div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2" for="mb_recommend">추천</label>
							</div>
							<div class="col-12 col-sm-6">
								<select class="form-control" name="mb_recommend">
									<option value="">Choose recommendation</option>
									<?php foreach ($rec_code as $rec){ ?>
									<option value="<?php echo $rec->rec_code; ?>" >
										<?php echo $rec->rec_code.' ('.$rec->msg_price.'원)'; ?></option>
									<?php }?>
								</select>
								<span class="error_user_add"><?php echo form_error('mb_recommend') ?></span>
							</div>
						</div>
						<!-- /Recommendation for user -->

            <!-- Button group -->
						<div class="form-group row">
							<div class="col-12 col-sm-3">
							</div>
							<div class="col-12 col-sm-6 text-right">
								<button type="submit" class="btn btn-success mr-2" id="submit" name="button">저장</button>
								<a href="/admin/link" class="btn dark" name="button">취소</a>
							</div>
            </div>
            <!-- /Button group -->
					</form>
				</div>
				<!-- /Body -->
			</div>
			<!-- END PORTLET-->
		</div>
		<!-- /Col 12 -->
	</div>
	<!-- /Row -->

</div>
<!-- /Main content -->

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
	integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<!-- /Script -->
