<?php

// title to be set on team mate form
$frmTitle   = (empty($network)) ? "Ajouter un lien" : "Modifier le lien";
$submit     = (empty($network)) ? "Ajouter" : "Modifier";
$color      = (empty($network)) ? "red-thunderbird" : "red-thunderbird";
$icon       = (empty($network)) ? "plus" : "edit";
//    $aid        = (!empty($network) AND (int)$network[0]->id_equipe > 0) ? (int)$network[0]->id_equipe : 0;
$required   = (empty($network)) ? 'required="required"' : '';

//var_dump($network[0]->facebook); die();
// 
if (!empty($network)) {

    $networkId         = ((int)$network[0]->id_reseau_social > 0) ? $network[0]->id_reseau_social : ''; // -> id
    $networkFacebook  = (!empty($network[0]->facebook)) ? $network[0]->facebook : ''; // -> first name
    $networkLinkedin   = (!empty($network[0]->linkedin)) ? $network[0]->linkedin : ''; // -> last name
    $networkSunuSante       = (!empty($network[0]->sunu_sante)) ? $network[0]->sunu_sante : ''; // -> role

} else {

    $networkId         = 0;
    $networkFacebook  = '';
    $networkLinkedin   = '';
    $networkSunuSante       = '';
    $date               = date('d-m-Y');

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
                                    <a href="<?php echo site_url('admin/group/network'); ?>" class="btn btn-outline <?php echo $color; ?>">
                                        <i class="fa fa-long-arrow-left"></i>&nbsp; Retour aux liens
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- BEGIN FORM -->
                    <form role="form" action="<?php echo site_url('admin/group/addNetwork'); ?>" method="post" accept-charset="utf-8" id="director_tab_1" name="director_tab_1" class="form-horizontal">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label" for="txt_facebook">facebook <span class="required">*</span> :</label>
                                            <input type="url" placeholder="https://web.facebook.com/sunuassurances/" class="form-control" value="<?php echo $networkFacebook; ?>" name="txt_facebook" id="txt_facebook" required="required" />
                                        </div>
                                    </div><br />
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label" for="txt_linkedin">Linkedin <span class="required">*</span> :</label>
                                            <input type="url" placeholder="https://www.linkedin.com/company/1820547/" class="form-control" value="<?php echo $networkLinkedin; ?>" name="txt_linkedin" id="txt_linkedin" required="required" />
                                        </div>
                                    </div><br />
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label" for="txt_sunu_sante">Sunu sante <span class="required">*</span> :</label>
                                            <input type="url" placeholder="http://sunuhealth.com/" class="form-control" value="<?php echo $networkSunuSante; ?>" name="txt_sunu_sante" id="txt_sunu_sante" required="required" />
                                        </div>
                                    </div><br />
                                </div>
                            </div>
                        </div>
                        <div class="margiv-top-12 text-right">
                            <button type="submit" class="btn green-meadow"> Enregistrer </button>
                        </div>
                        <input type="hidden" name="tid" id="tid" value="<?php echo $networkId; ?>" />
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