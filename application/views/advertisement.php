<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8'">
    <title>로그인 | 글로벌문자</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/blue.css?v=2.2">

    <!-- Best munja custom css -->
    <link rel="stylesheet" href="/assets/css/custom.css?v=2.2">


    <link rel="stylesheet" href="/assets/src/js/font-awesome/css/font-awesome.min.css">

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <link rel="stylesheet" href="/assets/css/swiper.min.css">
    <script src="/assets/src/js/jquery-1.8.3.min.js"></script>
    <script src="/assets/src/js/jquery.menu.js"></script>
    <script src="/assets/src/js/common.js"></script>
    <script src="/assets/src/js/wrest.js"></script>
    <script src="/assets/src/js/placeholders.min.js"></script>
    <script src="/assets/js/feather.js"></script>
    <script src="/assets/js/swiper.min.js"></script>

    <?php
    $dat['general_info'] = $this->settings_model->get_meta();
    $this->load->view('frontend/template/meta',$dat); ?>
</head>
<body>
     <?php $this->session->userData('id') ? null : $this->load->view('frontend/template/menu') ?>
     <div class="container">
          <div class="row">
               <div class="col-lg-12">
                    <div class="row">
                         <div class="col-sm-12">
                         <div class="card">
                                   <div class="card_header">
                                        <h3 class="my-0">공지사항</h3>
                                   </div>
                                   <div class="card_body">
                                   <?php
                                    if (!empty($advertisements)){
                                      foreach ($advertisements as $i => $row){
                                        echo '
                                          <button class="collapsible " rel="collap'.$i.'">
                                          <i class="fas fa-plus" style="font-size: 16px;padding-right: 9px;color: #009bfa;"></i>'. $row->title .'<b style="position: absolute; right: 40px; 
                                          font-weight: 100;">더 보기</b></button>
                                          <div class="content" id="collap'.$i.'">
                                            <p>'. $row->content .'</p>
                                          </div>
                                        ';
                                      }
                                    } else {
                                      echo '<p>공지 사항 없음</p>';
                                    }
                                    
                                    ?> 
                                   </div>
                              </div>
                              
                              <div class="table_action">
                                   <?php echo $pagination; ?>
                              </div>   
                              
                         </div>
                    </div>
               </div>
          </div>
     </div>

<?php $this->session->userData('id') ? null : $this->load->view('frontend/template/footer'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
$( document ).ready(function() {
    $( ".collapsible" ).click(function() {
        var target = '#'+$(this).attr('rel');
        if($( target ).css('display') == 'none') {

            $('i', this).removeClass('fas fa-plus').addClass('fas fa-minus');
            $( ".content" ).hide();
            $( target ).show();
        } else {
          $( target ).hide();
          $('i', this).removeClass('fas fa-minus').addClass('fas fa-plus');
        }
        
    });
});
var swiper = new Swiper('.swiper-container',{
     autoplay:{
          delay: 5000,
     },
     effect: 'fade',
     fadeEffect: {
    crossFade: true
  },
  loop: true,
})
</script>
</body>
</html>