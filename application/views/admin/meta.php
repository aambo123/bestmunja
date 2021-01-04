<div class="page-content">


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo base_url(); ?>admin">Admin</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <span>meta</span>
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
                        <span class="caption-subject font-green sbold uppercase">meta 설정</span>
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body form ">
                    <br>
                    <form class="" action="<?php echo base_url(); ?>admin/meta_update" method="post" enctype="multipart/form-data">
                         <input type="hidden" name="old_image" value="<?php echo $meta->image ?>">
                         <div class="form-group row ">
                             <div class="col-12 col-sm-3 text-right">

                                 <label class="my-2" for="id">웹사이트 이름</label>
                                 <span class="font-red-mint bold">*</span>
                             </div>
                             <div class="col-12 col-sm-6">
                                 <input class="form-control " type="text" name="site_name" value="<?php echo $meta->site_name ?>" required >
                                 <?php
                                 echo "<span style='color: #ff0000; font-size: 11px;'>";
                                 echo form_error('site_name');
                                 echo "</span>";
                                 ?>
                             </div>
                         </div>
                         <div class="form-group row ">
                             <div class="col-12 col-sm-3 text-right">

                                 <label class="my-2" for="id">웹사이트 제목</label>
                                 <span class="font-red-mint bold">*</span>
                             </div>
                             <div class="col-12 col-sm-6">
                                 <input class="form-control " type="text" name="website_title" value="<?php echo $meta->website_title ?>" required >
                                 <?php
                                 echo "<span style='color: #ff0000; font-size: 11px;'>";
                                 echo form_error('website_title');
                                 echo "</span>";
                                 ?>
                             </div>
                         </div>
                         <div class="form-group row ">
                             <div class="col-12 col-sm-3 text-right">

                                 <label class="my-2" for="id">웹사이트 설명</label>
                                 <span class="font-red-mint bold">*</span>
                             </div>
                             <div class="col-12 col-sm-6">
                                 <input class="form-control " type="text" name="description" value="<?php echo $meta->description ?>" required >
                                 <?php
                                 echo "<span style='color: #ff0000; font-size: 11px;'>";
                                 echo form_error('description');
                                 echo "</span>";
                                 ?>
                             </div>
                         </div>
                         <div class="form-group row ">
                             <div class="col-12 col-sm-3 text-right">

                                 <label class="my-2" for="id">검색어</label>
                                 <span class="font-red-mint bold">*</span>
                             </div>
                             <div class="col-12 col-sm-6">
                                 <input class="form-control " type="text" name="keywords" value="<?php echo $meta->keywords ?>" required >
                                 <?php
                                 echo "<span style='color: #ff0000; font-size: 11px;'>";
                                 echo form_error('keywords');
                                 echo "</span>";
                                 ?>
                             </div>
                         </div>

                         <div class="form-group row ">
                             <div class="col-12 col-sm-3 text-right">

                                 <label class="my-2" for="id">작선자</label>
                                 <span class="font-red-mint bold">*</span>
                             </div>
                             <div class="col-12 col-sm-6">
                                 <input class="form-control " type="text" name="author" value="<?php echo $meta->author ?>" required >
                                 <?php
                                 echo "<span style='color: #ff0000; font-size: 11px;'>";
                                 echo form_error('author');
                                 echo "</span>";
                                 ?>
                             </div>
                         </div>
                         <?php if ($meta->image != null): ?>
                              <div class="form-group row ">
                                  <div class="col-12 col-sm-3 text-right">
                                      <label class="my-2" for="id">사진</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                       <img src="<?php echo base_url() ?>upload/meta/<?php echo $meta->image ?>" alt="" style="width:100%">
                                  </div>
                              </div>
                         <?php endif; ?>
                         <div class="form-group row ">
                             <div class="col-12 col-sm-3 text-right">

                                 <label class="my-2" for="id">사진 변경</label>
                                 <span class="font-red-mint bold">*</span>
                             </div>
                             <div class="col-12 col-sm-6">

                                 <input class=" " type="file" name="image" value="<?php echo $meta->image ?>" >
                                 <?php
                                 echo "<span style='color: #ff0000; font-size: 11px;'>";
                                 echo form_error('image');
                                 echo "</span>";
                                 ?>
                             </div>
                         </div>
                         <div class="form-group row ">
                             <div class="col-12 col-sm-3 text-right">
                                 <label class="my-2" for="id">url</label>
                                 <span class="font-red-mint bold">*</span>
                             </div>
                             <div class="col-12 col-sm-6">
                                 <input class="form-control " type="url" name="url" value="<?php echo $meta->url ?>">
                                 <?php
                                 echo "<span style='color: #ff0000; font-size: 11px;'>";
                                 echo form_error('url');
                                 echo "</span>";
                                 ?>
                             </div>
                         </div>
                         <div class="form-group row">
                             <div class="col-12 col-sm-3">

                             </div>
                             <div class="col-12 col-sm-6 text-right">

                                 <button type="submit" class="btn btn-success mr-2" id="submit" name="button" >저장</button>
                                 <a href="/admin" class="btn dark" name="button" >취소</a>

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
</div>
