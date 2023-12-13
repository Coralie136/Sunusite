<?php
    
    // title to be set on post's form
    $frmTitle   = (empty($publication)) ? "Ajouter une publication" : "Modifier la publication";
    $submit     = (empty($publication)) ? "Ajouter" : "Modifier";
    $color      = (empty($publication)) ? "red-thunderbird" : "red-thunderbird";
    $icon       = (empty($publication)) ? "plus" : "edit";
    $pid        = (!empty($publication) AND (int)$publication[0]->id_publication > 0) ? (int)$publication[0]->id_publication : 0;
    $required   = (empty($publication)) ? 'required="required"' : '';

    // 
    if (!empty($publication)) {
        
        $title  = (!empty($publication[0]->titre_publication)) ? $publication[0]->titre_publication : '';
        $titleE = (!empty($publication[0]->titre_publication_en)) ? $publication[0]->titre_publication_en : '';
        $text   = (!empty($publication[0]->texte_publication)) ? $publication[0]->texte_publication : '';
        $textE  = (!empty($publication[0]->texte_publication_en)) ? $publication[0]->texte_publication_en : '';
        $file   = (!empty($publication[0]->fichier_publication)) ? $publication[0]->fichier_publication : '';
        
        // display creation date to the format being used by the datepicker
        $date   = (!empty($publication[0]->dateCreated_publication)) ? $publication[0]->dateCreated_publication : '' ; // data creation date
        $date   = (!empty($date)) ? DateTime::createFromFormat('Y-m-d H:i:s', $date) : '' ; // create new date object from the database date format (Y-m-d)
        $date   = (!empty($date)) ? $date->format('d-m-Y') : '' ; // format the data object to datepicker date format (d-m-Y)
        
    } else {
        
        $title  = '';
        $titleE = '';
        $text   = '';
        $textE  = '';
        $file   = '';
        $date   = date('d-m-Y');
        
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
                                    <a href="<?php echo site_url('admin/post'); ?>" class="btn btn-outline <?php echo $color; ?>">
                                         <i class="fa fa-long-arrow-left"></i>&nbsp; Retour aux publications 
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <?php
                        $disabledChk    = '';
                    if (empty($publications)) {
                        $disabledChk    = 'disabled="disabled"';
                    }
                    ?>
                    
                    <!-- BEGIN FORM -->
                    <form method="POST" action="<?php echo site_url('admin/post/addPost'); ?>" name="form_add" id="form_add" enctype="multipart/form-data">
                        
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
                                <div class="col-md-3">
                                    <label class="control-label">Date </label>
                                    <div class="input-group input-medium date date-picker" data-date="" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                        <input type="text" class="form-control" readonly="readonly" name="dt_date" id="dt_date" value="<?php echo $date; ?>">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label" for="txt_title">Titre (fran&ccedil;ais) <span class="required">*</span></label>
                                        <input type="text" name="txt_title" id="txt_title" class="form-control" placeholder="Titre de la publication" required="required" autofocus="autofocus" value="<?php echo $title; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="txt_title_en">Titre (anglais) <span class="required">*</span></label>
                                        <input type="text" name="txt_title_en" id="txt_title_en" class="form-control" placeholder="Post title" required="required" value="<?php echo $titleE; ?>" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label" for="txt_text">Texte (fran&ccedil;ais) <span class="required">*</span></label>
                                    <textarea class="ckeditor form-control" name="txt_text" id="txt_text" rows="6" data-error-container="#editor2_error"><?php echo $text; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                            </div><br />
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label" for="txt_text_en">Texte (anglais)<span class="required">*</span></label>
                                    <textarea class="ckeditor form-control" name="txt_text_en" id="txt_text_en" rows="6" data-error-container="#editor2_error"><?php echo $textE; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                            </div><br />
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="fileinput fileinput-new tooltips" title="Fichier .pdf uniquement" data-provides="fileinput">
                                        <span class="btn green-jungle btn-file">
                                            <span class="fileinput-new">
                                                Document (Fran&ccedil;ais) &nbsp;<i class="fa fa-download"></i>
                                            </span>
                                            <span class="fileinput-exists"> Modifier </span>
                                            <input type="file" name="import-file" id="import-file" onchange="importDetail('import-file', 'import-detail')" <?php echo $required; ?> value="" />
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <table role="presentation" class="table table-striped hidden-element" id="import-detail">
                                        <tbody class="file">
                                            <td>
                                                <span id="import-detail-file">Aucun fichier n'a été sélectionné !</span>
                                                <span id="import-detail-error" class="hidden-element">
                                                    <strong>Erreur</strong>, seuls les documents sont autorisés !
                                                </span>
                                            </td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="fileinput fileinput-new tooltips" title="Only .pdf file" data-provides="fileinput">
                                        <span class="btn green-jungle btn-file">
                                            <span class="fileinput-new">
                                                Document (Anglais) &nbsp;<i class="fa fa-download"></i>
                                            </span>
                                            <span class="fileinput-exists"> Modifier </span>
                                            <input type="file" name="import-file2" id="import-file2" onchange="importDetail('import-file2', 'import-detail2')" value="" />
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <table role="presentation" class="table table-striped hidden-element" id="import-detail2">
                                        <tbody class="file">
                                            <td>
                                                <span id="import-detail2-file">Aucun fichier n'a été sélectionné !</span>
                                                <span id="import-detail2-error" class="hidden-element">
                                                    <strong>Erreur</strong>, seuls les documents sont autorisés !
                                                </span>
                                            </td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                        <!--END FORM BODY -->

                        <br /><br />
                       
                        <!-- BEGIN FORM ACTIONS -->
                        <div class="form-actions">
                            <div class="row text-right">
                                <div class="col-md-offset-9 col-md-3">
                                    <a href="<?php echo site_url('admin/post'); ?>" class="btn btn-outline <?php echo $color; ?>"><i class="fa fa-long-arrow-left"></i> Annuler </a>
                                    <button id="submit-import-file" type="submit" class="btn <?php echo $color; ?>"> <?php echo $submit; ?> <i class="fa fa-<?php echo $icon; ?>"></i> </button>
                                    <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
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


<script type="text/javascript">
    
    var controller = 'admin/ajax';
	var base_url = '<?php echo site_url(); //you have to load the "url_helper" to use this function ?>';
    
    
    //----------------------------------------------------------------------------------------------------
    // GET ALL INFORMATIONS ABOUT THE FILE SELECTED AND DISPLAY THEM WITH A SUBMIT BUTTON IN SUCCESS CASE
    //----------------------------------------------------------------------------------------------------
        function importDetail(inputField, inputDetail) {
            
            // Get the input file
            var fileInput       = $('#'+inputField);
            
            // Get the file details elements
            var tableDetail     = $('#'+inputDetail);
            var fileDetail      = $('#'+inputDetail+'-file');
            var fileError       = $('#'+inputDetail+'-error');
            var submitButton    = $('#submit-import-file');
            
            // Get the selected file if exists
            var selectedFile    = ((typeof fileInput !== undefined) && (fileInput[0].files.length > 0)) ? fileInput[0].files[0] : '';
            
            // Set the array of granted file extensions
            var grantedExtension    = ['.pdf'];
            var grantedFileTypes    = ['application/pdf'];
            var fileExtension       = '';
            
            // Display details about selected file or display a "empty-message" if there no selected file
            if (selectedFile != '') {

                // Get the file extension
                fileExtension   = selectedFile.name.substring(selectedFile.name.lastIndexOf('.'));
                
                // Check if the file extension is correct
                if ((grantedExtension.indexOf(fileExtension) != (-1)) && (grantedFileTypes.indexOf(selectedFile.type) != (-1))) {
                    fileError.toggleClass('hidden-element', true); // hide file error
                    tableDetail.toggleClass('table-danger', false); // remove table danger state
                    tableDetail.toggleClass('table-info', true); // add table info state
                    fileDetail.text(selectedFile.name); // display file name
                    fileDetail.toggleClass('hidden-element', false); // show file detail
//                    submitButton.toggleClass('hidden-element', false); // show submit button
                    submitButton.disabled   = '';
                    tableDetail.toggleClass('hidden-element', false); // show table detail
                } else {
                    fileDetail.toggleClass('hidden-element', true); // hide file detail
//                    submitButton.toggleClass('hidden-element', true); // hide submit button
                    submitButton.disabled   = 'disabled';
                    tableDetail.toggleClass('table-info', false); // remove table info state
                    tableDetail.toggleClass('table-danger', true); // add table danger state
                    fileError.toggleClass('hidden-element', false); // show file error
                    tableDetail.toggleClass('hidden-element', false); // show table detail
                }
            
            } else {
                
                tableDetail.toggleClass('table-info', false); // remove table info state
                tableDetail.toggleClass('table-danger', false); // remove table danger state
                fileError.toggleClass('hidden-element', true); // hide file error
//                submitButton.toggleClass('hidden-element', true); // hide submit button
                submitButton.disabled   = 'disabled';
                fileDetail.text('Aucun fichier n\'a été sélectionné !'); // display empty-message
                fileDetail.toggleClass('hidden-element', false); // show file detail
                tableDetail.toggleClass('hidden-element', false); // show table detail
                
            }
            
        }
    //----------------------------------------------------------------------------------------------------
    
</script>