<div class="page">
     <div class="container">
          <div class="row">
               <div class="col-sm-4">
                    <h1 class="h1 mb-3">발송 상세</h1>
               </div>
               <div class="col-sm-5 ml-auto">
                    <div class="search_box">
                         <div class="input-group">
                              <span class="prepend">
                                   <i class="fa fa-search"></i>
                              </span>
                              <input type="text" name="" value="" class="form-control search round" placeholder="검색">
                         </div>
                         <ul class="result">
                         </ul>
                    </div>
               </div>
               <div class="col-sm-12">
                    <div class="message_detail_top card">
                         <div class="message_info">
                              <p class="filter" data-filter="">발송 <span class="txt-primary bold"><?php echo $message_detail->quantity;?></span></p>
                              <p class="filter" data-filter=".success">성공 <span class="txt-green bold"><?php echo $message_detail->delivered_count;?></span></p>
                              <!-- <p class="filter" data-filter=".info">대기 <span class="txt-teal bold"><?php echo $message_detail->pending_count;?></span></p> -->
                              <p class="filter" data-filter=".danger">실패 <span class="txt-red bold"><?php echo $message_detail->error_count;?></span></p>
                              <!-- <p class="filter" data-filter=".warning">확인불가 <span class="txt-yellow bold"><?php echo $message_detail->error_count;?></span></p> -->
                              <p>문자: <?php echo $message_detail->split_count ?> </p>
                         </div>
                         <span class="time"><?php echo $message_detail->created_date; ?></span>
                         <h1 class="message"> <?php echo $message_detail->message; ?></h1>

                    </div>

                    <ul class="recipient-list grid mt-4">
                       <?php

                       foreach ($numbers as $nb){
                         

                           if ($nb->success == 3) {
                                echo '<li class="grid-item danger"><div class="status danger">';
                                echo '<span class=number>' . $nb->phone_number . '</span>';
                               echo '<span class="status-label danger">실패</span>';
                          } elseif($nb->success == 0){
                                echo '<li class="grid-item info"><div class="status info">';
                                echo '<span class=number>' . $nb->phone_number . '</span>';
                               echo '<span  class="status-label info">대기</span>';
                          } elseif($nb->success == 2){
                                echo '<li class="grid-item warning"><div class="status warning">';
                                echo '<span class=number>' . $nb->phone_number . '</span>';
                               echo '<span class="status-label warning">확인불가</span>';
					 } elseif($nb->success == 1) {
                                echo '<li class="grid-item success"><div class="status success">';
                                echo '<span class=number>' . $nb->phone_number . '</span>';
                               echo '<span class="status-label success">성공</span>';
                           }
                           echo '</div></li>';
                       }
                       ?>
                   </ul>
                   <?php echo $pagination; ?>
               </div>
          </div>
     </div>
</div>
<script type="text/javascript">
     $('.grid').isotope({
     // options
     itemSelector: '.grid-item',
     masonry: {
          gutter: 20
     }
     });
     $('.filter').on('click',function(){
          var filterBy = $(this).data('filter');
          $('.grid').isotope({ filter: filterBy });
     })
     var val;
     $('.search').on('keyup',function(){
          val = $(this).val();
          var id = '<?php echo $message_detail->id; ?>';
          $('.result').empty();
          $('.grid').isotope()
          if (val) {
               $.ajax({
                         url: '/users/SmsRequestPhoneSearch',
                         type: "POST",
                         data: {
                              'msg_id': id,
                              'search': val,
                         },
                         success: function(data){
                              data = $.parseJSON(data)
                              for (var i = 0; i < data.length; i++) {
                                   var result = data[i].phone_number;
                                   var temp = '<li class=rec data-text='+result+'>'+result+'</li>';
                                   $('.result').append(temp)
                                   $(".result li:contains("+val+")").html(function(_, html) {
                                        return html.split(val).join("<span class='bold'>"+val+"</span>");
                                   });
                              }
                         }
                    })
          }

     })
     $('.search').keypress(function(event){
          var keycode = (event.keyCode ? event.keyCode : event.which);
          if(keycode == '13'){
               $('.grid-item').show();
               $('.grid').isotope()
               if (val) {
                    $('.grid').isotope({
                      // filter element with numbers greater than 50
                      filter: function() {
                        // _this_ is the item element. Get text of element's .number

                        // return true to show, false to hide
                        return $(this).is(':contains('+val+')');
                      }
                    })
                    // $('.grid-item').hide();
                    // var selected =  $('.number:contains('+val+')').closest('.grid-item').show()
                    // $('.grid').isotope();
               }

          }
     });
     $(document).on('click','.rec',function(event){
          var txt = $(this).data('text');
          $('.search').prop('value',txt)
     })
     $(document).on('click',function(event){
          var asd = $(event.target).closest('.result').length
          console.log(asd);
          if (asd == 0) {
               $('.result').empty()
          }
     })
</script>
