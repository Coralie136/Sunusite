<?php
//var_dump($director); exit;
    
    // title to be set on article's form
    $frmTitle   = (empty($director)) ? "Ajouter un article" : "Modifier l'article";
    $submit     = (empty($director)) ? "Ajouter" : "Modifier";
    $color      = (empty($director)) ? "red-thunderbird" : "red-thunderbird";
    $icon       = (empty($director)) ? "plus" : "edit";
    $did        = (!empty($director) AND (int)$director[0]->id_equipe > 0) ? (int)$director[0]->id_equipe : 0;
    $required   = (empty($director)) ? 'required="required"' : '';

    // 
    if (!empty($director)) {
        
        $directorId         = ((int)$director[0]->id_equipe > 0) ? $director[0]->id_equipe : ''; // -> id
        $directorFirstName  = (!empty($director[0]->nom_equipe)) ? $director[0]->nom_equipe : ''; // -> first name
        $directorLastName   = (!empty($director[0]->prenom_equipe)) ? $director[0]->prenom_equipe : ''; // -> last name
        $directorRole       = (!empty($director[0]->fonction_equipe)) ? $director[0]->fonction_equipe : ''; // -> role
        $directorRoleE      = (!empty($director[0]->fonction_equipe_en)) ? $director[0]->fonction_equipe_en : ''; // -> role english
        $directorText       = (!empty($director[0]->biographie_equipe)) ? $director[0]->biographie_equipe : ''; // -> biography
        $directorTextE      = (!empty($director[0]->biographie_equipe_en)) ? $director[0]->biographie_equipe_en : ''; // -> biography english
        $directorFile       = (!empty($director[0]->fichier_equipe)) ? base_url()."upload/".$director[0]->fichier_equipe : base_url()."assets/images/profile-male.png"; // -> picture
        
    } else {
        
        $directorId         = 0;
        $directorFirstName  = '';
        $directorLastName   = '';
        $directorRole       = '';
        $directorRoleE      = '';
        $directorText       = '';
        $directorTextE      = '';
        $directorFile       = base_url()."assets/images/profile-male.png";
        
    }

