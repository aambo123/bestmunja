<div class="page-content">


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo base_url(); ?>admin">Admin</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <span>추천 코드 쇼</span>
            </li>
        </ul>

    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-info font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">추천 코드 쇼</span>
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body form ">
                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">

                                <label class="my-2" for="id">추천 코드</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">
																<span><?php echo $recommendation->rec_code; ?></span>
                            </div>
                            <div class="col-12 col-sm-3 flex align-center">

                            </div>
                        </div>
                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">

                                <label class="my-2" for="id">메시지 당 가격</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">
															<span><?php echo $recommendation->msg_price; ?></span>
                            </div>
                        </div>

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
