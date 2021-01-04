<div class="page-content">


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

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-info font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">추천 코드</span>
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body form ">
                    <br>
                    <form class="" action="<?php echo base_url(); ?>admin/recommendationUpdate" method="post">
                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">

                                <label class="my-2" for="id">메시지 당 가격</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="hidden" name="msg_price" value="<?php if(isset($_POST['msg_price'])){ echo "".$_POST['msg_price'].""; }else{ echo $recommendation->msg_price;} ?>">
                                <input required class="form-control sett" type="text" name="msg_price" id="msg_price" value="<?php echo $recommendation->msg_price; ?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('msg_price');
                                echo "</span>";
                                ?>
                            </div>
                            <div class="col-12 col-sm-3 flex align-center">

                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-12 col-sm-3">

                            </div>
                            <div class="col-12 col-sm-6 text-right">

                                <button type="submit" class="btn btn-success mr-2" id="submit" name="button" >저장</button>
                                <a href="/admin/recommendation" class="btn dark" name="button" >취소</a>

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
