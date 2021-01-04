
<ul class="side-nav ">
     <?php if($this->session->userdata('user_level') == 'Reseller') { ?>
         <li class="nav-item <?php if($current == 'users'){ echo "active";} ?>">
              <a href="<?php echo base_url(); ?>admin/" class="nav-link ">
                   <i class="material-icons">person</i>
                   <span class="ml-1 bold"> 회원관리</span>
              </a>

         </li>
         <li class="nav-item <?php if($current == 'settings'){ echo "active";} ?>">
              <a href="<?php echo base_url(); ?>admin/edit" class="nav-link">
                   <i class="material-icons">settings</i>
                   <span class="ml-1 bold"> 관리자정보설정</span>
              </a>
         </li>
     <?php }else{?>
         <li class="ml-2">
             <a href="#" class="nav-link ">
                 <i class="material-icons">person</i>
                 <span class="ml-1 bold "> <?php echo $this->session->userdata('user_name'); ?> 님 안녕하세요</span>
             </a>

         </li>
        <li class="nav-item active">
            <a href="<?php echo base_url(); ?>users" class="nav-link ">
                <i class="material-icons">email</i>
                <span class="ml-1 bold"> sms send</span>
            </a>

        </li>
     <?php }?>
</ul>
