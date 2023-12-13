<?php

// title to be set on pays's form
$frmTitle   = (empty($images)) ? "Ajouter une image" : "Modifier l'image";
$submit     = (empty($images)) ? "Ajouter" : "Modifier";
$color      = (empty($images)) ? "red-thunderbird" : "red-thunderbird";
$icon       = (empty($images)) ? "plus" : "edit";
// $aid        = (!empty($images) AND (int)$images[0]->id_pays > 0) ? (int)$images[0]->id_pays : 0;
// $aid = (!empty($images) && isset($images[0]->id_pays) && (int)$images[0]->id_pays > 0) ?? (int)$images[0]->id_pays;
// $aid = $_GET['aid'];
$required   = (empty($images)) ? 'required="required"' : '';

//
if (!empty($images)) {

    $famille_image  = (!empty($images[0]->famille_image)) ? $images[0]->famille_image : '';

} else {

    $fichier_image  = '';

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
                                    <a href="<?php echo site_url('admin/imagesite'); ?>" class="btn btn-outline <?php echo $color; ?>">
                                        <i class="fa fa-long-arrow-left"></i>&nbsp; Retour aux images
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
                    <form method="POST" action="<?php echo site_url('admin/imagesite/addImages'); ?>" name="form_add" id="form_add" enctype="multipart/form-data">

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
                                    <div class="form-group">
                                        <label class="control-label" for="txt_name">Page <span class="required">*</span></label>
                                        <select name="fammille_image" id="famille_image" class="form-control">
                                            <option value="" <?php echo (empty($images) || $images[0]->famille_image == "" ? "selected" : "") ?>></option>
                                            <option value="legroupe" <?php echo (!empty($images) && $images[0]->famille_image == "legroupe" ? "selected" : "") ?>>le groupe</option>
                                            <option value="historique" <?php echo (!empty($images) && $images[0]->famille_image == "historique" ? "selected" : "") ?>>historique</option>
                                            <option value="chiffrescles" <?php echo (!empty($images) && $images[0]->famille_image == "chiffrescles" ? "selected" : "") ?>>chiffres cles</option>
                                            <option value="gouvernance" <?php echo (!empty($images) && $images[0]->famille_image == "gouvernance" ? "selected" : "")  ?>>gouvernance</option>
                                            <option value="publications" <?php echo (!empty($images) && $images[0]->famille_image == "publications" ? "selected" : "")  ?>>publications</option>
                                            <option value="notrereseau" <?php echo (!empty($images) && $images[0]->famille_image == "notrereseau" ? "selected" : "")  ?>>notre reseau</option>
                                            <option value="actualites" <?php echo (!empty($images) && $images[0]->famille_image == "actualites" ? "selected" : "")  ?>>actualites</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="fileinput fileinput-new tooltips" title="Fichier .gif, .jpg, .jpeg & .svg uniquement" data-provides="fileinput">
                                        <span class="btn green-jungle btn-file">
                                            <span class="fileinput-new">
                                                Image &nbsp;<i class="fa fa-download"></i>
                                            </span>
                                            <span class="fileinput-exists"> Modifier </span>
                                            <input type="file" accept="image/*" name="import-file" id="import-file" onchange="importDetail('import-file', 'import-detail')" <?php echo $required; ?> value="" />
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <table role="presentation" class="table table-striped hidden-element" id="import-detail">
                                        <tbody class="file">
                                        <td>
                                            <span id="import-detail-file">Aucun fichier n'a été sélectionné !</span>
                                            <span id="import-detail-error" class="hidden-element">
                                                    <strong>Erreur</strong>, seuls les images sont autorisés !
                                                </span>
                                        </td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <br>

                        </div>
                        <!--END FORM BODY -->

                        <br /><br />

                        <!-- BEGIN FORM ACTIONS -->
                        <div class="form-actions">
                            <div class="row text-right">
                                <div class="col-md-offset-9 col-md-3">
                                    <a href="<?php echo site_url('admin/imagesite'); ?>" class="btn btn-outline <?php echo $color; ?>">
                                    <i class="fa fa-long-arrow-left"></i> Annuler </a>
                                    <button id="submit-import-file" type="submit" class="btn <?php echo $color; ?>"> <?php echo $submit; ?> <i class="fa fa-<?php echo $icon; ?>"></i> </button>
                                    <input type="hidden" name="aid" value="<?php if($submit=="Modifier"){echo $_GET['aid'];}  ?>"  />
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