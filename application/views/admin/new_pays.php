<?php

// title to be set on pays's form
$frmTitle   = (empty($pays)) ? "Ajouter un pays" : "Modifier le pays";
$submit     = (empty($pays)) ? "Ajouter" : "Modifier";
$color      = (empty($pays)) ? "red-thunderbird" : "red-thunderbird";
$icon       = (empty($pays)) ? "plus" : "edit";
$aid        = (!empty($pays) AND (int)$pays[0]->id_pays > 0) ? (int)$pays[0]->id_pays : 0;
$required   = (empty($pays)) ? 'required="required"' : '';

//
if (!empty($pays)) {

    $nom_pays  = (!empty($pays[0]->nom_pays)) ? $pays[0]->nom_pays : '';
    $nom_paysE = (!empty($pays[0]->nom_pays_en)) ? $pays[0]->nom_pays_en : '';
    $lien_site   = (!empty($pays[0]->lien_site)) ? $pays[0]->lien_site : '';
    $lien_mbp  = (!empty($pays[0]->lien_mbp)) ? $pays[0]->lien_mbp : '';
    
    // display creation date to the format being used by the datepicker
    $date   = (!empty($pays[0]->dateCreated_pays)) ? $pays[0]->dateCreated_pays : '' ; // data creation date
    $date   = (!empty($date)) ? DateTime::createFromFormat('Y-m-d H:i:s', $date) : '' ; // create new date object from the database date format (Y-m-d)
    $date   = (!empty($date)) ? $date->format('d-m-Y') : '' ; // format the data object to datepicker date format (d-m-Y)

} else {

    $nom_pays  = '';
    $nom_paysE = '';
    $lien_site   = '';
    $lien_mbp  = '';
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
                                    <a href="<?php echo site_url('admin/pays'); ?>" class="btn btn-outline <?php echo $color; ?>">
                                        <i class="fa fa-long-arrow-left"></i>&nbsp; Retour aux pays
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php
                    $disabledChk    = '';
                    if (empty($payss)) {
                        $disabledChk    = 'disabled="disabled"';
                    }
                    ?>

                    <!-- BEGIN FORM -->
                    <form method="POST" action="<?php echo site_url('admin/pays/addPays'); ?>" name="form_add" id="form_add" enctype="multipart/form-data">

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
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label" for="txt_name">Nom du pays (fran&ccedil;ais) <span class="required">*</span></label>
                                        <input type="text" name="txt_name" id="txt_name" class="form-control" placeholder="Nom du pays" required="required" autofocus="autofocus" value="<?php echo $nom_pays; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label" for="txt_name_en">Nom du pays (anglais) <span class="required">*</span></label>
                                        <input type="text" name="txt_name_en" id="txt_name_en" class="form-control" placeholder="Nom du pays" required="required" autofocus="autofocus" value="<?php echo $nom_paysE; ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label" for="txt_link">Lien du site officiel <span class="required"></span></label>
                                        <input type="text" name="txt_link" id="txt_link" class="form-control" placeholder="Lien du site"  autofocus="autofocus" value="<?php echo $lien_site; ?>" />
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label" for="txt_lien_mbp">Lien mon bon profile <span class="required"></span></label>
                                        <input type="text" name="txt_lien_mbp" id="txt_lien_mbp" class="form-control" placeholder="Lien du mon bon profile"  autofocus="autofocus" value="<?php echo $lien_mbp; ?>" />
                                    </div>
                                </div>
                            </div><br />

                        </div>
                        <!--END FORM BODY -->

                        <br /><br />

                        <!-- BEGIN FORM ACTIONS -->
                        <div class="form-actions">
                            <div class="row text-right">
                                <div class="col-md-offset-9 col-md-3">
                                    <a href="<?php echo site_url('admin/pays'); ?>" class="btn btn-outline <?php echo $color; ?>"><i class="fa fa-long-arrow-left"></i> Annuler </a>
                                    <button id="submit-import-file" type="submit" class="btn <?php echo $color; ?>"> <?php echo $submit; ?> <i class="fa fa-<?php echo $icon; ?>"></i> </button>
                                    <input type="hidden" name="aid" value="<?php echo $aid; ?>" />
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
    function importDetail() {

        // Get the input file
        var fileInput       = $('#import-file');

        // Get the file details elements
        var tableDetail     = $('#import-detail');
        var fileDetail      = $('#import-detail-file');
        var fileError       = $('#import-detail-error');
        var submitButton    = $('#submit-import-file');

        // Get the selected file if exists
        var selectedFile    = ((typeof fileInput !== undefined) && (fileInput[0].files.length > 0)) ? fileInput[0].files[0] : '';

        // Set the array of granted file extensions
        var grantedExtension    = ['.gif', '.jpg', '.jpeg', '.svg'];
        var grantedFileTypes    = ['image/gif', 'image/jpeg', 'image/png', 'image/svg+xml'];
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