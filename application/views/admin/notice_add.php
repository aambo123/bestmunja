<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script>
<div class="page-content">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo base_url(); ?>admin">Admin</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <span>공지사항 더하다</span>
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
                        <span class="caption-subject font-green sbold uppercase">공지사항 더하다</span>
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body form ">
                    <br>
                    <form class="" action="<?php echo base_url(); ?>admin/noticeSave" method="post">


                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">

                                <label class="my-2" for="id">표제</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">

                                <input class="form-control sett" type="text" name="title" id="title" value="<?php if(isset($_POST['title'])){ echo "".$_POST['title'].""; }?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('title');
                                echo "</span>";
                                ?>
                            </div>
                            <div class="col-12 col-sm-3 flex align-center">

                            </div>
                        </div>
                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">

                                <label class="my-2" for="id">사용 상태</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">

                                <input class="form-control sett" type="checkbox" name="use_yn" id="use_yn" value="1" checked >
                                
                            </div>
                            <div class="col-12 col-sm-3 flex align-center">

                            </div>
                        </div>
                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">

                                <label class="my-2" for="id">함유량</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">

                                <textarea id="summernote" name="content" value="<?php if(isset($_POST['content'])){ echo "".$_POST['content'].""; }?>" required ></textarea>
                            </div>
                            <div class="col-12 col-sm-3 flex align-center">

                            </div>
                        </div>  
                        <div class="form-group row">
                            <div class="col-12 col-sm-3">

                            </div>
                            <div class="col-12 col-sm-6 text-right">

                                <button type="submit" class="btn btn-success mr-2" id="submit" name="button" >저장</button>
                                <a href="/admin/notice" class="btn dark" name="button" >취소</a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>

    <script>
      $('#summernote').summernote({
        placeholder: '귀하의 콘텐츠는 여기에 있습니다',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    </script>
</div>