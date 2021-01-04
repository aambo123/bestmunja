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
				<span>추천 코드</span>
			</li>
		</ul>
	</div>
  <!-- /Page bar -->

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
						<span class="caption-subject font-green sbold uppercase">추천 코드</span>
					</div>
        </div>
        <!-- /Portlet title -->

        <!-- Portlet body -->
				<div class="portlet-body form">
					<!-- Form -->
          <form class="" action="<?php echo base_url(); ?>admin/linkUpdate" method="post">

            <input type="hidden" name="id" value="<?php echo $link->id; ?>">
            <!-- Recommendation -->
            <div class="form-group row">
							<div class="col-12 col-sm-3 text-right">
								<label class="my-2" for="mb_recommend">추천 코드</label>
								<span class="font-red-mint bold">*</span>
							</div>
							<div class="col-12 col-sm-6">
								<select class="form-control" name="mb_recommend" id="mb_recommend">
									<?php foreach ($rec_code as $rec){ ?>
									<option value="<?php echo $rec->rec_code; ?>"
										<?php if($rec->rec_code == $link->recommend){ echo "selected";} ?>>
										<?php echo $rec->rec_code.' ('.$rec->msg_price.'원)'; ?></option>
									<?php }?>
								</select>
							</div>
            </div>
            <!-- /Recommendation -->
            
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
          <!-- /Form -->
        </div>
        <!-- /Portlet body -->
			</div>
			<!-- END PORTLET-->
    </div>
    <!-- /Col 12 -->
	</div>
  <!-- /Row -->
  <!-- Script -->
	<script>
		$(".alert").fadeTo(2000, 500).slideUp(500, function () {
			$(".alert").slideUp(500);
		});
	</script>
  <!-- /Script -->
</div>
<!-- /Main content -->