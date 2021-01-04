<div class="page-content">


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo base_url(); ?>admin">Admin</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <span>관리자정보설정</span>
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
                        <span class="caption-subject font-green sbold uppercase">관리자정보설정</span>
                    </div>

                </div>
                <div class="portlet-body form">
                    <form class="" action="<?php echo base_url(); ?>admin/edit_set" method="post">

                        <div class="form-group row">
                            <div class="col-12 col-sm-3 text-right">
                                <input type="hidden" name="user_id" value="<?php echo $user->mb_no; ?>">
                                <label class="my-2" for="id">ID</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="hidden" name="old_mb_id" value="<?php echo $user->mb_id; ?>">
                                <input required class="form-control" type="text" name="mb_id" id="mb_id" value="<?php if(isset($_POST['mb_id'])){ echo "".$_POST['mb_id'].""; }else{ echo $user->mb_id;} ?>" required maxlength="20">
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('mb_id');
                                echo "</span>";
                                ?>
                            </div>
                            <div class="col-12 col-sm-3 flex align-center">
                                <span class="small">(최대20자 이내로 입력하세요)</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="name">이름</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input class="form-control" type="text" name="mb_name"  id="mb_name" value="<?php if(isset($_POST['mb_name'])){ echo "".$_POST['mb_name'].""; }else{ echo $user->mb_name;} ?>" required maxlength="20">
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('mb_name');
                                echo "</span>";
                                ?>
                            </div>
                            <div class="col-12 col-sm-3 flex align-center">
                                <span class="small">(최대20자 이내로 입력하세요)</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="password">비밀번호</label>

                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="hidden" name="old_mb_password" value="<?php echo $user->mb_password; ?>">
                                <input class="form-control" type="password" name="mb_password" id="mb_password" maxlength="20" disabled>
                            </div>
                            <div class="col-12 col-sm-3 flex align-center">

                                <div class="mt-checkbox-inline">

                                    <label class="mt-checkbox mt-checkbox-outline">
                                        <input type="checkbox" name="pass_change" id="pass_change" value="1" onchange="myFunction(this.value)" > 변경
                                        <span></span>
                                    </label>

                                </div>

                                <script>
                                    function myFunction(val) {
                                        if($('#pass_change').is(":checked")){
                                            $('#mb_password').prop('disabled', false);
                                        }else{
                                            $('#mb_password').val('');
                                            $('#mb_password').prop('disabled', true);
                                        }

                                    }
                                </script>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="phone">이메일</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="hidden" name="old_mb_email" value="<?php echo $user->mb_email; ?>">
                                <input class="form-control" type="text" name="mb_email" id="mb_email" value="<?php if(isset($_POST['mb_email'])){ echo "".$_POST['mb_email'].""; }else{ echo $user->mb_email;} ?>" required maxlength="30">
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('mb_email');
                                echo "</span>";
                                ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="user_mobile_number">휴대폰번호</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input class="form-control" type="text" name="user_mobile_number" id="user_mobile_number" value="<?php if(isset($_POST['user_mobile_number'])){ echo "".$_POST['user_mobile_number'].""; }else{ echo $user->mb_hp;} ?>" required maxlength="15">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="user_phone_number">전화번호</label>

                            </div>
                            <div class="col-12 col-sm-6">
                                <input class="form-control" type="text" name="user_phone_number" id="user_phone_number" value="<?php if(isset($_POST['user_phone_number'])){ echo "".$_POST['user_phone_number'].""; }else{ echo $user->mb_tel;} ?>" required maxlength="15">
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <div class="col-12 col-sm-3 text-right">

                                <label for="user_postcode" class="form-label my-2">주소</label>

                            </div>
                            <div class="col-12 col-sm-3">

                                <div class="input-group">
                                    <input id="user_postcode" class="form-control" type="text" name="user_postcode" value="<?php if(isset($_POST['user_postcode'])){ echo "".$_POST['user_postcode'].""; }else{ echo $user->mb_zip1;}?>" readonly />
                                    <span class="input-group-btn">
                                        <button type="button" onclick="findZip()" name="button" class="btn dark">우편번호검색</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">

                                <input type="text" class="form-control" name="mb_addr1" id="user_address" value="<?php if(isset($_POST['mb_addr1'])){ echo "".$_POST['mb_addr1'].""; }else{ echo $user->mb_addr1;}?>" placeholder="기본주소">
                            </div>
                        </div> -->



                        <!-- <div class="form-group row">
                            <div class="col-12 col-sm-3">

                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control" name="user_detailAddress" id="user_detailAddress" value="<?php if(isset($_POST['user_detailAddress'])){ echo "".$_POST['user_detailAddress'].""; }else{ echo $user->mb_addr2; }?>" placeholder="상세주소">
                            </div>
                        </div> -->

<!--                        <div class="form-group row">-->
<!--                            <div class="col-12 col-sm-3">-->
<!--                                <label class="my-2" for="1s2u_password">MSG limit</label>-->
<!---->
<!--                            </div>-->
<!--                            <div class="col-12 col-sm-6">-->
<!--                                <input class="form-control" type="text" value="1000000 건" readonly>-->
<!--                            </div>-->
<!--                        </div>-->

                        <div class="form-group row">
                            <div class="col-12 col-sm-3">

                            </div>
                            <div class="col-12 col-sm-6 text-right">

                                <button type="submit" class="btn btn-success mr-2" name="button" >저장</button>
                                <a href="/admin" class="btn dark" name="button">취소</a>

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
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
    <script>

        function findZip(){
            new daum.Postcode({
                oncomplete: function(data) {
                    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                    var addr = ''; // 주소 변수
                    var extraAddr = ''; // 참고항목 변수

                    //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                    if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                        addr = data.roadAddress;
                    } else { // 사용자가 지번 주소를 선택했을 경우(J)
                        addr = data.jibunAddress;
                    }

                    // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                    if(data.userSelectedType === 'R'){
                        // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                        // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                        if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                            extraAddr += data.bname;
                        }
                        // 건물명이 있고, 공동주택일 경우 추가한다.
                        if(data.buildingName !== '' && data.apartment === 'Y'){
                            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                        }
                        // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                        if(extraAddr !== ''){
                            extraAddr = ' (' + extraAddr + ')';
                        }
                        // 조합된 참고항목을 해당 필드에 넣는다.
                        document.getElementById("user_address").value = addr + extraAddr;

                    } else {
                        document.getElementById("user_address").value = addr;
                    }

                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    document.getElementById('user_postcode').value = data.zonecode;
                    // document.getElementById("user_address").value = addr;
                    // 커서를 상세주소 필드로 이동한다.
                    document.getElementById("user_detailAddress").focus();
                }
            }).open();
        }

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
