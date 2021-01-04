<div class="page-content">


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo base_url(); ?>admin">Admin</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <span>발신번호</span>
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
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-info font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">발신번호</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                        <a data-toggle="modal" href="#basic" class="btn btn-success btn-sm">
                            <i class="glyphicon glyphicon-plus"></i> New
                        </a>

                        </div>
                    </div>
                    <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content form">
                                <form action="<?php echo base_url(); ?>admin/sender_save" method="post" class="">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">발신번호</h4>
                                </div>
                                <div class="modal-body">

                                        <input type="text" name="sender_number" class="form-control" required>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn green">Save</button>
                                </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
                <div class="portlet-body " id="table_id">

                <div class="table-scrollable table-scrollable-borderless">
                    <table class="table table-striped table-light" >
                        <thead>
                        <tr style="text-align: left;">
                            <th width="5%">번호</th>
                            <th width="30%">발신번호</th>
                            <th width=""></th>

                            <th width="15%">수정 / 삭제</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        <?php
                        $count = 0;
                        foreach ($sender as $row){ $count++;

                            ?>
                            <tr >
                                <th><span ><?php echo $count; ?></span></th>
                                <td><span class='bold ' ><?php echo $row->sender_number; ?></span></td>

                                <td>

                                </td>
                                <td>
                                    <a data-toggle="modal" href="#edit<?php echo $row->id; ?>" class="btn btn-xs blue"><i class="glyphicon glyphicon-edit"></i> </a>
                                    <a href="<?php echo base_url();?>admin/senderDelete/<?php echo $row->id; ?>" data-toggle="confirmation" data-original-title=" " data-placement="top" class="btn btn-xs red"><i class="glyphicon glyphicon-trash"></i> </a>

                                    <div class="modal fade" id="edit<?php echo $row->id; ?>" tabindex="-1" role="basic" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content form">
                                                <form action="<?php echo base_url(); ?>admin/sender_update" method="post" class="">
                                                    <input type="hidden" name="sender_id" value="<?php echo $row->id; ?>">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title">발신번호</h4>
                                                    </div>
                                                    <div class="modal-body">

                                                        <input type="text" name="sender_number" value="<?php echo $row->sender_number; ?>" class="form-control" required>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn green">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
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

