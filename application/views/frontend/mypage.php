<link rel="stylesheet" href="<?php echo base_url(); ?>assets/src/css/smsAdd.css">
<script src="<?php echo base_url(); ?>assets/src/js/mypage.js"></script>
<div class="page">
     <div class="container">
          <div class="row">
               <div class="col-lg-8">
                    <div class="row">
                         <div class="col-sm-6">
                              <div class="card">
                                   <div class="card_body">
                                        <div class="row">
                                             <div class="col">
                                                  <h5 class="my-0 upper text-muted">total messages sent</h5>
                                                  <span class="h2 bold"><?php echo number_format($stats->quantity); ?>건</span>
                                             </div>
                                             <div class="col-auto">
                                                  <div class="icon bg-gradient-primary">
                                                       <i data-feather="send"></i>
                                                  </div>
                                             </div>
                                        </div>
                                        <p class="mt-2 small">
                                             <span class="txt-green bold mr-1">
                                                  <i data-feather="trending-up" width="14" height="14"></i>
                                                  <?php if ($stats->quantity > 0): ?>
                                                       <?php echo substr(($stats->delivered_count*100)/$stats->quantity,0,4).'%' ?>
                                                  <?php endif; ?>
                                             </span>
                                             <?php echo $stats->delivered_count ?>건 성공
                                        </p>
                                   </div>
                              </div>
                         </div>
                         <div class="col-sm-6">
                              <div class="card">
                                   <div class="card_body">
                                        <div class="row">
                                             <div class="col">
                                                  <h5 class="my-0 upper text-muted">남은 건수</h5>
                                                  <span class="h2 bold"><?php echo number_format($user->msg_quantity).' 건'; ?></span>
                                             </div>
                                             <div class="col-auto">
                                                  <div class="icon bg-gradient-green">
                                                       <i data-feather="credit-card"></i>
                                                  </div>
                                             </div>
                                        </div>
                                        <p class="mt-2 small">
                                             건당 단가 :
                                             <span class="txt-green bold mr-1">
                                                  <?php echo $msg_price ? $msg_price->msg_price . '원' : '없음' ?>
                                             </span>
                                        </p>

                                   </div>
                              </div>
                         </div>
                         <div class="col-sm-12">
                              <div class="card">
                                   <div class="card_header">
                                        <h3 class="my-0">최근 발송</h3>
                                   </div>
                                   <div class="card_body">
                                        <canvas id="myChart" width="100%"></canvas>
                                   </div>
                              </div>
                         </div>

                         <div class="col-sm-12">
                              <div class="card">
                                   <div class="card_header">
                                        <h3 class="my-0">차감 이력</h3>
                                   </div>
                                   <div class="card_body">
                                        <?php
                                             echo '
                                             <table class="table">
                                                  <thead>
                                                       <tr>
                                                            <th>ID</th>
                                                            <th>건수</th>
                                                            <th>차감 이력</th>
                                                            <th>체계</th>
                                                            <th>작성일</th>
                                                       </tr>
                                                  </thead>
                                             <tbody>
                                             ';
                                             $i = 1;
                                             foreach ($cash as $row){

                                                  echo '
                                                  <tr>
                                                       <td>'. $i++ .'</td>
                                                       <td>'. $row->cash .'</td>
                                                       <td>'. $row->success .'</td>
                                                       <td>'. $row->system .'</td>
                                                       <td>'. $row->created_date .'</td>
                                                  </tr>
                                                  ';
                                             }
                                             echo '
                                                  </tdbody>     
                                             </table>
                                             ';
                                        ?>
                                   </div>
                              </div>
                              
                              <div class="table_action">
                                   <?php echo $pagination; ?>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="col-lg-4">
                    <div class="card ">
                         <div class="card_header bg-gradient-primary">
                              <div class="row">
                                   <div class="col">
                                        <span class="bold"><?php echo $user->mb_id; ?></span>
                                   </div>
                                   <div class="col-auto">
                                        <a href="" class="icon_button"  id="edit_profile" >
                                             <i data-feather="edit" width="18" height="18"></i>
                                        </a>
                                   </div>
                              </div>
                         </div>
                         <div class="card_body">
                              <ul class="list_group">
                                   <li class="list_group_item px-0">
                                        <div class="flex align-center justify-between">
                                             <i data-feather="user"></i>
                                             <?php echo $user->mb_name; ?>
                                        </div>

                                   </li>
                                   <li class="list_group_item px-0">
                                        <div class="flex align-center justify-between">
                                             <i data-feather="mail"></i>
                                             <?php echo $user->mb_email ?>
                                        </div>
                                   </li>
                                   <li class="list_group_item px-0">
                                        <div class="flex align-center justify-between">
                                             <i data-feather="key"></i>
                                             **********
                                        </div>
                                   </li>
                              </ul>
                         </div>
                    </div>
                    <div class="card">
                         <div class="card_header">
                              <div class="flex justify-between align-center">
                                   <h3 class="my-0">충전 로그</h3>
                                   <a href="/users/smsAdd" class="btn btn-sm mt-1 primary">
                                        충전
                                   </a>
                              </div>

                         </div>
                         <div class="card_body">
                              <ul class="list_group">
                                   <?php foreach ($recharge_log as $log): ?>
                                        <li class="list_group_item px-0">
                                             <div class="row align-center justify-between">
                                                  <div class="col">
                                                       <h5 class="my-0 text-muted">
                                                            <?php echo date('Y-m-d',strtotime($log->created_date)) ?>
                                                            <?php if ($log->type == 1){ ?>
                                                                 (관리자 부여)
                                                            <?php } ?>
                                                       </h5>
                                                       <h2 class="my-0">
                                                            <?php if ($log->type == 1){ ?>
                                                                 <?php echo number_format($log->num_send) ?> 건</h2>
                                                            <?php } else { ?>
                                                                 <?php echo number_format($log->num_send) ?> 건<span class="small">(<?php echo number_format($log->total_price) ?>원)</span></h2>
                                                            <?php } ?>
                                                  </div>
                                                  <div class="col-auto">
                                                       <?php if ($log->status == 2){ ?>
                                                            <div class="icon_sm bg-green" data-hover="text" data-content="성공">
                                                                 <i data-feather="check" width="18" height="18"></i>
                                                            </div>
                                                       <?php } elseif ($log->status == 0){ ?>
                                                            <div class="icon_sm bg-teal" data-hover="text" data-content="대기">
                                                                 <i data-feather="list" width="18" height="18"></i>
                                                            </div>
                                                       <?php } elseif ($log->status == 1){ ?>
                                                            <div class="icon_sm bg-red" data-hover="text" data-content="취소">
                                                                 <i data-feather="x" width="18" height="18"></i>
                                                            </div>
                                                       <?php } ?>
                                                  </div>
                                             </div>
                                        </li>
                                   <?php endforeach; ?>

                              </ul>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<div class="modal_wrapper" id="edit">
     <div class="modal">
          <form class="" action="<?php echo base_url(); ?>home/change_profile" method="post">
          <div class="modal_header">
               <p class="modal_title">개인정보수정</p>
               <a href="#" data-close="edit" class="close"></a>
          </div>
          <div class="modal_body">
               <input type="hidden" name="pass_will_change" id="pass_will_change" value="0">
                    <div class="form-group">
                         <label for="mb_name" class="form-label">이름</label>
                         <input type="text" class="form-control" name="mb_name" value="<?php echo $user->mb_name; ?>">
                    </div>
                    <div class="form-group">
                         <label for="mb_name" class="form-label">현제비밀번호</label>
                         <div class="input-group">
                              <input type="password" class="form-control" name="" id="current_pass" value="">
                              <div class="append">
                                   <a href="" id="change_pass" class="btn light">
                                        확인
                                   </a>
                              </div>
                         </div>
                    </div>
                    <div class="form-group">
                         <label for="mb_name" class="form-label" >새 비밀번호</label>
                         <input type="password" class="form-control" id="new_pass" disabled name="mb_password" value="">
                    </div>
                    <div class="form-group">
                         <label for="mb_name" class="form-label">새 비밀번호 확인</label>
                         <input type="password" class="form-control"  id="new_pass_check" disabled name="mb_password_re" value="">
                    </div>

          </div>
          <div class="modal_footer">
               <div class="row">
                    <div class="col-6">
                         <button class="btn wide primary" type="submit" name="button">
                              확인
                         </button>
                    </div>
                    <div class="col-6">
                         <button data-close="edit" class="btn wide ghost" type="button" name="button">
                              취소
                         </button>
                    </div>
               </div>


          </div>
          </form>
     </div>