?>
<div class="page-content">
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> <?php echo strtoupper($page_title); ?> <br />
        <small>[ <?php echo ucfirst($page_description); ?> ]</small>
    </h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    
    <div class="row">
        <div class="col-md-12">
            <?php
                $message = $this->session->flashdata('retour');
                if($message){
            ?>
            <div class="alert alert-<?php echo $message['type']; ?> alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <?php echo $message['message']; ?>
            </div>
            <?php 
                }
            ?>
            
            <?php
            // Display the current bloc only if the director already exists
            if (!empty($did)) {
            ?>
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
                <!-- PORTLET MAIN -->
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject bold font-blue uppercase">
                            <!--Trafic d'utilisation--> D&eacute;tails utilisateur
                        </span>
                        </div>
                    </div>
                    <div class="mt-element-card mt-element-overlay">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="mt-card-item">
                                    <div class="mt-card-avatar mt-overlay-1 mt-scroll-left">
                                        <img src="<?php echo $directorFile; ?>" alt="my picture" />
                                        <div class="mt-overlay">
                                            <ul class="mt-info">
                                                <li>
                                                    <a class="btn default btn-outline" target="_blank" href="<?php echo $directorFile; ?>">
                                                        <i class="icon-magnifier"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mt-card-content">
                                        <h3 class="mt-card-name"><?php echo ucwords($directorLastName).' '.strtoupper($directorFirstName); ?></h3>
                                        <p class="mt-card-desc font-grey-mint"><?php echo $directorRole; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET MAIN -->
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
            <?php
            } // End if
            ?>
            
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Le directeur</span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#director_tab_1" data-toggle="tab">Informations</a>
                                    </li>
                                    
                                    <li>
                                        <a href="#director_tab_2" data-toggle="tab">Exp&eacute;rience</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane active" id="director_tab_1">
                                        <form role="form" action="<?php echo site_url('admin/group/setDirectorInfo'); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" id="director_tab_1" name="director_tab_1" class="form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="control-label" for="txt_lastName">Nom <span class="required">*</span> :</label>
                                                        <input type="text" placeholder="Nom du directeur" class="form-control" value="<?php echo mb_strtoupper($directorFirstName); ?>" name="txt_lastName" id="txt_lastName" required="required" /> 
                                                    </div>
                                                    <div class="col-md-9">
                                                        <label class="control-label" for="txt_firstName">Pr&eacute;nom(s) <span class="required">*</span> :</label>
                                                        <input type="text" placeholder="Pr&eacute;noms du directeur" class="form-control" value="<?php echo ucwords($directorLastName); ?>" name="txt_firstName" id="txt_firstName" required="required" />
                                                    </div>
                                                </div><br />
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="txt_role">Fonction (Fran&ccedil;ais) :</label>
                                                        <textarea class="form-control" name="txt_role" id="txt_role"><?php echo $directorRole; ?></textarea> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="txt_role_en">Fonction (Anglais) :</label>
                                                        <textarea class="form-control" name="txt_role_en" id="txt_role_en"><?php echo $directorRoleE; ?></textarea> 
                                                    </div>
                                                </div><br />
                            
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label" for="txt_biography">Biographie (fran&ccedil;ais) <span class="required">*</span></label>
                                                        <textarea class="ckeditor form-control" name="txt_biography" id="txt_biography" rows="6" data-error-container="#editor2_error"><?php echo $directorText; ?></textarea>
                                                        <div id="editor2_error"> </div>
                                                    </div>
                                                </div><br />

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label" for="txt_biography_en">Biographie (anglais)<span class="required">*</span></label>
                                                        <textarea class="ckeditor form-control" name="txt_biography_en" id="txt_biography_en" rows="6" data-error-container="#editor2_error"><?php echo $directorTextE; ?></textarea>
                                                        <div id="editor2_error"> </div>
                                                    </div>
                                                </div><br />

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                <img src="<?php echo $directorFile; ?>" alt="user picture" /> 
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
                                                </div><br /><br />
                                            </div>
                                            <div class="margiv-top-10 text-right">
                                                <button type="submit" class="btn green-meadow"> Enregistrer </button>
                                            </div>
                                            <input type="hidden" name="did" id="did" value="<?php echo $did; ?>" />
                                        </form>
                                    </div>
                                    <!-- END PERSONAL INFO TAB -->
                                    
                                    <!-- CHANGE PASSWORD TAB -->
                                    <div class="tab-pane" id="director_tab_2">
                                        <div class="table-toolbar">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="btn-group">
                                                        <a onclick="frmExperience(0, false)" data-toggle="modal" href="#frmExperience" class="btn red-thunderbird"> Ajouter une exp&eacute;rience
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </div>

                                                    <div class="btn-group actions">
                                                        <a onclick="confirmEnableSelectedExperiences()" data-toggle="modal" href="#confirmEnableSelectedExperiences" class="btn green-meadow">
                                                            Activer la s&eacute;lection <i class="fa fa-check"></i>
                                                        </a>
                                                    </div>
                                                    <div class="btn-group actions">
                                                        <a onclick="confirmDisableSelectedExperiences()" data-toggle="modal" href="#confirmDisableSelectedExperiences" class="btn red-thunderbird"> 
                                                            D&eacute;sactiver la s&eacute;lection <i class="fa fa-times"></i>
                                                        </a>
                                                    </div>
                                                    <div class="btn-group actions">
                                                        <a onclick="confirmDeleteSelectedExperiences()" data-toggle="modal" href="#confirmDeleteSelectedExperiences" class="btn dark">
                                                            Supprimer la s&eacute;lection <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <?php
                                            $disabledChk    = '';
                                        if (empty($experiences)) {
                                            $disabledChk    = 'disabled="disabled"';
                                        }
                                        ?>
                                        <form method="POST" action="<?php echo site_url('admin/comptes/actions'); ?>">
                                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" name="allId" onchange="checkItems()" <?php echo $disabledChk; ?> />
                                                                <span></span>
                                                            </label>
                                                        </th>
                                                        <th> Periode </th>
                                                        <th> Texte </th>
                                                        <th> Actions </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if (isset($experiences)) {

                                                    // Loop through experiences and display each
                                                    foreach($experiences as $experience) {
                                                ?>
                                                    <tr class="odd gradeX">
                                                        <td>
                                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                <input type="checkbox" class="checkboxes" name="ids[]" value="<?php echo $experience->id_experience; ?>" onchange="selectItems()" />
                                                                <span></span>
                                                            </label>
                                                        </td>

                                                        <td class="sbold">
                                                            <a onclick="frmExperience(<?php echo $experience->id_experience; ?>, true)" data-toggle="modal" href="#frmExperience" class="btn btn-sm blue-steel" title="D&eacute;tails">
                                                                <i><?php echo ucwords($experience->periode_experience); ?></i>
                                                            </a>
                                                        </td>

                                                        <td>
                                                            <i><?php echo $experience->texte_experience; ?></i>
                                                        </td>

                                                        <td>
                                                            <a onclick="frmExperience(<?php echo $experience->id_experience; ?>, true)" data-toggle="modal" href="#frmExperience" class="btn btn-sm blue-steel" title="D&eacute;tails">
                                                                <i class="fa fa-ellipsis-h"></i>
                                                            </a>

                                                            <a onclick="frmExperience(<?php echo $experience->id_experience; ?>, false)" data-toggle="modal" href="#frmExperience" class="btn btn-sm btn-outline blue-steel" title="Modifier">
                                                                <i class="fa fa-edit"></i>
                                                            </a>

                                                            <?php
                                                            if ($experience->statut_experience == '0') {
                                                            ?>

                                                                <a onclick="confirmEnableExperience(<?php echo $experience->id_experience; ?>)" data-toggle="modal" href="#confirmEnableExperience" class="btn btn-sm green-meadow" title="Activer">
                                                                    <i class="fa fa-check"></i>
                                                                </a>

                                                            <?php
                                                            } else if ($experience->statut_experience == '1') {
                                                            ?>

                                                                <a onclick="confirmDisableExperience(<?php echo $experience->id_experience; ?>)" data-toggle="modal" href="#confirmDisableExperience" class="btn btn-sm red-thunderbird" title="D&eacute;sactiver">
                                                                    <i class="fa fa-close"></i>
                                                                </a>

                                                            <?php
                                                            }
                                                            ?>

                                                            <a onclick="confirmDeleteExperience(<?php echo $experience->id_experience; ?>)" data-toggle="modal" href="#confirmDeleteExperience" class="btn btn-sm dark" title="Supprimer">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </td>

                                                    </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                    <!-- END CHANGE PASSWORD TAB -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
    
</div>


<div class="modal fade" id="confirmEnableExperience" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/enableExperience'); ?>" method="POST" name="frm_enableExperience" id="frm_enableExperience" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-green-meadow" id="title-status">Remarque :</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Vous &ecirc;tes sur le point d'activer cette exp&eacute;rience. </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline green-meadow" value="Annuler" />
                        <button type="submit" class="btn green-meadow">Activer <i class="fa fa-check"></i></button>
                        <input type="hidden" name="e_eid" id="e_eid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmDisableExperience" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/disableExperience'); ?>" method="POST" name="frm_disableExperience" id="frm_disableExperience" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-red-thunderbird" id="title-status">Attention !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Vous &ecirc;tes sur le point de désactiver cette exp&eacute;rience. </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline red-thunderbird" value="Annuler" />
                        <button type="submit" class="btn red-thunderbird">Désactiver <i class="fa fa-times"></i></button>
                        <input type="hidden" name="d_eid" id="d_eid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmDeleteExperience" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/deleteExperience'); ?>" method="POST" name="frm_deleteExperience" id="frm_deleteExperience" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-dark" id="title-status">Confirmation de suppression !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Voulez-vous d&eacute;finitivement supprimer cette exp&eacute;rience ? </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline dark" value="Annuler" />
                        <button type="submit" class="btn dark">Supprimer <i class="fa fa-trash"></i></button>
                        <input type="hidden" name="rm_eid" id="rm_eid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmEnableSelectedExperiences" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/enableSelectedExperiences'); ?>" method="POST" name="frm_enableSelectedExperiences" id="frm_enableSelectedExperiences" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-green-meadow" id="title-status">Attention !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Vous &ecirc;tes sur le point d'activer la s&eacute;lection. </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions" id="enableItems">
                        <input type="button" data-dismiss="modal" class="btn btn-outline green-meadow" value="Annuler" />
                        <button type="submit" class="btn green-meadow">Activer la s&eacute;lection <i class="fa fa-check"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmDisableSelectedExperiences" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/disableSelectedExperiences'); ?>" method="POST" name="frm_disableSelectedExperiences" id="frm_disableSelectedExperiences" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-red-thunderbird" id="title-status">Attention !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Vous &ecirc;tes sur le point de désactiver la s&eacute;lection. </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions" id="disableItems">
                        <input type="button" data-dismiss="modal" class="btn btn-outline red-thunderbird" value="Annuler" />
                        <button type="submit" class="btn red-thunderbird">Désactiver la s&eacute;lection <i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmDeleteSelectedExperiences" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/deleteSelectedExperiences'); ?>" method="POST" name="frm_deleteSelectedExperiences" id="frm_deleteSelectedExperiences" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-dark" id="title-status">Attention !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Vous &ecirc;tes sur le point de supprimer la s&eacute;lection. </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions" id="deleteItems">
                        <input type="button" data-dismiss="modal" class="btn btn-outline dark" value="Annuler" />
                        <button type="submit" class="btn dark">Supprimer la s&eacute;lection <i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="frmExperience" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="displayFrmExperience">
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script type="text/javascript">
    
    var controller  = 'admin/ajax';
    var base_url    = '<?php echo site_url(); //you have to load the "url_helper" to use this function ?>';
    var did         = '<?php echo $did; // director id ?>';
    
    function confirmDeleteExperience (rm_eid) {
        $('#rm_eid').val(rm_eid);
    }
    
    function confirmEnableExperience (e_eid) {
        $('#e_eid').val(e_eid);
    }
    
    function confirmDisableExperience (d_eid) {
        $('#d_eid').val(d_eid);
    }
    
    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
        function confirmEnableSelectedExperiences () {
            
            // get all the checkboxes in datatable
            var items = $("[name='ids[]']");
            
            // remove all the previous selected checkboxes form the hidden input
            $('[name="e_eids[]"]').remove();
            
            // process all the checkboxes
            $(items).each(function () {
                // check if the current checkbox is checked
                if (this.checked) { // checked
                    // store the id into a hidden input
                    $("#enableItems").append('<input type="hidden" name="e_eids[]" value="'+parseInt(this.value)+'" />');
                }
            });
        }
    //-------------------------------------------------------
    
    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
        function confirmDisableSelectedExperiences () {
            
            // get all the checkboxes in datatable
            var items = $("[name='ids[]']");
            
            // remove all the previous selected checkboxes form the hidden input
            $('[name="d_eids[]"]').remove();
            
            // process all the checkboxes
            $(items).each(function () {
                // check if the current checkbox is checked
                if (this.checked) { // checked
                    // store the id into a hidden input
                    $("#disableItems").append('<input type="hidden" name="d_eids[]" value="'+parseInt(this.value)+'" />');
                }
            });
        }
    //-------------------------------------------------------
    
    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
        function confirmDeleteSelectedExperiences () {
            
            // get all the checkboxes in datatable
            var items = $("[name='ids[]']");
            
            // remove all the previous selected checkboxes form the hidden input
            $('[name="rm_eids[]"]').remove();
            
            // process all the checkboxes
            $(items).each(function () {
                // check if the current checkbox is checked
                if (this.checked) { // checked
                    // store the id into a hidden input
                    $("#deleteItems").append('<input type="hidden" name="rm_eids[]" value="'+parseInt(this.value)+'" />');
                }
            });
        }
    //-------------------------------------------------------
    
    //--------------------------------------------------------------------------------
    // LOAD AND DISPLAY A FORM (EMPTY OR FILLED WITH APPRECIATION INFOS) INTO A MODAL
    //--------------------------------------------------------------------------------
        function frmExperience (eid, read) {
            $.ajax({
                'url': base_url + controller + '/loadExperience/',
                'type': 'GET', //the way you want to send data to your URL
                'data': {
                    'eid':      eid, // experience's id
                    'did':      did, // director's id
                    'readOnly': read, // data state
                },
                'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                    var displayFrmExperience  = $('#displayFrmExperience'); //jquery selector (get element by id)
                    if (data) {
                        displayFrmExperience.html(data);
                    }
                }
            });
        }
    //--------------------------------------------------------------------------------
    
</script>