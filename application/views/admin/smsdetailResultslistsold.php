<div class="page-content">


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo base_url(); ?>admin">Admin</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <span>발송 결과</span>
            </li>
        </ul>

    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="" id="msg_count_today"><img src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="15" style="z-index: 999;"></span>
                    </div>
                    <div class="desc"> 오늘의 총 문자 </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="" id="msg_count_month"><img src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="15" style="z-index: 999;"> </span> </div>
                    <div class="desc"> 이번달의 총 문자 </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                <div class="visual">
                    <i class="icon-bar-chart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="" id="msg_count_all"><img src="<?php echo base_url(); ?>/assets/src/images/loading.gif" width="15" style="z-index: 999;"></span>
                    </div>
                    <div class="desc"> 총 문자 </div>
                </div>
            </a>
        </div>
        <script>
            $(document).ready(function() {
                var id = 0;
                $.ajax({
                    type: 'POST',
                    url: '/home/all_msg_count',
                    dataType: "JSON",
                    async: true,
                    data: {
                        msg_id: id
                    },
                    success: function(data) {
                        console.log(data.msg_count_all);
                        $('#msg_count_all').html(data.msg_count_all);
                        $('#msg_count_month').html(data.msg_count_month);

                        $('#msg_count_today').html(data.msg_count_today);
                    }

                });
            });
        </script>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-info font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">발송 결과</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
<!--                        <a href="--><?php //echo base_url(); ?><!--admin_panel/banner/add" class="btn btn-success btn-sm">-->
<!--                            <i class="glyphicon glyphicon-plus"></i> New-->
<!--                        </a>-->

                        </div>
                    </div>
                </div>
                <div class="portlet-body " id="table_id">
                     <div class="searchby">
                          <form class=""  action="<?php echo base_url() ?>admin/sms_search" method="post">
                               <div class="row">
                                    <div class="col-sm-2">
                                         <input type="text" class="form-control" name="user_id" placeholder="회원아이디"
                                         value="<?php echo $this->session->userdata('search_user_id'); ?>">
                                    </div>
                                    <div class="col-sm-3">
                                         <?php $date = $this->session->userdata('search_date');?>
                                         <?php if ($this->session->userdata('search_date') != null){
                                              $date = $this->session->userdata('search_date');
                                         } else {
                                              $date = '';
                                         }?>


                                         <input type="text"
                                                  name="date"
                                                  class="datepicker-here form-control"
                                                  data-language='kr'
                                                  data-range="true"
                                                  data-multiple-dates-separator="~"
                                                  placeholder="발송일"
                                                  autocomplete="off"
                                                  value="<?php if ($date != null && $date[0] != null) {
                                                       echo $date[0].'~'.$date[1];
                                                  } ?>">
                                   </div>

                                   <div class="col-sm-6">
                                        <button type="submit" class="btn blue">
                                             <i class="icon-magnifier"></i>검색
                                        </button>
                                        <a type="reset" class="btn blue btn-outline" href="<?php echo base_url() ?>admin/sms_results">
                                             <i class="icon-refresh"></i>초기화
                                        </a>
                                   </div>
                               </div>
                          </form>
                     </div>

                <div class="table-scrollable table-scrollable-borderless">
                    <table class="table table-striped  table-light" >
                        <thead>
                        <tr style="text-align: left;">
                            <th width="5%">번호</th>
                            <th width="10%">회원아이디</th>
                            <th width="13%">발신번호</th>
                            <th width="">SMS count</th>
                            <th width="20%">메시지</th>
                            <th width="7%">발송</th>
                            <th width="7%">성공</th>
                            <!-- <th width="7%">대기</th>
                            <th width="7%">확인불가</th> -->
                            <th width="7%">실패</th>
                            <th width="10%">등록일</th>
                            <th width="10%">Action</th>

                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        <?php
                        $count = $countstart;
                        foreach ($sms_results as $row){ $count++;
                            $member = $this->users_model->get_user_one($row->member_id);

                            ?>
                            <tr data-id="<?php echo $row->id ?>">
                                <th><?php echo $count; ?>
                                     <?php
                                          $datetime1 = date_create($row->created_date);
                                          $datetime2 = date_create(date("Y-m-d"));
                                          $interval = date_diff($datetime1, $datetime2);
                                          if ($interval->format('%a') < 7 ) {?>
                                          <input class="send_request" type="hidden" name="" value="<?php echo $row->id ?>">
                                     <?php }; ?></th>
                                <td><a href="<?php echo base_url(); ?>admin/sms_detail/<?php echo $row->id; ?>"><?php if($member != null){ echo $member->mb_id;}else{ echo "삭제 된 사용자";} ?></a></td>
                                <td><a href="<?php echo base_url(); ?>admin/sms_detail/<?php echo $row->id; ?>"><?php echo $row->sender; ?></a></td>
                                <td><?php echo $row->split_count; ?></td>
                                <td><?php echo $row->message; ?></td>
                                <td> <span id="total<?php echo $row->id; ?>"><?php echo $row->quantity; ?></span> 건</td>
                                <td class="success"> <span  id="successmsg<?php echo $row->id; ?>"> <?php echo $row->delivered_count; ?></span> 건</td>
                                <td class="danger"> <span  id="errormsg<?php echo $row->id; ?>"><?php echo $row->error_count; ?></span> 건</td>
                                <td> <?php echo $row->created_date; ?></td>
                                <td><a href="<?php echo base_url(); ?>admin/sms_detail/<?php echo $row->id ?>" class="btn btn-sm blue-hoki">
                                        <i class="icon-paper-plane"></i> 발송 상세
                                    </a>

                                </td>

                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </div>

                <?php echo $pagination; ?>
            </div>
            </div>
        <!-- END PORTLET-->
        </div>
    </div>

<script>
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);

    });
    $( window ).on('load',function() {
         requestResult();
         setInterval(function(){
              count++;
              if (!stop) {
                   requestResult()
              }
         }, 5000);
    });
    var count = 0;
    var stop = false;
    function requestResult() {
         var $data = [];
         $el = $('.send_request');
         if ($el.length>0) {
              for (var i = 0; i < $el.length; i++) {
                   $data.push($el.eq(i).val())
              };
              $.ajax({
                   url: '/users/get_detail_new',
                   type: "POST",
                   async: true,
                   cache: false,
                   data: {
                        id:$data,
                   },
                   success: function(result){
                        if (result == 0) {
                             stop = true;
                        } else {
                             result = $.parseJSON(result);
                             for (var j = 0; j < result.length; j++) {
                                  id = parseInt(result[j].message_id);
                                  $('tr[data-id='+id+']').find('.success span').text(result[j].delivered_count);
                                  $('tr[data-id='+id+']').find('.danger span').text(result[j].error_count);
                             };
                        }


                   }
              })
         }


    };
</script>
</div>
