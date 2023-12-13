<?php
    
    // title to be set on team mate form
    $frmTitle   = (empty($teammate)) ? "Ajouter un membre" : "Modifier le membre";
    $submit     = (empty($teammate)) ? "Ajouter" : "Modifier";
    $color      = (empty($teammate)) ? "red-thunderbird" : "red-thunderbird";
    $icon       = (empty($teammate)) ? "plus" : "edit";
//    $aid        = (!empty($teammate) AND (int)$teammate[0]->id_equipe > 0) ? (int)$teammate[0]->id_equipe : 0;
    $required   = (empty($teammate)) ? 'required="required"' : '';

    // 
    if (!empty($teammate)) {
        
        $teammateId         = ((int)$teammate[0]->id_equipe > 0) ? $teammate[0]->id_equipe : ''; // -> id
        $teammateFirstName  = (!empty($teammate[0]->nom_equipe)) ? $teammate[0]->nom_equipe : ''; // -> first name
        $teammateLastName   = (!empty($teammate[0]->prenom_equipe)) ? $teammate[0]->prenom_equipe : ''; // -> last name
        $teammateRole       = (!empty($teammate[0]->fonction_equipe)) ? $teammate[0]->fonction_equipe : ''; // -> role
        $teammateRoleE      = (!empty($teammate[0]->fonction_equipe_en)) ? $teammate[0]->fonction_equipe_en : ''; // -> role english
        $teammateFile       = (!empty($teammate[0]->fichier_equipe)) ? base_url()."upload/".$teammate[0]->fichier_equipe : base_url()."assets/admin/images/profile-male.png";
        
    } else {
        
        $teammateId         = 0;
        $teammateFirstName  = '';
        $teammateLastName   = '';
        $teammateRole       = '';
        $teammateRoleE      = '';
        $teammateFile       = base_url()."assets/admin/images/profile-male.png";
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
                                    <a href="<?php echo site_url('admin/group/team'); ?>" class="btn btn-outline <?php echo $color; ?>">
                                         <i class="fa fa-long-arrow-left"></i>&nbsp; Retour aux membres 
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <!-- BEGIN FORM -->
                    <form role="form" action="<?php echo site_url('admin/group/addTeam'); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" id="director_tab_1" name="director_tab_1" class="form-horizontal">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="<?php echo $teammateFile; ?>" alt="user picture" /> 
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> Choisir une image </span>
                                                <span class="fileinput-exists"> Modifier </span>
                                                <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
                                                <input type="file" id="picture" name="picture" accept="image/*" <?php echo $required; ?> /> </span>
                                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Supprimer </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label" for="txt_lastName">Nom <span class="required">*</span> :</label>
                                            <input type="text" placeholder="Nom du directeur" class="form-control" value="<?php echo mb_strtoupper($teammateFirstName); ?>" name="txt_lastName" id="txt_lastName" required="required" /> 
                                        </div>
                                        <div class="col-md-9">
                                            <label class="control-label" for="txt_firstName">Pr&eacute;nom(s) <span class="required">*</span> :</label>
                                            <input type="text" placeholder="Pr&eacute;noms du directeur" class="form-control" value="<?php echo ucwords($teammateLastName); ?>" name="txt_firstName" id="txt_firstName" required="required" />
                                        </div>
                                    </div><br />

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label" for="txt_role">Fonction (Fran&ccedil;ais) <span class="required">*</span> :</label>
                                            <textarea class="form-control" name="txt_role" id="txt_role" required="required"><?php echo $teammateRole; ?></textarea> 
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label" for="txt_role_en">Fonction (Anglais) <span class="required">*</span> :</label>
                                            <textarea class="form-control" name="txt_role_en" id="txt_role_en" required="required"><?php echo $teammateRoleE; ?></textarea> 
                                        </div>
                                    </div><br />
                                </div>
                            </div>
                        </div>
                        <div class="margiv-top-10 text-right">
                            <button type="submit" class="btn green-meadow"> Enregistrer </button>
                        </div>
                        <input type="hidden" name="tid" id="tid" value="<?php echo $teammateId; ?>" />
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