<?php 
$title = array(
    "본인인증 없음","무제한 발신번호 변경","최고의 보안","최저가&속도","광고법제한X"
);
$text = array(
    "타 동종업계와 달리 <br>
    본인인증을 요구하지 않습니다.",

    "SMS발신번호를 최소5자리이상<br>
    마음대로 변경이 가능합니다.",
    
    "sql인젝션,DDOS등 막아내고<br>
    자체적 암호화로 여러 DB유출 및<br>
    서버 항시 보안 유지",
    
    "Direct시스템 구축으로<br>
    빠른 속도를 자랑하며<br>
    최저가로 제공합니다.",
    
    "국내광고법<br>
    (080 수신차단,광고문자표기 등)에<br>
    제한받지 않으며 높은 발송률을<br>
    자랑합니다."
);
$bot_text = array(
    "최저가 SMS 단가를 제공",

    "자체 리셀러 시스템 구축으로<br>
    즉시 정산",
    
    "리셀러분들은 회원들을<br>
    직접 관리할 수 있으며<br>
    자율적 영업가능",
    
    "DB유출방지로<br>
    자체적 암호화 실시",
    
    "리셀러 그룹 운영으로<br>
    각기 다른 리셀러분들과<br>
    본사와 소통가능"
)
?>
<div class="service">

    <div class="container ">
        <h1 class="txt-center service-title">고스트SMS의 강점</h1>
        <div class="row">
            <?php
                for ($x = 0; $x <= 4; $x++) {
                    ?>
                    <div class="col">
                        <div class="service-top">
                            <div class="img-wrapper">
                                <img src="/assets/images/top_icon<?php echo $x+1;?>.png" alt="">
                            </div>
                            <h4>
                                <?php echo $title[$x];?>
                            </h4>
                            <p>
                                <?php echo $text[$x];?>
                            </p>
                        </div>
                    </div>
                    
            <?php }?>
        </div>
        <hr>
        <h1 class="txt-center service-title">고스트SMS 이용하는 회원분들께 드리는 혜택</h1>
        <div class="row">
            <div class="col-sm-6 txt-center service-mid">
                <div class="img">
                    <img src="/assets/images/self_land.png" alt="">
                </div>
                <h4>셀프렌드</h4>
                <p>
                    각종 SNS플랫폼에서 좋아요,팔로워,조회수,구독자,댓글,채널 회원수 등 <br>
                    트래픽, 방문자 증가 작업을 통해 마케팅 서비스를 제공하는 업체와 제휴를 맺어<br>
                    고스트SMS 이용중인 회원분들 한해서 더욱 저렴한 가격에 제공하고 있습니다.
                </p>
            </div>
            <div class="col-sm-6 txt-center service-mid">
                <div class="img">
                    <img src="/assets/images/kakao_talk.png" alt="">
                </div>
                <h4>국내 카톡발송& 라인발송팀</h4>
                <p>
                    카톡발송부터 라인발송까지 진행이 가능한<br>
                    대규모 업체와 제휴를 맺어 고스트SMS 이용중인 회원분들 한해서<br>
                    저렴한 가격에 제공하며 사기 걱정 없이 편안한 서비스를 제공합니다.
                </p>
            </div>
    
        </div>
        <hr>
        <h1 class="txt-center service-title">리셀러 혜택 <br>
        고스트SMS과 함께라면!</h1>
        <div class="row service-bot-wrap">
            <?php
                for ($x = 0; $x <= 4; $x++) {
                    ?>
                    <div class="col">
                        <div class="service-bot">
                            <span><?php echo $x+1;?></span>
                            <div class="img-wrapper">
                                <img src="/assets/images/bot_icon<?php echo $x+1;?>.png" alt="">
                            </div>
                            <p class="txt-center">
                                <?php echo $bot_text[$x];?>
                            </p>
                        </div>
                    </div>
                    
            <?php }?>
        </div>
    </div>
</div>