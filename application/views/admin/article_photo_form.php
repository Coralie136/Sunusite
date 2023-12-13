<!-- BEGIN TABLE PORTLET-->
<div class="portlet box <?php echo $color; ?>">
    
    <!-- BEGIN PORTLET TITLE -->
    <div class="portlet-title">
        <div class="caption font-light">
            <i class="fa fa-<?php echo $icon; ?>"></i>
            <span class="caption-subject"> <?php echo $frmTitle; ?> </span>
        </div>
    </div>
    <!-- END PORTLET TITLE -->
    
    <!-- BEGIN PORTLET BODY -->
    <div class="portlet-body"><br />

        <div class="table-toolbar">
            
            <div class="row">
                <div class="col-md-3">
                    <div class="btn-group">
                        <a href="<?php echo site_url('admin/article'); ?>" class="btn btn-outline <?php echo $color; ?>">
                             <i class="fa fa-long-arrow-left"></i>&nbsp; Retour aux articles 
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
        
        <?php
            $disabledChk    = '';
        if (empty($articles)) {
            $disabledChk    = 'disabled="disabled"';
        }
        ?>
        
        <!-- BEGIN FORM -->
        <form method="POST" action="<?php echo site_url('admin/article/addArticlePhoto'); ?>" class="dropzone dropzone-file-area" name="article_photos" id="article_photos" enctype="multipart/form-data"  style="width: 500px; margin-top: 50px;">
            
            <!-- BEGIN FORM BODY -->
            <h3 class="sbold">Glisser des photos ou cliquer ici pour ajouter de nouvelles photos</h3>
            <!--END FORM BODY -->
            
        </form>
        <br /><br />
        <div class="row text-right">
            <div class="col-md-offset-9 col-md-3">
                <a href="<?php echo site_url('admin/article'); ?>" class="btn btn-outline <?php echo $color; ?>"><i class="fa fa-long-arrow-left"></i> Annuler </a>
                <button id="submit-import-file" type="submit" class="btn <?php echo $color; ?>"> <?php echo $submit; ?> <i class="fa fa-<?php echo $icon; ?>"></i> </button>
                <input type="hidden" name="aid" value="<?php echo $aid; ?>" />
            </div>
        </div>
        
    </div>
    <!-- END PORTLET BODY -->
    
</div>
<!-- END TABLE PORTLET -->