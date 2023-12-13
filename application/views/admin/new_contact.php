<?php
    
    // title to be set on contact's form
    $frmTitle   = (empty($contact)) ? "Ajouter un administrateur" : "Modifier l'administrateur";
    $submit     = (empty($contact)) ? "Ajouter" : "Modifier";
    $color      = (empty($contact)) ? "red-thunderbird" : "red-thunderbird";
    $icon       = (empty($contact)) ? "plus" : "edit";
    $aid        = (!empty($contact) AND (int)$contact[0]->id_contact > 0) ? (int)$contact[0]->id_contact : 0;
    $required   = (empty($contact)) ? 'required="required"' : '';
    //
//var_dump($contact); die();
    if (!empty($contact)) {
        $name  = (!empty($contact[0]->nom_contact)) ? $contact[0]->nom_contact : '';
        $email = (!empty($contact[0]->email_contact)) ? $contact[0]->email_contact : '';
        $id_pays = ((int)$contact[0]->id_pays > 0) ? (int)$contact[0]->id_pays : 0;
        $id_assurable = (!empty($contact[0]->id_assurable))  ? $contact[0]->id_assurable : 0;

        $array_reasurables = array();

       // var_dump($id_assurable); die();
        $n = strlen($id_assurable);
        for ($i=0; $i < $n; $i++) {
            $list = explode('|', $contact[$i]->id_assurable);
            $p = sizeof($list);
            for ($j=0; $j < $p; $j++) {
                if($list[$j] != ''){
                    //var_dump($list[$j]);
                    $array_reasurables[$j] =  $list[$j];
                }
            }
        }

        //var_dump($array_reasurables); die();

    } else {

        $name  = '';
        $email = '';
        $id_pays   = '';

        $array_reasurables = array();

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
                                    <a href="<?php echo site_url('admin/contact'); ?>" class="btn btn-outline <?php echo $color; ?>">
                                         <i class="fa fa-long-arrow-left"></i>&nbsp; Retour aux administrateurs
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <?php
                        $disabledChk    = '';
                    if (empty($contacts)) {
                        $disabledChk    = 'disabled="disabled"';
                    }
                    ?>
                    
                    <!-- BEGIN FORM -->
                    <form method="POST" action="<?php echo site_url('admin/contact/addcontact'); ?>" name="form_add" id="form_add" enctype="multipart/form-data">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="txt_name">Nom et prénom(s) <span class="required">*</span> </label>
                                        <input type="text" name="txt_name" id="txt_name" class="form-control" placeholder="Nom" required="required" autofocus="autofocus" value="<?php echo $name; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_email">E-mail <span class="required">*</span> </label>
                                    <input type="email" id="txt_email" name="txt_email" value="<?php echo $email; ?>" class="form-control" required placeholder="Email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_pays">Pays <span class="required">*</span> </label>
                                    <select name="id_pays" class="form-control select select2">
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
                                <div class="col-md-6">
                                    <div class="form-group" id="lassurable">
                                        <label class="control-label" for="id_assurable">Assurables <span class="required">*</span> </label>
                                        <select name="id_assurable[]" class="form-control ignore select2" data-placeholder="Objet précieux" multiple required>
                                            <?php

                                            if (isset($array_reasurables) /*AND !empty($array_reasurables)*/) {
                                                //var_dump(  $array_reasurables);

                                                foreach ($assurables as $assurable) {
                                                    $select = '';

                                                    $i = 0;
                                                    foreach($array_reasurables as $array_reasurable)
                                                    {
                                                        var_dump($data , $assurable->id_assurable);
                                                        $data = str_replace("'", '', $array_reasurables[$i]);
                                                        if ($data == $assurable->id_assurable) {
                                                            $select = 'selected="selected"';
                                                            break;
                                                        } else {
                                                            $select = '';
                                                        }
                                                        $i++;
                                                    }

                                                    ?>
                                                    <option value="<?php echo $assurable->id_assurable; ?>" <?php echo $select; ?> >
                                                        <?php echo $assurable->nom_assurable; ?>
                                                    </option>
                                                    <?php
                                                }
                                            } // End if
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <!--<div class="col-md-6">
                                    <div class="form-group" id="lassurable">
                                        <label class="control-label" for="id_assurable">Assurable <span class="required">*</span> </label>
                                        <select name="id_assurable[]" class="form-control ignore select2" data-placeholder="Objet précieux" multiple required>
                                            <?php foreach($assurables as $assurable): ?>
                                                <option value="<?php echo $assurable->id_assurable; ?>"><?php echo $assurable->nom_assurable; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>-->
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_password">Mot de passe <span class="required">*</span> </label>
                                    <input type="password" id="txt_password" name="txt_password" value="" class="form-control" required placeholder="Mot de passe">
                                    <?php if(!empty($aid)) { ?>
                                    <input type="hidden" id="txt_id_user" name="txt_id_user" value="<?php echo $contact[0]->id_user; ?>" class="form-control" required placeholder="Mot de passe">
                                    <?php } ?>
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
                                    <a href="<?php echo site_url('admin/contact'); ?>" class="btn btn-outline <?php echo $color; ?>"><i class="fa fa-long-arrow-left"></i> Annuler </a>
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