<div id="reg_result">
	

</div>

<div class="container padding-top-30">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-sm-12">

					<div class="card">
						<div class="card_header">
                            <!-- <h3 class="my-0 notice_card_header">공지사항</h3> -->
                            <h3 class="my-0 notice_card_header"><strong>회원가입</strong>이 완료되었습니다.</h3>
						</div>
						<div class="card_body">
                            
                            <p class="reg_result_p">
                                <strong><?php echo $user->mb_name; ?></strong> 님의 회원가입을 진심으로 축하합니다.<br>
                            </p>

                            <?php if ($user->mb_email_certify == '0000-00-00 00:00:00') {  ?>
                            <!--        <p>-->
                            <!--            회원 가입 시 입력하신 이메일 주소로 인증메일이 발송되었습니다.<br>-->
                            <!--            발송된 인증메일을 확인하신 후 인증처리를 하시면 사이트를 원활하게 이용하실 수 있습니다.-->
                            <!--        </p>-->
                            <!--        <div id="result_email">-->
                            <!--            <span>아이디</span>-->
                            <!--            <strong>--><?php //echo $user->mb_id; ?>
                            <!--</strong><br>-->
                            <!--            <span>이메일 주소</span>-->
                            <!--            <strong>--><?php //echo $user->mb_email; ?>
                            <!--</strong>-->
                            <!--        </div>-->
                            <!--        <p>-->
                            <!--            이메일 주소를 잘못 입력하셨다면, 사이트 관리자에게 문의해주시기 바랍니다.-->
                            <!--        </p>-->
                            <?php }  ?>

                            <p>
                                회원님의 비밀번호는 아무도 알 수 없는 암호화 코드로 저장되므로 안심하셔도 좋습니다.<br>
                                아이디, 비밀번호 분실시에는 회원가입시 입력하신 이메일 주소를 이용하여 찾을 수 있습니다.
                            </p>

                            <p>
                                회원 탈퇴는 언제든지 가능하며 일정기간이 지난 후, 회원님의 정보는 삭제하고 있습니다.<br>
                                감사합니다.
                            </p>
                            <br>
                            <a href="/" class="btn btn-sm primary">메인으로</a>
						</div>
					</div>

					<div class="table_action">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
