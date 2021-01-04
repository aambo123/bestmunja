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
                    <form class="" action="<?php echo base_url(); ?>admin/recommendationSave" method="post" id="form1">
                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="id">가입 코드</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-10 col-sm-5">
                                <input class="form-control sett" type="text" name="rec_code" id="rec_code"
                                value="<?php if(isset($_POST['rec_code'])){ echo "".$_POST['rec_code'].""; }?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('rec_code');
                                echo "</span>";
                                ?>
                            </div>
                            <div class="col-2 col-sm-1">
                                <input type="hidden" name="codeCheck" value='N'>
                                <a onclick="checkCode()" class="btn btn-block btn-primary">코드체크</a>
                            </div>
                        </div>

                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">

                                <label class="my-2" for="id">메시지 당 가격</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">

                                <input class="form-control sett" type="text" name="msg_price" id="msg_price" value="<?php if(isset($_POST['msg_price'])){ echo "".$_POST['msg_price'].""; }?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('msg_price');
                                echo "</span>";
                                ?>
                            </div>
                            <div class="col-12 col-sm-3 flex align-center">

                            </div>
                        </div>
<?php if($this->session->userdata('user_level') == 'Super admin') {?>

                        
                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="id">API 계정</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <select name="account_id" id="account_id" class="form-control">
                                    <option value="">선택</option>
    <?php foreach ($api_accounts as $acc) {?>
                                    <option value="<?php echo $acc->id?>">
                                        <?php echo $acc->username?>
                                    </option>
    <?php }?>
                                </select>
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('account_id');
                                echo "</span>";
                                ?>
                            </div>
                        </div>
<?php } else {?>
    <input type="hidden" name="account_id" id="account_id" value="0">
<?php }?>
                        <div class="form-group row">
                            <div class="col-12 col-sm-3">

                            </div>
                            <div class="col-12 col-sm-6 text-right">

                                <button type="button" class="btn btn-success mr-2" id="btn">저장</button>
                                <a href="/admin/recommendation" class="btn dark">취소</a>

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

        function checkCode(){
            var code = $("#rec_code").val();
            if(code == ""){
                alert("코드를 입력하세요.");
                return false;
            }
            $.ajax({
                url: '/admin/check_rec_code',
                type: "POST",
                async: true,
                cache: false,
                data: {
                    code:  code,
                },
                success: function (result) {
                    console.log(result,result == true);
                    if (result == 0) {
                        $('input[name=codeCheck]').val('Y')
                        alert('사용 가능합니다.')
                    } else{
                        $('input[name=codeCheck]').val('N')
                        alert('사용 불가능합니다.')
                    }
                }
            })
        }


        $('#btn').on('click',function(){
            console.log('object :>> ');
            if($('input[name=codeCheck]').val() == 'N'){
                alert('코드를 체크하세요.');
                return false;
            }else{
                $('#form1').submit();
            }
        })
        $('#form1').submit(function(){
            alert('hi');
            return false;
        });
        // $('#user_name').mask('KKK',{'translation': {
        //           K : {pattern: /[\u3131-\uD79DA-Za-z]/},
        //      }
        // })
    </script>
</div>