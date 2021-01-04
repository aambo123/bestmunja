<div class="page-content">


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo base_url(); ?>admin">Admin</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <span>SMS limit Add</span>
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
                        <span class="caption-subject font-green sbold uppercase">SMS limit Add</span>
                    </div>

                </div>
                <div class="portlet-body form">
                    <form class="" action="<?php echo base_url(); ?>admin/smsAdd_set" method="post">


                        <div class="form-group row">
                            <div class="col-12 col-sm-3">
                                <label class="my-2" for="1s2u_password">회원아이디</label>

                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="hidden" name="member_id" value="<?php echo $user_one->mb_no; ?>">
                                <input class="form-control" type="text" name="md_id" id="md_id" value="<?php echo $user_one->mb_id; ?>" readonly>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-12 col-sm-3">
                                <label class="my-2" for="1s2u_password">원하는 발송량만큼 충전해 주세요</label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <button type="button" class="btn red pr" name="button" value="1000">+ 1,000</button>
                                <button type="button" class="btn red pr" name="button" value="10000">+ 10,000</button>
                                <button type="button" class="btn red pr" name="button" value="50000">+ 50,000</button>
                                <button type="button" class="btn red pr" name="button" value="100000">+ 100,000</button>
                                <button type="button" class="btn red pr" name="button" value="300000">+ 300,000</button>
                                <button type="button" class="btn red pr" name="button" value="500000">+ 500,000</button>
                                <button type="button" class="btn red pr" name="button" value="1000000">+ 1,000,000</button>
                                <button type="button" class="btn red pr" name="button" value="2000000">+ 2,000,000</button>
                                <script>
                                    var price_per_msg = <?php if($settings != null){ echo $settings->msg_price; }else{ echo "0";} ?>;
                                    $('.pr').on('click', function(){

                                        $price = this.value;
                                        $first_value = $('#first_value').val();
                                        $total = $price + $first_value;
                                        $total_price = parseInt($total * 1.1);


                                        $num_send = Math.round($price/price_per_msg);
                                        $('#first_value').val($total);
                                        $('#payment').val($total_price);
                                        $('#msg_quantity').val($num_send);
                                        //alert($num_send);
                                    });
                                </script>

                            </div>
                        </div>

                            <div class="form-group row">
                                <div class="col-12 col-sm-3">
                                    <label class="my-2" for="1s2u_password">충전금액</label>

                                </div>
                                <div class="col-12 col-sm-6">
                                    <input type="hidden" id="first_value" value="">
                                    <input class="form-control" type="text" name="payment" id="payment" value="" readonly> <span class="font-sm font-blue bold">부가세 10%</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 col-sm-3">
                                    <label class="my-2" for="1s2u_password">발송가능</label>

                                </div>
                                <div class="col-12 col-sm-6">
                                    <input class="form-control" type="text" name="msg_quantity" id="msg_quantity" value="" readonly>
                                    <?php
                                    echo "<span style='color: #ff0000; font-size: 11px;'>";
                                    echo form_error('msg_quantity');
                                    echo "</span>";
                                    ?>
                                </div>

                            </div>
                        <div class="form-group row">
                            <div class="col-12 col-sm-3">

                            </div>
                            <div class="col-12 col-sm-6 text-right">

                                      <button type="submit" class="btn btn-success mr-2" name="button" >저장</button>
                                      <button type="reset" class="btn dark" name="button">취소</button>

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