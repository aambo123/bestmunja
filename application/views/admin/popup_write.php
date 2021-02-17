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
                <span>팝업 등록</span>
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
                        <span class="caption-subject font-green sbold uppercase">팝업 등록</span>
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body form ">
                    <br>
                    <form class="" action="<?php echo base_url(); ?>admin/popup_proc" method="post">
                        <input type="hidden" name="popup_seq" value="<?php echo $vo != ''?$vo->popup_seq:'';?>">
                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="subject">제목</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input class="form-control" type="text" name="subject" id="subject" value="<?php if(isset($_POST['subject'])){ echo "".$_POST['subject'].""; }else{ echo $vo != ""?$vo->subject:"";} ?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('subject');
                                echo "</span>";
                                ?>
                            </div>
                        </div>
                        

                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2" for="link_url">link</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input class="form-control" type="text" name="link_url" id="link_url" value="<?php if(isset($_POST['link_url'])){ echo "".$_POST['link_url'].""; }else{ echo $vo != ""?$vo->link_url:"";} ?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('link_url');
                                echo "</span>";
                                ?>
                            </div>
                        </div>
                        
                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2">link</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-3">
                                <input class="form-control datepicker-here" type="text" name="start_dt"
                                data-language='kr' data-range="false" placeholder="2021-01-01"
                                autocomplete="off"
                                value="<?php if(isset($_POST['start_dt'])){ echo "".$_POST['start_dt'].""; }else{ echo $vo != ""?$vo->start_dt:"";} ?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('start_dt');
                                echo "</span>";
                                ?>
                            </div>
                            <div class="col-12 col-sm-3">
                                <input class="form-control datepicker-here" type="text" name="end_dt"
                                data-language='kr' data-range="false" placeholder="2021-01-01"
                                autocomplete="off"
                                value="<?php if(isset($_POST['end_dt'])){ echo "".$_POST['end_dt'].""; }else{ echo $vo != ""?$vo->end_dt:"";} ?>" required >
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('end_dt');
                                echo "</span>";
                                ?>
                            </div>
                        </div>
                        
                        <div class="form-group row ">
                            <div class="col-12 col-sm-3 text-right">
                                <label class="my-2">body</label>
                                <span class="font-red-mint bold">*</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <textarea class="form-control" type="text" name="body" id="body" required >
                                
                                <?php if(isset($_POST['body'])){ echo "".$_POST['body'].""; }else{ echo $vo != ""?$vo->body:"";} ?>
                                </textarea>
                                <?php
                                echo "<span style='color: #ff0000; font-size: 11px;'>";
                                echo form_error('body');
                                echo "</span>";
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12 col-sm-3">

                            </div>
                            <div class="col-12 col-sm-6 text-right">
                                <button type="submit" class="btn btn-success mr-2" id="submit" name="button" >저장</button>
                                <a href="/admin/popup" class="btn dark" name="button" >취소</a>
                            </div>
                        </div>

                    </form>


                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/froala/js/froala_editor.min.js" ></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/froala/js/languages/ko.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/froala/js/plugins/image.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/froala/js/plugins/image_manager.min.js"></script>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
    <script>
       $('#body').froalaEditor({
                imageDefaultWidth: 900,
                height: 300,
                language: 'ko',
                imageUploadParam: 'image',
                imageUploadURL: '<?php echo base_url(); ?>admin/popup_upload',
                imageUploadParams: {id: 'my_editor'},
                imageUploadMethod: 'POST',
                imageMaxSize: 5 * 1024 * 1024,
                imageAllowedTypes: ['jpeg', 'jpg', 'png']
            });
    </script>
</div>