</div>
<script type="text/javascript">

     $('#change_pass').on('click',function(event) {
          var $this = $(this)
          event.preventDefault();
          var current_pass = $('#current_pass').val();
          $.ajax({
               type: "POST",
               data: {'mb_password':current_pass},
               url: "/home/check_current_pass",
               cache: false,
               dataType:'json',
               success: function (data) {
                    console.log(data === 1);
                    if (data === 1) {
                         $('#new_pass_check,#new_pass').removeAttr('disabled');
                         $('#pass_will_change').val(1);
                    }else if (data === 0) {
                         window.alert('비밀번호  일치하지 않습니다.')
                    }
               }
          });
          return false;

     })
     $('[data-close]').on('click', function(event) {
          event.preventDefault();

          $('#'+$(this).data('close')).removeClass('show')
     })
</script>
<script type="text/javascript">
     $('#edit_profile').on('click',function(event){
          event.preventDefault();
          $('#edit').addClass('show')
     })


     var chart = $('#myChart');
     var myChart = new Chart(chart, {
          defaultFontColor: '#687992',
         type: 'bar',
         data: {
             labels: <?php echo json_encode($date); ?>,
             datasets: [
                  {
                       label: '성공',
                       data: <?php echo json_encode($success); ?>,
                       backgroundColor: ' #2dce89',
                       borderWidth: 1
                  },
               {
                    label: '실패',
                    data: <?php echo json_encode($fail); ?>,
                    backgroundColor: '#f5365c',
                    borderWidth: 1
               },

               ]
         },
         options: {
              legend:{
                   display: false,
              },
              tooltips: {
						mode: 'index',
						intersect: false,
                              bodySpacing: 4,
					},
             scales: {
                 yAxes: [{
                      stacked: true,
                      ticks: {
                           beginAtZero: true,
                           fontColor: '#687992',
                      },
                      gridLines: {
                           borderDash: [2],
                           borderDashOffset: 2,
                           drawBorder: false,
                           zeroLineWidth:0,
                      },
                }],
                xAxes: [{
                     stacked: true,
                     maxBarThickness: 10,
                     gridLines: {
                          display: false,
                          drawBorder: false,
                     },
                     ticks:{
                          fontColor: '#687992',
                     }
                }]
           },
         }
     });

</script>