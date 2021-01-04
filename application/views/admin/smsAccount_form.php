<div class="page-content">


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo base_url(); ?>admin">Admin</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <span>SMS 계정</span>
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
                        <span class="caption-subject font-green sbold uppercase">연동 설정</span>
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body form ">
                    <br>
                    <?php if ($uildel == 'add'): ?>
                         <form class="" action="<?php echo base_url(); ?>admin/smsAccount/save/0" method="post">
                    <?php elseif($uildel == 'edit'): ?>
                         <form class="" action="<?php echo base_url(); ?>admin/smsAccount/update/<?php echo $account->id;?>" method="post">
                    <?php endif; ?>
                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">

                                <label class="my-2" for="id">API 모듈</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                 <div class="custom_checkbox_group">
                                      <?php foreach ($api as $key): ?>
                                          <label>
                                               <input type="radio" class="custom_checkbox" name="api_name" value="<?php echo $key->id ?>"
                                                  <?php if ($account!=null && $key->id == $account->name): ?>
                                                       checked
                                                  <?php endif; ?>
                                               >
                                               <span>
                                                    <h5><?php echo $key->name ?></h5>
                                                    <p><?php echo $key->send_url ?></p>
                                               </span>
                                          </label>
                                     <?php endforeach; ?>
                                 </div>
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('api_name');
                                echo "</span>";
                                ?>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="id">
                                     <?php foreach ($api as $key): ?>
                                          <span data-api='username'>
                                               <?php echo $key->username ?>
                                          </span>
                                     <?php endforeach; ?>
                                     <span data-api='username'>
                                          username placeholder
                                     </span>
                                </label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input class="form-control sett" type="text" name="z_id" id="z_id" required
                                     value="<?php if(isset($_POST['z_id'])){
                                                echo "".$_POST['z_id']."";
                                           }elseif($account != null) {
                                                echo $account->username;
                                           }?>">
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('z_id');
                                echo "</span>";
                                ?>
                            </div>
                            <div class="col-12 col-sm-3 flex align-center">

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="password">
                                     <?php foreach ($api as $key): ?>
                                          <span data-api='password'>
                                               <?php echo $key->password ?>
                                          </span>
                                     <?php endforeach; ?>
                                     <span data-api='password'>
                                          username placeholder
                                     </span>
                                </label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">

                                <input class="form-control sett" type="text" name="z_password" id="z_password" required
                                value="<?php if(isset($_POST['z_password'])){
                                           echo "".$_POST['z_password']."";
                                      }elseif($account != null) {
                                           echo $account->password;
                                      }?>">
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('z_password');
                                echo "</span>";
                                ?>
                            </div>
                            <div class="col-12 col-sm-3 flex align-center">


                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="msg_limit">MSG limit</label>
                            </div>
                            <div class="col-12 col-sm-6">

                                <input class="form-control sett" type="text" name="msg_limit" id="msg_limit" value="">
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('msg_limit');
                                echo "</span>";
                                ?>
                            </div>
                            <div class="col-12 col-sm-3 flex align-center">


                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12 col-sm-3">

                            </div>
                            <div class="col-12 col-sm-6 text-right">

                                <button type="submit" class="btn btn-success mr-2" id="submit" name="button" >저장</button>
                                <a href="<?php echo base_url() ?>admin/smsAccount_list" class="btn dark" name="button" >취소</a>

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
         var $a =[];
         $(document).ready(function() {
              $('[data-api]').each(function() {
                   var data = $(this).data('api')
                   if (jQuery.inArray(data, $a) == -1) {
                        $a.push($(this).data('api'));
                   }
              });
              if ($('input[name=api_name]:checked').length == 0) {
                   for (var i = 0; i < $a.length; i++) {
                       $el = $a.length +1;
                       $('[data-api='+$a[i]+']').not($('[data-api='+$a[i]+']')[$el]).hide()
                  }
             }else {
                  for (var i = 0; i < $a.length; i++) {
                       $el = $('input[name=api_name]').index($('input[name=api_name]:checked'));
                       $('[data-api='+$a[i]+']').not($('[data-api='+$a[i]+']')[$el]).hide()
                  }
             }

         });
         $('input[name=api_name]').on('change', function(event) {
              console.log($a);
              var index = $('input[name=api_name]').index($(this));
              for (var i = 0; i < $a.length; i++) {
                   $('[data-api='+$a[i]+']').show();
                   $('[data-api='+$a[i]+']').not($('[data-api='+$a[i]+']')[index]).hide()
              }
              console.log();
         })



        // $('#user_name').mask('KKK',{'translation': {
        //           K : {pattern: /[\u3131-\uD79DA-Za-z]/},
        //      }
        // })
    </script>
</div>
