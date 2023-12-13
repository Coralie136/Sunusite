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
            <div class="portlet box red-thunderbird">
                
                <!-- BEGIN PORTLET TITLE -->
                <div class="portlet-title">
                    <div class="caption font-light">
                        <i class="fa fa-cogs"></i>
                        <span class="caption-subject"> Gestion de l'&eacute;quipe </span>
                    </div>
                </div>
                <!-- END PORTLET TITLE -->
                
                <!-- BEGIN PORTLET BODY -->
                <div class="portlet-body"><br />
                                
                    <?php
                        $feedBack   = $this->session->flashdata('retour');
                        if (isset($feedBack)) {
                    ?>
                            <div class="alert alert-<?php echo $feedBack['type']; ?> alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <?php echo $feedBack['message']; ?>
                            </div>
                    <?php
                        }
                    ?>

                    <div class="table-toolbar">
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="btn-group">
                                    <a href="<?php echo site_url('admin/group/newTeam'); ?>" class="btn red-thunderbird"> Ajouter un membre
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-9 right"> <!--Pour la selection: -->
                                <div class="btn-group actions">
                                    <a onclick="confirmEnableSelectedTeams()" data-toggle="modal" href="#confirmEnableSelectedTeams" class="btn green-meadow">
                                        Activer la s&eacute;lection <i class="fa fa-check"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDisableSelectedTeams()" data-toggle="modal" href="#confirmDisableSelectedTeams" class="btn red-thunderbird"> 
                                        D&eacute;sactiver la s&eacute;lection <i class="fa fa-times"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDeleteSelectedTeams()" data-toggle="modal" href="#confirmDeleteSelectedTeams" class="btn dark">
                                        Supprimer la s&eacute;lection <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <?php
                        $disabledChk    = '';
                    if (empty($teammates)) {
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
                                    <th> Photo </th>
                                    <th> Description </th>
                                    <th> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($teammates)) {
                                foreach($teammates as $teammate) {
                                    
                                    $teammateRole   = (!empty($teammate->fonction_equipe)) ? $teammate->fonction_equipe : ''; // -> role
                                    $teammateFile   = (!empty($teammate->fichier_equipe)) ? base_url()."upload/".$teammate->fichier_equipe : base_url()."assets/admin/images/profile-male.png";
                            ?>
                                <tr class="odd gradeX">
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" name="ids[]" value="<?php echo $teammate->id_equipe; ?>" onchange="selectItems()" />
                                            <span></span>
                                        </label>
                                    </td>
                                    
                                    <td class="sbold">
                                        <img src="<?php echo $teammateFile; ?>" />
                                    </td>
                                    
                                    <td>
                                        <h3><?php echo ucwords($teammate->prenom_equipe).' '.mb_strtoupper($teammate->nom_equipe); ?></h3>
                                        <i><?php echo ucfirst($teammate->fonction_equipe); ?></i>
                                    </td>
                                    
                                    <td>
                                        
                                        <a href="<?php echo site_url('admin/group/newTeam?tid='.$teammate->id_equipe); ?>" class="btn btn-sm btn-outline blue-steel" title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <?php
                                        if ($teammate->statut_equipe == '0') {
                                        ?>
                                        
                                            <a onclick="confirmEnableTeam(<?php echo $teammate->id_equipe; ?>)"  data-toggle="modal" href="#confirmEnableTeam" class="btn btn-sm green-meadow" title="Activer">
                                                <i class="fa fa-check"></i>
                                            </a>

                                        <?php
                                        } else if ($teammate->statut_equipe == '1') {
                                        ?>

                                            <a onclick="confirmDisableTeam(<?php echo $teammate->id_equipe; ?>)"  data-toggle="modal" href="#confirmDisableTeam" class="btn btn-sm red-thunderbird" title="D&eacute;sactiver">
                                                <i class="fa fa-close"></i>
                                            </a>

                                        <?php
                                        }
                                        ?>

                                        <a onclick="confirmDeleteTeam(<?php echo $teammate->id_equipe; ?>)" data-toggle="modal" href="#confirmDeleteTeam" class="btn btn-sm dark" title="Supprimer">
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
                <!-- END PORTLET BODY -->
                
            </div>
            <!-- END TABLE PORTLET -->
            
        </div>
    </div>
    <!-- END PAGE BODY -->
    
</div>
<!-- END CONTENT -->


<div class="modal fade" id="confirmEnableTeam" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/enableTeam'); ?>" method="POST" name="frm_enableTeam" id="frm_enableTeam" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-green-meadow" id="title-status">Remarque :</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Vous &ecirc;tes sur le point d'activer ce membre. </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline green-meadow" value="Annuler" />
                        <button type="submit" class="btn green-meadow">Activer <i class="fa fa-check"></i></button>
                        <input type="hidden" name="e_tid" id="e_tid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmDisableTeam" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/disableTeam'); ?>" method="POST" name="frm_disableTeam" id="frm_disableTeam" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-red-thunderbird" id="title-status">Attention !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Vous &ecirc;tes sur le point de désactiver ce membre. </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline red-thunderbird" value="Annuler" />
                        <button type="submit" class="btn red-thunderbird">Désactiver <i class="fa fa-times"></i></button>
                        <input type="hidden" name="d_tid" id="d_tid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmDeleteTeam" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/deleteTeam'); ?>" method="POST" name="frm_deleteTeam" id="frm_deleteTeam" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-dark" id="title-status">Confirmation de suppression !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Voulez-vous d&eacute;finitivement supprimer ce membre ? </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline dark" value="Annuler" />
                        <button type="submit" class="btn dark">Supprimer <i class="fa fa-trash"></i></button>
                        <input type="hidden" name="rm_tid" id="rm_tid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmEnableSelectedTeams" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/enableSelectedTeams'); ?>" method="POST" name="frm_enableSelectedTeams" id="frm_enableSelectedTeams" class="form-horizontal">
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


<div class="modal fade" id="confirmDisableSelectedTeams" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/disableSelectedTeams'); ?>" method="POST" name="frm_disableSelectedTeams" id="frm_disableSelectedTeams" class="form-horizontal">
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


<div class="modal fade" id="confirmDeleteSelectedTeams" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/deleteSelectedTeams'); ?>" method="POST" name="frm_deleteSelectedTeams" id="frm_deleteSelectedTeams" class="form-horizontal">
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


<script type="text/javascript">
    
    var controller = 'admin/ajax';
	var base_url = '<?php echo site_url(); //you have to load the "url_helper" to use this function ?>';
    
    function confirmDeleteTeam (rm_tid) {
        $('#rm_tid').val(rm_tid);
    }
    
    function confirmEnableTeam (e_tid) {
        $('#e_tid').val(e_tid);
    }
    
    function confirmDisableTeam (d_tid) {
        $('#d_tid').val(d_tid);
    }
    
    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
        function confirmEnableSelectedTeams () {
            
            // get all the checkboxes in datatable
            var items = $("[name='ids[]']");
            
            // remove all the previous selected checkboxes form the hidden input
            $('[name="e_tids[]"]').remove();
            
            // process all the checkboxes
            $(items).each(function () {
                // check if the current checkbox is checked
                if (this.checked) { // checked
                    // store the id into a hidden input
                    $("#enableItems").append('<input type="hidden" name="e_tids[]" value="'+parseInt(this.value)+'" />');
                }
            });
        }
    //-------------------------------------------------------
    
    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
        function confirmDisableSelectedTeams () {
            
            // get all the checkboxes in datatable
            var items = $("[name='ids[]']");
            
            // remove all the previous selected checkboxes form the hidden input
            $('[name="d_tids[]"]').remove();
            
            // process all the checkboxes
            $(items).each(function () {
                // check if the current checkbox is checked
                if (this.checked) { // checked
                    // store the id into a hidden input
                    $("#disableItems").append('<input type="hidden" name="d_tids[]" value="'+parseInt(this.value)+'" />');
                }
            });
        }
    //-------------------------------------------------------
    
    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
        function confirmDeleteSelectedTeams () {
            
            // get all the checkboxes in datatable
            var items = $("[name='ids[]']");
            
            // remove all the previous selected checkboxes form the hidden input
            $('[name="rm_tids[]"]').remove();
            
            // process all the checkboxes
            $(items).each(function () {
                // check if the current checkbox is checked
                if (this.checked) { // checked
                    // store the id into a hidden input
                    $("#deleteItems").append('<input type="hidden" name="rm_tids[]" value="'+parseInt(this.value)+'" />');
                }
            });
        }
    //-------------------------------------------------------
    
</script>