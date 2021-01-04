<div class="page-content">

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo base_url(); ?>admin">Admin</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <span>report</span>
            </li>
        </ul>

    </div>
    <div class="row">
        <div class="col-lg-4 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                     <div class="caption">
                         <i class="icon-bar-chart font-dark hide"></i>
                         <span class="caption-subject font-dark bold uppercase">문자 발송</span>
                         <span class="caption-helper" id="type">일별 통계...</span>
                     </div>
                    <ul class="nav nav-tabs" id="changeView">
                        <li  class="active">
                            <a href="#day" data-toggle="tab" data-search="day"> 일별 </a>
                        </li>
                        <li>
                            <a href="#month" data-toggle="tab" data-search="month"> 월별 </a>
                        </li>
                    </ul>

                </div>
                <div class="portlet-body">

                     <div class="tab-content">
                          <div class="padding-tb-1 ">
                            <h2 class="pull-left no-margin margin-bottom-30" data-date="current"><?php echo date('Y-m') ?></h2>
                            <div class="btn-group pull-right">
                                 <button type="button" class="btn btn-circle btn-icon-only btn-default" onclick="changeMonth(-1)" name="button">
                                      <i class="fa fa-angle-left"></i>
                                 </button>
                                 <button type="button" class=" btn btn-circle btn-icon-only btn-default" onclick="changeMonth(1)" name="button">
                                      <i class="fa fa-angle-right"></i>
                                 </button>
                            </div>

                        </div>
                          <div class="tab-pane active" id="day">

                          </div>
                          <div class="tab-pane" id="month">

                          </div>
                     </div>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
        <div class="col-lg-8 col-xs-12 col-sm-12">
             <div class="portlet light bordered">
                 <div class="portlet-title tabbable-line">
                      <div class="caption">
                          <i class="icon-bar-chart font-dark hide"></i>
                          <span class="caption-subject font-dark bold uppercase">운영체제 , 브라우저</span>
                          <span class="caption-helper">접속 통계...</span>
                      </div>
                      <!-- <ul class="nav nav-tabs" id="changeDevice">
                          <li >
                              <a href="#mobile" data-toggle="tab" data-search="mobile"> mobile </a>
                          </li>
                          <li  class="active">
                              <a href="#pc" data-toggle="tab" data-search="pc"> pc </a>
                          </li>
                      </ul> -->
                 </div>
                 <div class="portlet-body" id="referrer">
                      <div class="table-scrollable table-scrollable-borderless">

                           <table class="table table-hover table-light">
                                <thead>
                                     <tr class=" uppercase font-grey-salt">
                                          <th>*</th>
                                          <th>소스</th>
                                          <th>접속자</th>
                                          <th>%</th>
                                     </tr>
                                </thead>
                                <tbody>
                                     <?php
                                          $co = 0;
                                          foreach ($referral as $refs){
                                               $co++;
                                     ?>
                                          <tr>
                                               <td class="bold"><?php echo $co ?></td>
                                               <td><?php echo $refs->referrer; ?>

                                                   <?php

                                                   ?>
                                               </td>
                                               <td><?php echo $refs->count; ?></td>
                                               <td>
                                                    <?php
                                                       echo substr(($refs->count * 100)/$total,0,4).'%';
                                                    ?>
                                               </td>
                                          </tr>
                                     <?php } ?>
                                </tbody>
                           </table>
                      </div>

                 </div>
             </div>
             <div class="portlet light bordered">
                 <div class="portlet-title tabbable-line">
                      <div class="caption">
                          <i class="icon-bar-chart font-dark hide"></i>
                          <span class="caption-subject font-dark bold uppercase">운영체제 , 브라우저</span>
                          <span class="caption-helper">접속 통계...</span>
                      </div>
                      <!-- <ul class="nav nav-tabs" id="changeDevice">
                          <li >
                              <a href="#mobile" data-toggle="tab" data-search="mobile"> mobile </a>
                          </li>
                          <li  class="active">
                              <a href="#pc" data-toggle="tab" data-search="pc"> pc </a>
                          </li>
                      </ul> -->
                 </div>
                 <div class="portlet-body" >
                           <div class="row">
                                <div class="col-sm-6">
                                     <canvas id="chartBy0" width="100%"></canvas>
                                </div>
                                <div class="col-sm-6">
                                     <canvas id="chartBy1" width="100%"></canvas>
                                </div>
                           </div>
                 </div>
             </div>
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                     <div class="caption">
                         <i class="icon-bar-chart font-dark hide"></i>
                         <span class="caption-subject font-dark bold uppercase">Site Visits</span>
                         <span class="caption-helper">weekly stats...</span>
                     </div>
                     <!-- <ul class="nav nav-tabs" id="changeDevice">
                         <li >
                             <a href="#mobile" data-toggle="tab" data-search="mobile"> mobile </a>
                         </li>
                         <li  class="active">
                             <a href="#pc" data-toggle="tab" data-search="pc"> pc </a>
                         </li>
                     </ul> -->
                </div>
                <div class="portlet-body" id="test">
                     <canvas id="myChart" width="100%"></canvas>
                </div>
            </div>


            <!-- END PORTLET-->
        </div>
    </div>
