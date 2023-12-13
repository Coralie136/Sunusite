<?php

    // title to be set on text's form
    $frmTitle   = (empty($text)) ? "Ajouter un texte" : "Modifier le texte";
    $submit     = (empty($text)) ? "Ajouter" : "Modifier";
    $color      = (empty($text)) ? "red-thunderbird" : "red-thunderbird";
    $icon       = (empty($text)) ? "plus" : "edit";
    $tid        = (!empty($text) AND (int)$text[0]->id_texte > 0) ? (int)$text[0]->id_texte : 0;
    $required   = (empty($text)) ? 'required="required"' : '';

    // 
    if (!empty($text)) {
        
        $textType       = ((int)$text[0]->id_type_texte > 0) ? (int)$text[0]->id_type_texte : 0;
        $textContent    = (!empty($text[0]->contenu_texte)) ? $text[0]->contenu_texte : '';
        $textContentE   = (!empty($text[0]->contenu_texte_en)) ? $text[0]->contenu_texte_en : '';
        
    } else {
        
        $textType       = '';
        $textContent    = '';
        $textContentE   = '';
        
    }

?>

<!-- BEGIN CONTENT -->
<div class="page-content">
   
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> <?php echo strtoupper($page_title); ?> <br />
        <small>[ <?php echo ucfirst($page_description); ?> ]</small>
    </h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    
    <!-- BEGIN PAGE BODY -->
    <div class="row">
        <div class="col-md-12">
           
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
                                    <a href="<?php echo site_url('admin/group/text'); ?>" class="btn btn-outline <?php echo $color; ?>">
                                         <i class="fa fa-long-arrow-left"></i>&nbsp; Retour aux textes 
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <?php
                        $disabledChk    = '';
                    if (empty($texts)) {
                        $disabledChk    = 'disabled="disabled"';
                    }
                    ?>
                    
                    <!-- BEGIN FORM -->
                    <form method="POST" action="<?php echo site_url('admin/group/addText'); ?>" name="form_add" id="form_add" enctype="multipart/form-data">
                        
                        <!-- BEGIN FORM BODY -->
                        <div class="form-body">

                            <!-- BEGIN FORM VALIDATION STATES -->
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button> Vous avez des erreurs de formulaire. Veuillez v&eacute;rifier ci-dessous.
                            </div>
                            <div class="alert alert-success display-hide">
                                <button class="close" data-close="alert"></button> Votre validation de formulaire est r&eacute;ussie!
                            </div>
                            <!-- END FORM VALIDATION STATES -->
                            
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">
                                        Type <span class="required">*</span>
                                    </label>
                                    <select class="form-control select2" name="slt_type" id="slt_type" required="required" <?php echo $disabled; ?>>
                                        <option value=""></option>
                                    <?php
                                    if (isset($types) AND !empty($types)) {
                                        foreach ($types as $type) {
                                            $select = '';
                                            if (!empty($textType)) {
                                                if ($type->id_type_texte == $textType) {
                                                    $select = 'selected="selected"';
                                                } else {
                                                    $select = '';
                                                } 
                                            }
                                    ?>
                                        <option value="<?php echo $type->id_type_texte; ?>" <?php echo $select; ?>>
                                            <?php echo ucwords($type->nom_type_texte); ?>
                                        </option>
                                    <?php
                                        }
                                    } // End if
                                    ?>
                                    </select>
                                </div>
                            </div><br />
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label" for="txt_text">Texte (français) <span class="required">*</span></label>
                                    <textarea class="ckeditor form-control" name="txt_text" id="txt_text" rows="6" data-error-container="#editor2_error"><?php echo $textContent; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                            </div><br />
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label" for="txt_text_en">Texte (anglais)<span class="required">*</span></label>
                                    <textarea class="ckeditor form-control" name="txt_text_en" id="txt_text_en" rows="6" data-error-container="#editor2_error"><?php echo $textContentE; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                            </div>
                            
                        </div>
                        <!--END FORM BODY -->

                        <br /><br />
                       
                        <!-- BEGIN FORM ACTIONS -->
                        <div class="form-actions">
                            <div class="row text-right">
                                <div class="col-md-offset-9 col-md-3">
                                    <a href="<?php echo site_url('admin/group/text'); ?>" class="btn btn-outline <?php echo $color; ?>"><i class="fa fa-long-arrow-left"></i> Annuler </a>
                                    <button id="submit-import-file" type="submit" class="btn <?php echo $color; ?>"> <?php echo $submit; ?> <i class="fa fa-<?php echo $icon; ?>"></i> </button>
                                    <input type="hidden" name="tid" value="<?php echo $tid; ?>" />
                                </div>
                            </div>
                        </div><br />
                        <!-- END FORM ACTIONS -->
                        
                    </form>
                    
                </div>
                <!-- END PORTLET BODY -->
                
            </div>
            <!-- END TABLE PORTLET -->
            
        </div>
    </div>
    <!-- END PAGE BODY -->
    
</div>
<!-- END CONTENT -->