<?php echo $header; ?>
<div class="container-fluid bg-grey-180 ">
     <div class="row py-1">
          <div class="col-2 ">
               <h5 class="bold txt-center">SMS Control Panel</h5>
          </div>
          <a href="<?php echo base_url(); ?>home/logout" class="btn outline ghost ml-auto mr-2" name="button">logout</a>
     </div>
</div>
<div class="flex">
          <aside class="bg-grey-170">
               <?php echo $menu; ?>
          </aside>
          <main class="flex-fill">
               <?php echo $content; ?>



<?php echo $footer; ?>
