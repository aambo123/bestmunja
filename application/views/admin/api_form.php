<div class="page-content">


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo base_url(); ?>admin">Admin</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <span>API 서비스 등록</span>
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
                        <span class="caption-subject font-green sbold uppercase">API 서비스 등록</span>
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body form ">
                    <br>
                    <?php if ($uildel == 'add'): ?>
                         <form class="" action="<?php echo base_url(); ?>admin/api/save/0" method="post">
                    <?php elseif($uildel == 'edit'): ?>
                         <form class="" action="<?php echo base_url(); ?>admin/api/update/<?php echo $api->id;?>" method="post">
                    <?php endif; ?>

                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="id">API 서비스명</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-2">
                                <input class="form-control" type="text" name="name"
                                value="<?php if(isset($_POST['name'])){
                                      echo "".$_POST['name']."";
                                 }elseif($api != null) {
                                      echo $api->name;
                                 }?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('name');
                                echo "</span>";
                                ?>
                            </div>
                        </div>

                        <div class="form-group row ">
                           <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="id">발송 URL</label>
                                <span class="font-red-mint bold">*</span>
                           </div>
                           <div class="col-12 col-sm-2">
                                <input
                                class="form-control"
                                type="text"
                                name="send_url"
                                value="<?php if(isset($_POST['send_url'])){ echo "".$_POST['send_url'].""; }elseif($api != null) {echo $api->send_url;}?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('send_url');
                                echo "</span>";
                                ?>
                           </div>
                           <div class="col-12 col-sm-2 text-right">
                                <label class="my-2" for="id">Callback URL</label>
                                <span class="font-red-mint bold">*</span>
                           </div>
                           <div class="col-12 col-sm-2">
                                <input class="form-control" type="text" name="dlr_url" value="<?php if(isset($_POST['dlr_url'])){ echo "".$_POST['dlr_url'].""; }elseif($api != null)  {echo $api->dlr_url;}?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('dlr_url');
                                echo "</span>";
                                ?>
                           </div>
                        </div>
                        <hr>

                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="id">발송 아이디</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-2">
                                <input class="form-control" type="text" name="username" value="<?php if(isset($_POST['username'])){ echo "".$_POST['username'].""; }elseif($api != null)  {echo $api->username;}?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('username');
                                echo "</span>";
                                ?>
                            </div>
                            <div class="col-12 col-sm-2 text-right">
                                <label class="my-2" for="id">발송 비밀번호</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-2">
                                <input class="form-control" type="text" name="password" value="<?php if(isset($_POST['password'])){ echo "".$_POST['password'].""; }elseif($api != null)  {echo $api->password;}?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('password');
                                echo "</span>";
                                ?>
                            </div>
                        </div>

                        <div class="form-group row ">
                           <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="id">발신번호</label>
                                <span class="font-red-mint bold">*</span>
                           </div>
                           <div class="col-12 col-sm-2">
                                <input class="form-control" type="text" name="sender" value="<?php if(isset($_POST['sender'])){ echo "".$_POST['sender'].""; }elseif($api != null)  {echo $api->sender;}?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('sender');
                                echo "</span>";
                                ?>
                           </div>
                        </div>

                        <div class="form-group row ">
                           <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="id">수신번호</label>
                                <span class="font-red-mint bold">*</span>
                           </div>
                           <div class="col-12 col-sm-2">
                                <input class="form-control" type="text" name="recipient" value="<?php if(isset($_POST['recipient'])){ echo "".$_POST['recipient'].""; }elseif($api != null)  {echo $api->recipient;}?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('recipient');
                                echo "</span>";
                                ?>
                           </div>
                        </div>

                        <div class="form-group row ">
                           <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="id">텍스트</label>
                                <span class="font-red-mint bold">*</span>
                           </div>
                           <div class="col-12 col-sm-2">
                                <input class="form-control" type="text" name="message" value="<?php if(isset($_POST['message'])){ echo "".$_POST['message'].""; }elseif($api != null)  {echo $api->message;}?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('message');
                                echo "</span>";
                                ?>
                           </div>
                        </div>

                        <div class="form-group row ">
                           <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="id">type</label>
                           </div>
                           <div class="col-12 col-sm-2">
                                <input class="form-control" type="text" name="type" value="<?php if(isset($_POST['type'])){ echo "".$_POST['type'].""; }elseif($api != null)  {echo $api->type;}?>"  >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('type');
                                echo "</span>";
                                ?>
                           </div>
                           <div class="col-12 col-sm-2 text-right">
                                <label class="my-2" for="id">unicode</label>
                                <span class="font-red-mint bold">*</span>
                           </div>
                           <div class="col-12 col-sm-2">
                                <input class="form-control" type="text" name="unicode" value="<?php if(isset($_POST['unicode'])){ echo "".$_POST['unicode'].""; }elseif($api != null)  {echo $api->unicode;}?>" required>
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('unicode');
                                echo "</span>";
                                ?>
                           </div>
                        </div>
                        <hr>
                        <div class="form-group row ">
                           <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="id">Action</label>
                           </div>
                           <div class="col-12 col-sm-2">
                                <input class="form-control" type="text" name="action" value="<?php if(isset($_POST['action'])){ echo "".$_POST['action'].""; }elseif($api != null)  {echo $api->action;}?>">
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('action');
                                echo "</span>";
                                ?>
                           </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12 col-sm-3">

                            </div>
                            <div class="col-12 col-sm-6 text-right">

                                <button type="submit" class="btn btn-success mr-2" id="submit" name="button" >저장</button>
                                <a href="<?php echo base_url();?>admin/api_list" class="btn dark" name="button" >취소</a>
                            </div>
                        </div>
                    </form>
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

    <script type="text/javascript">
        $(document).ready(function(){

            $('#user_mobile_number').mask('000-0000-0000');

            var options = {
                onKeyPress: function(cep, e, field, options){
                    var masks = ['000-000-0000','00-000-00000'];
                    console.log(cep.length);
                    var mask = (cep.length > 11) ? masks[0] : masks[1];
                    $('#user_phone_number').mask(mask, options);
                }
            };
            $('#user_phone_number').mask('000-000-0000', options);



        });

        // $('#user_name').mask('KKK',{'translation': {
        //           K : {pattern: /[\u3131-\uD79DA-Za-z]/},
        //      }
        // })
    </script>
</div>
