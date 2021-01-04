<div class="page-content">


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo base_url(); ?>admin">Admin</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <span>API 리스트</span>
            </li>
        </ul>

    </div>
    <?php if($msg == 'success_added'){ ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>성공적으로 등록되었습니다.</strong>
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
            <strong>성공적으로 삭제되었습니다.</strong>
        </div>
    <?php }?>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-info font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">API 리스트</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                             <a href="<?php echo base_url(); ?>admin/api/add/0" class="btn btn-success btn-sm">
                                 <i class="glyphicon glyphicon-plus"></i> New
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
                         <colgroup>
                              <col width="">
                              <col width="10%">
                              <col width="30%">
                              <col width="40%">
                              <col width="10%">
                              <col width="">
                         </colgroup>
                        <thead>
                        <tr style="text-align: left;">
                             <th>No</th>
                             <th>API 서비스명</th>
                             <th>URL</th>
                             <th>발송 Parameters</th>
                             <th>etc</th>
                             <th></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        <?php $count = 0;
                              foreach ($api as $row){ $count++;?>

                            <tr >
                                <th><?php echo $count; ?></th>
                                <td><span class='bold'><?php echo $row->name; ?></span></td>
                                <td>
                                     <div class="portlet light">
                                          <h5 class="bold">발송</h5>
                                          <?php echo $row->send_url;?>
                                     </div>
                                     <div class="portlet light">
                                          <h5 class="bold">Callback</h5>
                                          <?php echo $row->dlr_url;?>
                                     </div>
                                </td>
                                <td>
                                     <table class="table table-bordered">
                                          <tbody>
                                               <tr>
                                                    <th>Username</th>
                                                    <td><?php echo $row->username;?></td>
                                                    <th>Password</th>
                                                    <td><?php echo $row->password;?></td>
                                               </tr>
                                               <tr>
                                                    <th>Sender</th>
                                                    <td><?php echo $row->sender;?></td>
                                                    <th>Recipient</th>
                                                    <td><?php echo $row->recipient;?></td>
                                               </tr>
                                               <tr>
                                                    <th>Message</th>
                                                    <td colspan="3"><?php echo $row->message;?></td>
                                               </tr>
                                               <tr>
                                                    <th>Type</th>
                                                    <td><?php echo $row->type;?></td>
                                                    <th>Unicode</th>
                                                    <td><?php echo $row->unicode;?></td>
                                               </tr>
                                          </tbody>
                                     </table>
                                </td>
                                <td><?php echo $row->action;?></td>
                                <td>
                                    <a href="<?php echo base_url();?>admin/api/edit/<?php echo $row->id; ?>" class="btn btn-xs blue"><i class="glyphicon glyphicon-edit"></i> </a>
                                    <a href="<?php echo base_url();?>admin/api/delete/<?php echo $row->id; ?>" data-toggle="confirmation" data-original-title=" " data-placement="top" class="btn btn-xs red"><i class="glyphicon glyphicon-trash"></i> </a>
                                </td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
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
