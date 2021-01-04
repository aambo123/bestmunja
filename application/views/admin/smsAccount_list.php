<div class="page-content">


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo base_url(); ?>admin">Admin</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <span>SMS 계정</span>
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
                        <span class="caption-subject font-green sbold uppercase">SMS 계정</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                        <a href="<?php echo base_url(); ?>admin/smsAccount/add/0" class="btn btn-success btn-sm">
                            <i class="glyphicon glyphicon-plus"></i> New
                        </a>
                        
						<a href="<?php echo base_url(); ?>admin/downloadSmsAcount" class="btn btn-primary btn-sm">
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
                            <th width="15%">연동 name</th>
                            <th width="20%">연동 ID</th>
                            <th width="15%">연동 비밀번호</th>

                            <th width="10%">기본값</th>
                            <th width="">Order</th>
                            <th width="10%">메시지</th>
                            <th width="10%">수정 / 삭제</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        <?php
                        $count = 0;
                        foreach ($account as $row){ $count++;

//                            $content = file_get_contents("https://api.1s2u.io/checkbalance?user=".$row->username."&pass=".$row->password."");
//                            $msg_limit = json_decode($content);
//                            if($msg_limit !== null) {
//                                $this->users_model->sms_account_update($row->id, $msg_limit);
//
//                            }else{
                                $sms_account_limit = $this->users_model->sms_account_limit($row->id);
                            //}
                            ?>
                            <tr >
                                <th><span ><?php echo $count; ?></span></th>
                                <td><span class='bold ' >
                                     <?php
                                        $api = $this->settings_model->get_api_one($row->name);
                                        echo $api->name;
                                     ?>
                                </span></td>
                                <td><span class='bold ' ><?php echo $row->username; ?></span></td>
                                <td><span class='bold ' ><?php echo $row->password; ?></span></td>

                                <td>
                                    <span class='bold '>

                                        <div class="mt-checkbox-inline">

                                            <label class="mt-checkbox mt-checkbox-outline">
                                                <input type="checkbox" name="default" value="<?php echo $row->id; ?>" onClick="window.location='/admin/smsAccountDefault/<?php echo $row->id; ?>';" <?php if($row->default == 1){ echo "checked";} ?>  >
                                                <span></span>
                                            </label>

                                        </div>

<!--                                        <div class="md-checkbox">-->
<!--                                                    <input type="checkbox" id="checkbox1" class="md-check">-->
<!--                                                    <label for="checkbox1">-->
<!--                                                        <span></span>-->
<!--                                                        <span class="check"></span>-->
<!--                                                        <span class="box"></span> Option 1 </label>-->
<!--                                                </div>-->
                                    </span>
                                </td>
                                <td>
                                    <input type="hidden" name="mainmenuid" id="accountId<?php echo $row->id;?>" value="<?php echo $row->id;?>" >
                                    <input type="hidden" name="mainmenuorder" id="accountOrder<?php echo $row->id;?>" value="<?php echo $row->order;?>" >
                                    <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" onclick="order_up<?php echo $row->id; ?>()">
                                        <i class="fa fa-angle-up"></i>
                                    </button>

                                    <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" onclick="order_down<?php echo $row->id; ?>()">
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <script>
                                        function order_up<?php echo $row->id; ?>() {
                                            var accountid = document.getElementById("accountId<?php echo $row->id; ?>").value;
                                            var accountorder = document.getElementById("accountOrder<?php echo $row->id; ?>").value;
                                            //console.log(mainmenuorder);
                                            $.ajax
                                            ({
                                                url: '<?php echo base_url();?>/admin/order_up',
                                                data: {"accountid": accountid, "accountorder": accountorder},
                                                type: 'post',
                                                success: function(result)
                                                {

                                                    console.log(result);
                                                    location.reload();

                                                }
                                            });
                                        }
                                    </script>
                                    <script>
                                        function order_down<?php echo $row->id; ?>() {
                                            var accountid = document.getElementById("accountId<?php echo $row->id; ?>").value;
                                            var accountorder = document.getElementById("accountOrder<?php echo $row->id; ?>").value;
                                            //console.log(course_id);
                                            $.ajax
                                            ({
                                                url: '<?php echo base_url();?>/admin/order_down',
                                                data: {"accountid": accountid, "accountorder": accountorder},
                                                type: 'post',
                                                success: function(result)
                                                {

                                                    console.log(result);

                                                    location.reload();

                                                }
                                            });
                                        }
                                    </script>

                                </td>
                                <td>
                                    <span class='bold ' id="too<?php echo $row->id; ?>" >
                                         <?php echo $sms_account_limit->msg_limit;?>
                                        
                                    </span>
                                    <input type="hidden" value="<?php echo $row->username; ?>" id="user<?php echo $row->id; ?>">
                                    <input type="hidden" value="<?php echo $row->password; ?>" id="pass<?php echo $row->id; ?>">


                                </td>
                                <td>
                                    <a href="<?php echo base_url();?>admin/smsAccount/edit/<?php echo $row->id; ?>" class="btn btn-xs blue"><i class="glyphicon glyphicon-edit"></i> </a>
                                    <a href="<?php echo base_url();?>admin/smsAccount/delete/<?php echo $row->id; ?>" data-toggle="confirmation" data-original-title=" " data-placement="top" class="btn btn-xs red"><i class="glyphicon glyphicon-trash"></i> </a>
                                </td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
<!--                    <script>-->
<!--                        function myFunction(val) {-->
<!--                            $('#loader').addClass('visible');-->
<!--                            var data = new FormData();-->
<!--                            data.append("id", val);-->
<!--                            data.append("user", $('#user'+val+'').val());-->
<!--                            data.append("pass", $('#pass'+val+'').val());-->
<!--                            //alert(user);-->
<!--                            $.ajax({-->
<!--                                url: '/admin/getcredits',-->
<!--                                type: "POST",-->
<!--                                data: data,-->
<!--                                contentType: false,-->
<!--                                processData: false,-->
<!--                                cache: false,-->
<!--                                async: true,-->
<!--                                success: function(data){-->
<!--                                    $('#loader').removeClass('visible');-->
<!--                                    console.log(data);-->
<!--                                    if(data != 0) {-->
<!--                                        $('#too' + val + '').html(data);-->
<!--                                    }-->
<!--                                    // if(data == 8){-->
<!--                                    //     alert('비밀번호 및 아이디가 일치하지 않습니다.');-->
<!--                                    //     location.reload();-->
<!--                                    // }-->
<!--                                    //alert(data);-->
<!--                                }-->
<!--                            });-->
<!---->
<!--                        }-->
<!--                    </script>-->
<!--                    <script type="text/javascript">-->
<!--                         function routeeBalance(data){-->
<!--                              $('#loader').addClass('visible');-->
<!--                              $.ajax({-->
<!--                                 url: '/admin/getRoutee',-->
<!--                                 type: "POST",-->
<!--                                 data: {-->
<!--                                      id : data,-->
<!--                                 },-->
<!--                                 success: function(response){-->
<!--                                      console.table(response);-->
<!--                                     $('#loader').removeClass('visible');-->
<!--                                     if(response != 0) {-->
<!--                                         $('#too' + data + '').html(response);-->
<!--                                     }-->
<!---->
<!--                                 }-->
<!--                             });-->
<!--                         }-->
<!--                    </script>-->

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
