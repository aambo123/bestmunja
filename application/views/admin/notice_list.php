<div class="page-content">


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo base_url(); ?>admin">Admin</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <span>공지사항 명부</span>
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
                        <span class="caption-subject font-green sbold uppercase">공지사항 명부</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                        <a href="<?php echo base_url(); ?>admin/noticeAdd" class="btn btn-success btn-sm">
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
                        <thead>
                        <tr style="text-align: left;">
                            <th width="5%">번호</th>
                            <th width="">표제</th>
                            <th width="20%">사용 상태</th>
                            <th width="20%">작성일</th>

                            <th width="15%">수정 / 삭제</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        <?php
                        $count = 0;
                        foreach ($notice as $row){ $count++;

                            ?>
                            <tr >
                                <th><span ><?php echo $count; ?></span></th>
                                <td><span class='bold ' ><?php echo $row->title; ?></span></td>
                                <td>
                                    <span class='bold'>
                                    <?php 
                                        echo $row->use_yn == '1' ? 'Yes' : 'No';
                                    ?>
                                    </span>
                                </td>
                                <td><span class='bold ' ><?php echo $row->created_date; ?></span></td>
                                <td>
                                    <a href="<?php echo base_url();?>admin/noticeEdit/<?php echo $row->id; ?>" class="btn btn-xs blue"><i class="glyphicon glyphicon-edit"></i> </a>
                                    <a href="<?php echo base_url();?>admin/noticeDelete/<?php echo $row->id; ?>" data-toggle="confirmation" data-original-title=" " data-placement="top" class="btn btn-xs red"><i class="glyphicon glyphicon-trash"></i> </a>
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

