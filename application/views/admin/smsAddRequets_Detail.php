<div class="page-content">


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <span>SMS add request</span>
            </li>
        </ul>

    </div>


    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light form-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-info font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">SMS add request detail</span>
                    </div>

                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <?php $user = $this->users_model->get_user_one($detail->member_id); ?>
                    <form action="<?php base_url() ?>/admin_panel/settings/save" class="form-horizontal form-bordered" method="post">
                        <input type="hidden" name="request_id" value="<?php if($detail != null){ echo $detail->id;} ?>">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-md-12"><h3></h3></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">ID</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="site_name" value="<?php echo $user->mb_id; ?>" readonly>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">이름</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="mb_name" value="<?php echo $user->mb_name; ?>" readonly>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">이메일</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="mb_name" value="<?php echo $user->mb_email; ?>" readonly>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">휴대폰번호</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="mb_phone" value="<?php echo $user->mb_tel; ?> " readonly>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">전화번호</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="mb_phone" value="<?php echo $user->mb_hp; ?> " readonly>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Total price</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="" value="<?php echo $detail->total_price; ?> " readonly>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">MSG quantity</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="" value="<?php echo $detail->num_send; ?> " readonly>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Date</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="" value="<?php echo $detail->created_date; ?> " readonly>

                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class=" col-md-9">
                                    <a href="<?php echo base_url(); ?>admin/smsAddRequets" class="btn dark">
                                        <i class="icon-action-undo"></i> Go back
                                    </a>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
</div>