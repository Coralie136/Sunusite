<?php

// title to be set on article's form
$frmTitle   = (empty($filiale)) ? "Ajouter une filiale" : "Modifier la filiale";
$submit     = (empty($filiale)) ? "Ajouter" : "Modifier";
$color      = (empty($filiale)) ? "red-thunderbird" : "red-thunderbird";
$icon       = (empty($filiale)) ? "plus" : "edit";
$aid        = (!empty($filiale) AND (int)$filiale[0]->id_description > 0) ? (int)$filiale[0]->id_description : 0;
$required   = (empty($filiale)) ? 'required="required"' : '';

//
if (!empty($filiale)) {

    $title  = (!empty($filiale[0]->titre_fr)) ? $filiale[0]->titre_fr : '';
    $titleE = (!empty($filiale[0]->titre_en)) ? $filiale[0]->titre_en : '';
    $lien_site_description   = (!empty($filiale[0]->lien_site_description)) ? $filiale[0]->lien_site_description : '';
    $detail_en  = (!empty($filiale[0]->detail_en)) ? $filiale[0]->detail_en : '';
    $detail_fr   = (!empty($filiale[0]->detail_fr)) ? $filiale[0]->detail_fr : '';
    $file   = (!empty($filiale[0]->image)) ? $filiale[0]->image : '';
    $siege_social_en   = (!empty($filiale[0]->siege_social_en)) ? $filiale[0]->siege_social_en : '';
    $siege_social_fr   = (!empty($filiale[0]->siege_social_fr)) ? $filiale[0]->siege_social_fr : '';
    $info_juridique_en   = (!empty($filiale[0]->info_juridique_en)) ? $filiale[0]->info_juridique_en : '';
    $info_juridique_fr   = (!empty($filiale[0]->info_juridique_fr)) ? $filiale[0]->info_juridique_fr : '';
    $direction_general_en   = (!empty($filiale[0]->direction_general_en)) ? $filiale[0]->direction_general_en : '';
    $direction_general_fr   = (!empty($filiale[0]->direction_general_fr)) ? $filiale[0]->direction_general_fr : '';
    $actionnariat_en   = (!empty($filiale[0]->actionnariat_en)) ? $filiale[0]->actionnariat_en : '';
    $actionnariat_fr   = (!empty($filiale[0]->actionnariat_fr)) ? $filiale[0]->actionnariat_fr : '';
    $conseil_admin_en   = (!empty($filiale[0]->conseil_admin_en)) ? $filiale[0]->conseil_admin_en : '';
    $conseil_admin_fr   = (!empty($filiale[0]->conseil_admin_fr)) ? $filiale[0]->conseil_admin_fr : '';
    $id_pays   = (!empty($filiale[0]->id_pays)) ? $filiale[0]->id_pays : '';
    $produit_en   = (!empty($filiale[0]->produit_en)) ? $filiale[0]->produit_en : '';
    $produit_fr   = (!empty($filiale[0]->produit_fr)) ? $filiale[0]->produit_fr : '';

    // display creation date to the format being used by the datepicker
    $date   = (!empty($filiale[0]->dateCreated_description)) ? $filiale[0]->dateCreated_description : '' ; // data creation date
    $date   = (!empty($date)) ? DateTime::createFromFormat('Y-m-d H:i:s', $date) : '' ; // create new date object from the database date format (Y-m-d)
    $date   = (!empty($date)) ? $date->format('d-m-Y') : '' ; // format the data object to datepicker date format (d-m-Y)

} else {
    $date = date("d-m-Y");
    $title  = '';
    $titleE = '';
    $lien_site_description   = '';
    $detail_en  =  '';
    $detail_fr   = '';
    $file   = '';
    $siege_social_en   =  '';
    $siege_social_fr   =  '';
    $info_juridique_en   ='';
    $info_juridique_fr   = '';
    $direction_general_en   = '';
    $direction_general_fr   = '';
    $actionnariat_en   =  '';
    $actionnariat_fr   =  '';
    $conseil_admin_en   =  '';
    $conseil_admin_fr   =  '';
    $id_pays   = '';
    $produit_fr   = '';
    $produit_en   = '';
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
                                    <a href="<?php echo site_url('admin/filiale'); ?>" class="btn btn-outline <?php echo $color; ?>">
                                        <i class="fa fa-long-arrow-left"></i>&nbsp; Retour aux filiales
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php
                    $disabledChk    = '';
                    if (empty($filiales)) {
                        $disabledChk    = 'disabled="disabled"';
                    }
                    ?>

                    <!-- BEGIN FORM -->
                    <form method="POST" action="<?php echo site_url('admin/filiale/addFiliale'); ?>" name="form_add" id="form_add" enctype="multipart/form-data">

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
                                <div class="col-md-8">
                                    <label class="control-label" for="txt_pays">Pays <span class="required">*</span> </label>
                                    <select name="id_pays" class="form-control select select2" required="required">
                                        <option value=""><?php echo lang('pays'); ?></option>
                                        <?php
                                        if (isset($payss) AND !empty($payss)) {
                                            foreach ($payss as $pays) {
                                                $select = '';
                                                if (!empty($id_pays)) {
                                                    if ($pays->id_pays == $id_pays) {
                                                        $select = 'selected="selected"';
                                                    } else {
                                                        $select = '';
                                                    }
                                                }
                                                ?>
                                                <option value="<?php echo $pays->id_pays; ?>" <?php echo $select; ?> >
                                                    <?php echo $pays->nom_pays; ?>
                                                </option>
                                                <?php
                                            }
                                        } // End if
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
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
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label" for="txt_title">Titre (fran&ccedil;ais) </label>
                                        <input type="text" name="txt_title" id="txt_title" class="form-control" placeholder="Titre de la filiale"  autofocus="autofocus" value="<?php echo $title; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="txt_title_en">Titre (anglais) </label>
                                        <input type="text" name="txt_title_en" id="txt_title_en" class="form-control" placeholder="News title"  autofocus="autofocus" value="<?php echo $titleE; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="txt_link">Lien du site (fran&ccedil;ais) <span class="required"></span></label>
                                        <input type="link" name="txt_link" id="txt_link" class="form-control" placeholder="Lien du site" autofocus="autofocus" value="<?php echo $lien_site_description; ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label" for="txt_text">Description (fran&ccedil;ais) </label>
                                    <textarea class="ckeditor form-control" name="txt_text" id="txt_text" rows="6" data-error-container="#editor2_error"><?php echo $detail_fr; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                            </div><br />

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label" for="txt_text_en">Description (anglais)</label>
                                    <textarea class="ckeditor form-control" name="txt_text_en" id="txt_text_en" rows="6" data-error-container="#editor2_error"><?php echo $detail_en; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                            </div><br />

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="fileinput fileinput-new tooltips" title="Fichier .gif, .jpg, .jpeg & .svg uniquement" data-provides="fileinput">
                                        <span class="btn green-jungle btn-file">
                                            <span class="fileinput-new">
                                                Fichier image &nbsp;<i class="fa fa-download"></i>
                                            </span>
                                            <span class="fileinput-exists"> Modifier </span>
                                            <input type="file" name="import-file" id="import-file" accept="image/*" onchange="importDetail()"  value="" /> <!--<?php echo $required; ?>-->
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <table role="presentation" class="table table-striped hidden-element" id="import-detail">
                                        <tbody class="file">
                                        <td>
                                            <span id="import-detail-file">Aucun fichier n'a été sélectionné !</span>
                                            <span id="import-detail-error" class="hidden-element">
                                                    <strong>Erreur</strong>, seuls les fichiers Image sont autorisés !
                                                </span>
                                        </td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_siege_sociale">Siège sociale (fran&ccedil;ais) </label>
                                    <textarea class="ckeditor form-control" name="txt_siege_sociale" id="txt_siege_sociale" rows="6" data-error-container="#editor2_error"><?php echo $siege_social_fr; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_siege_sociale_en">Siège sociale (anglais)</label>
                                    <textarea class="ckeditor form-control" name="txt_siege_sociale_en" id="txt_siege_sociale_en" rows="6" data-error-container="#editor2_error"><?php echo $siege_social_en; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                            </div><br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_info_juridique_fr">Information juridique (fran&ccedil;ais) </label>
                                    <textarea class="ckeditor form-control" name="txt_info_juridique_fr" id="txt_info_juridique_fr" rows="6" data-error-container="#editor2_error"><?php echo $info_juridique_fr; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_info_juridique_en">Information juridique (anglais)</label>
                                    <textarea class="ckeditor form-control" name="txt_info_juridique_en" id="txt_info_juridique_en" rows="6" data-error-container="#editor2_error"><?php echo $info_juridique_en; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                            </div><br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_direction_general_fr">Direction générale (fran&ccedil;ais) </label>
                                    <textarea class="ckeditor form-control" name="txt_direction_general_fr" id="txt_direction_general_fr" rows="6" data-error-container="#editor2_error"><?php echo $direction_general_fr; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_direction_general_en">Direction générale (anglais)</label>
                                    <textarea class="ckeditor form-control" name="txt_direction_general_en" id="txt_direction_general_en" rows="6" data-error-container="#editor2_error"><?php echo $direction_general_en; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                            </div><br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_actionnariat_fr">Actionnariat (fran&ccedil;ais) </label>
                                    <textarea class="ckeditor form-control" name="txt_actionnariat_fr" id="txt_actionnariat_fr" rows="6" data-error-container="#editor2_error"><?php echo $actionnariat_fr; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_actionnariat_en">Actionnariat (anglais)</label>
                                    <textarea class="ckeditor form-control" name="txt_actionnariat_en" id="txt_actionnariat_en" rows="6" data-error-container="#editor2_error"><?php echo $actionnariat_en; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                            </div><br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_conseil_admin_fr">Conseil d'administration (fran&ccedil;ais) </label>
                                    <textarea class="ckeditor form-control" name="txt_conseil_admin_fr" id="txt_conseil_admin_fr" rows="6" data-error-container="#editor2_error"><?php echo $conseil_admin_fr; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_conseil_admin_en">Conseil d'administration (anglais)</label>
                                    <textarea class="ckeditor form-control" name="txt_conseil_admin_en" id="txt_conseil_admin_en" rows="6" data-error-container="#editor2_error"><?php echo $conseil_admin_en; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                            </div><br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_produit_fr">Produit (fran&ccedil;ais) </label>
                                    <textarea class="ckeditor form-control" name="txt_produit_fr" id="txt_produit_fr" rows="6" data-error-container="#editor2_error"><?php echo $produit_fr; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_produit_en">Produit (anglais)</label>
                                    <textarea class="ckeditor form-control" name="txt_produit_en" id="txt_produit_en" rows="6" data-error-container="#editor2_error"><?php echo $produit_en; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                            </div><br />

                        </div>
                        <!--END FORM BODY -->

                        <br /><br />

                        <!-- BEGIN FORM ACTIONS -->
                        <div class="form-actions">
                            <div class="row text-right">
                                <div class="col-md-offset-9 col-md-3">
                                    <a href="<?php echo site_url('admin/article'); ?>" class="btn btn-outline <?php echo $color; ?>"><i class="fa fa-long-arrow-left"></i> Annuler </a>
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