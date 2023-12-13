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
                        <span class="caption-subject"> Liste des publications </span>
                    </div>
                </div>
                <!-- END PORTLET TITLE -->
                
                <!-- BEGIN PORTLET BODY -->
                <div class="portlet-body"><br />
                                
                    <?php
                        $feedBack = $this->session->flashdata('retour');
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
                                    <a href="<?php echo site_url('admin/post/newPost'); ?>" class="btn red-thunderbird"> Ajouter une publication
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-9 right"> <!--Pour la selection: -->
                                <div class="btn-group actions">
                                    <a onclick="confirmEnableSelectedPosts()" data-toggle="modal" href="#confirmEnableSelectedPosts" class="btn green-meadow">
                                        Activer la s&eacute;lection <i class="fa fa-check"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDisableSelectedPosts()" data-toggle="modal" href="#confirmDisableSelectedPosts" class="btn red-thunderbird"> 
                                        D&eacute;sactiver la s&eacute;lection <i class="fa fa-times"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDeleteSelectedPosts()" data-toggle="modal" href="#confirmDeleteSelectedPosts" class="btn dark">
                                        Supprimer la s&eacute;lection <i class="fa fa-trash"></i>
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
                                    <th> Titre </th>
                                    <!-- <th> Description </th> -->
                                    <th> Date </th>
                                    <th> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($publications)) {
                                foreach($publications as $publication) {
                            ?>
                                <tr class="odd gradeX">
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" name="ids[]" value="<?php echo $publication->id_publication; ?>" onchange="selectItems()" />
                                            <span></span>
                                        </label>
                                    </td>
                                    
                                    <td class="sbold">
                                        <a href="Javascript:;" class="btn btn-sm green-meadow" title="Afficher">
                                            <?php echo $publication->titre_publication; ?>
                                        </a>
                                    </td>
                                    
                                    <!-- <td>
                                        <i><?php echo substr($publication->texte_publication, 0, 100).' [...]'; ?></i>
                                    </td> -->
                                    
                                    <td>
                                        <i><?php echo $this->fonctions->dtDisplay($publication->dateCreated_publication); ?></i>
                                    </td>
                                    
                                    <td>
                                       
                                        <a href="Javascript:;" class="btn btn-sm green-meadow" title="Afficher">
                                            <i class="fa fa-cogs"></i>
                                        </a>
                                        
                                        <a href="<?php echo site_url('admin/post/newPost?pid='.$publication->id_publication); ?>" class="btn btn-sm btn-outline blue-steel" title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <?php
                                        if ($publication->statut_publication == '0') {
                                        ?>
                                        
                                            <a onclick="confirmEnablePost(<?php echo $publication->id_publication; ?>)"  data-toggle="modal" href="#confirmEnablePost" class="btn btn-sm green-meadow" title="Activer">
                                                <i class="fa fa-check"></i>
                                            </a>

                                        <?php
                                        } else if ($publication->statut_publication == '1') {
                                        ?>

                                            <a onclick="confirmDisablePost(<?php echo $publication->id_publication; ?>)"  data-toggle="modal" href="#confirmDisablePost" class="btn btn-sm red-thunderbird" title="D&eacute;sactiver">
                                                <i class="fa fa-close"></i>
                                            </a>

                                        <?php
                                        }
                                        ?>

                                        <a onclick="confirmDeletePost(<?php echo $publication->id_publication; ?>)" data-toggle="modal" href="#confirmDeletePost" class="btn btn-sm dark" title="Supprimer">
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


<div class="modal fade" id="confirmEnablePost" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/post/enablePost'); ?>" method="POST" name="frm_enablePost" id="frm_enablePost" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-green-meadow" id="title-status">Remarque :</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Vous &ecirc;tes sur le point d'activer cette publication. </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline green-meadow" value="Annuler" />
                        <button type="submit" class="btn green-meadow">Activer <i class="fa fa-check"></i></button>
                        <input type="hidden" name="e_pid" id="e_pid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmDisablePost" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/post/disablePost'); ?>" method="POST" name="frm_disablePost" id="frm_disablePost" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-red-thunderbird" id="title-status">Attention !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Vous &ecirc;tes sur le point de désactiver cette publication. </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline red-thunderbird" value="Annuler" />
                        <button type="submit" class="btn red-thunderbird">Désactiver <i class="fa fa-times"></i></button>
                        <input type="hidden" name="d_pid" id="d_pid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmDeletePost" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/post/deletePost'); ?>" method="POST" name="frm_deletePost" id="frm_deletePost" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-dark" id="title-status">Confirmation de suppression !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Voulez-vous d&eacute;finitivement supprimer cette publication ? </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline dark" value="Annuler" />
                        <button type="submit" class="btn dark">Supprimer <i class="fa fa-trash"></i></button>
                        <input type="hidden" name="rm_pid" id="rm_pid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmEnableSelectedPosts" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/post/enableSelectedPosts'); ?>" method="POST" name="frm_enableSelectedPosts" id="frm_enableSelectedPosts" class="form-horizontal">
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


<div class="modal fade" id="confirmDisableSelectedPosts" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/post/disableSelectedPosts'); ?>" method="POST" name="frm_disableSelectedPosts" id="frm_disableSelectedPosts" class="form-horizontal">
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


<div class="modal fade" id="confirmDeleteSelectedPosts" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/post/deleteSelectedPosts'); ?>" method="POST" name="frm_deleteSelectedPosts" id="frm_deleteSelectedPosts" class="form-horizontal">
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
    
    function confirmDeletePost (rm_pid) {
        $('#rm_pid').val(rm_pid);
    }
    
    function confirmEnablePost (e_pid) {
        $('#e_pid').val(e_pid);
    }
    
    function confirmDisablePost (d_pid) {
        $('#d_pid').val(d_pid);
    }
    
    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
        function confirmEnableSelectedPosts () {
            
            // get all the checkboxes in datatable
            var items = $("[name='ids[]']");
            
            // remove all the previous selected checkboxes form the hidden input
            $('[name="e_pids[]"]').remove();
            
            // process all the checkboxes
            $(items).each(function () {
                // check if the current checkbox is checked
                if (this.checked) { // checked
                    // store the id into a hidden input
                    $("#enableItems").append('<input type="hidden" name="e_pids[]" value="'+parseInt(this.value)+'" />');
                }
            });
        }
    //-------------------------------------------------------
    
    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
        function confirmDisableSelectedPosts () {
            
            // get all the checkboxes in datatable
            var items = $("[name='ids[]']");
            
            // remove all the previous selected checkboxes form the hidden input
            $('[name="d_pids[]"]').remove();
            
            // process all the checkboxes
            $(items).each(function () {
                // check if the current checkbox is checked
                if (this.checked) { // checked
                    // store the id into a hidden input
                    $("#disableItems").append('<input type="hidden" name="d_pids[]" value="'+parseInt(this.value)+'" />');
                }
            });
        }
    //-------------------------------------------------------
    
    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
        function confirmDeleteSelectedPosts () {
            
            // get all the checkboxes in datatable
            var items = $("[name='ids[]']");
            
            // remove all the previous selected checkboxes form the hidden input
            $('[name="rm_pids[]"]').remove();
            
            // process all the checkboxes
            $(items).each(function () {
                // check if the current checkbox is checked
                if (this.checked) { // checked
                    // store the id into a hidden input
                    $("#deleteItems").append('<input type="hidden" name="rm_pids[]" value="'+parseInt(this.value)+'" />');
                }
            });
        }
    //-------------------------------------------------------
    
</script>