<?php $today = date('Y-m-d');?>
<script type="text/javascript">
     $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);
     });
     var type;
     var thisDate =  moment().format("YYYY-MM");
     $(document).ready(function() {
          type = $("ul#changeView li.active a").data('search')
          repTable(thisDate,type)
     });
     $('a[data-toggle=tab]').on('click', function(event) {
          $('#type').text($(this).text()+'...')
          type = $(this).data('search');
          type == 'day'?  thisDate = moment(thisDate).format("YYYY-MM") : thisDate = moment(thisDate).format("YYYY");
          repTable(thisDate,type)
     })
     function changeMonth(a){
          type == 'day'?  thisDate = moment(thisDate).add(a,'month').format("YYYY-MM") : thisDate = moment(thisDate).add(a,'year').format("YYYY");
          repTable(thisDate,type);
     }
     function repTable($date,type){
          $.ajax({
               type: "POST",
               data: {date:$date},
               url: '/admin/get_'+type+'_report_table',
               cache: false,
               dataType:'html',
               success: function ($response) {
                    var target = document.getElementById(type)
                    $(target).empty();
                    $(target).html($response);
                    $('[data-date=current]').text($date)
               }
          })
     }
     window.chartColors = {
          red: 'rgb(255, 99, 132)',
          orange: 'rgb(255, 159, 64)',
          yellow: 'rgb(255, 205, 86)',
          green: 'rgb(75, 192, 192)',
          blue: 'rgb(54, 162, 235)',
          purple: 'rgb(153, 102, 255)',
          grey: 'rgb(201, 203, 207)'
     };
     function addData(chart,label,data)
     {
          chart.data.labels.push(label);
          chart.data.datasets.forEach((dataset) => {
               dataset.data.push(data);
          });
          chart.update();
     };

     var chart = $('#myChart');
     var myChart;
     get_visit()
     function get_visit(){
          $.ajax({
               type: "POST",
               data: {date:thisDate},
               url: '/admin/get_traffic',
               cache: false,
               dataType:'html',
               success: function ($response) {

                    $response = JSON.parse($response);
                    var $labels = [];
                    for (var i = 0; i < 7; i++) {
                         $labels.push(moment().subtract(i,'days').format("YYYY-MM-DD"))
                    };
                    var data_by = $response.result_by;
                    for (var i = 0; i < data_by.length; i++) {
                          new Chart($('#chartBy'+i+''), {
                             type: 'pie',
                             data: {
               				datasets: [{
               					data: data_by[i].count,
               					backgroundColor: [
               						window.chartColors.red,
               						window.chartColors.orange,
               						window.chartColors.yellow,
               						window.chartColors.green,
               						window.chartColors.blue,
               					],
               				}],
               				labels: data_by[i].list
               			},
               			options: {
               				responsive: true,
                                   title: {
                                          display: true,
                                          text: i != 1 ? '운영체제':'브라우저',
                                     },
                                     legend : {
                                          position: 'right'
                                     }
               			}
                         });
                    }

                    var myChart = new Chart(chart, {
                        type: 'line',
                        data: {
                            labels: $labels.reverse(),
                            datasets:[{
                                label: 'pc',
                                data: $response.pc,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                           },
                           {
                               label: 'mobile',
                               data: $response.mobile,
                               backgroundColor: 'rgba(54, 162, 235, 0.2)',
                               borderColor: 'rgba(54, 162, 235, 1)',
                               borderWidth: 1
                           }],
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                           },
                           elements : {
                                line : {
                                     bezierCurve : false
                                }
                           }
                        }
                    });
               }
          })
     }
     // function get_referral(){
     //      $.ajax({
     //           type: "POST",
     //           data: {date:thisDate},
     //           url: '/admin/get_traffic',
     //           cache: false,
     //           dataType:'html',
     //           success: function ($response) {}
     //      });
     // }
    </script>
</div>
