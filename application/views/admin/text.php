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
                        <span class="caption-subject"> Gestion des textes </span>
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
                                    <a href="<?php echo site_url('admin/group/newText'); ?>" class="btn red-thunderbird"> Ajouter un texte
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-9 right"> <!--Pour la selection: -->
                                <div class="btn-group actions">
                                    <a onclick="confirmEnableSelectedTexts()" data-toggle="modal" href="#confirmEnableSelectedTexts" class="btn green-meadow">
                                        Activer la s&eacute;lection <i class="fa fa-check"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDisableSelectedTexts()" data-toggle="modal" href="#confirmDisableSelectedTexts" class="btn red-thunderbird"> 
                                        D&eacute;sactiver la s&eacute;lection <i class="fa fa-times"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDeleteSelectedTexts()" data-toggle="modal" href="#confirmDeleteSelectedTexts" class="btn dark">
                                        Supprimer la s&eacute;lection <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <?php
                        $disabledChk    = '';
                    if (empty($texts)) {
                        $disabledChk    = 'disabled="disabled"';
                    }
                    ?>
                    <form method="POST" action="<?php echo site_url('comptes/actions'); ?>">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" name="allId" onchange="checkItems()" <?php echo $disabledChk; ?> />
                                            <span></span>
                                        </label>
                                    </th>
                                    <th> Type </th>
                                    <th> Cont&eacute;nu </th>
                                    <th> Date </th>
                                    <th> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($texts)) {
                                
                                // Loop through texts and display each
                                foreach($texts as $text) {
                            ?>
                                <tr class="odd gradeX">
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" name="ids[]" value="<?php echo $text->id_texte; ?>" onchange="selectItems()" />
                                            <span></span>
                                        </label>
                                    </td>
                                    
                                    <td class="sbold">
                                        <a href="Javascript:;" class="btn btn-sm green-meadow" title="Afficher">
                                            <?php echo $text->nom_type_texte; ?>
                                        </a>
                                    </td>
                                    
                                    <td>
                                        <i><?php echo substr(strip_tags(nl2br($text->contenu_texte)), 0, 100).' [...]'; ?></i>
                                    </td>
                                    
                                    <td>
                                        <i><?php echo $this->fonctions->dtDisplay($text->dateCreated_texte); ?></i>
                                    </td>
                                    
                                    <td>                                        
                                        <a href="<?php echo site_url('admin/group/newText?tid='.$text->id_texte); ?>" class="btn btn-sm btn-outline blue-steel" title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <?php
                                        if ($text->statut_texte == '0') {
                                        ?>
                                        
                                            <a onclick="confirmEnableText(<?php echo $text->id_texte; ?>)"  data-toggle="modal" href="#confirmEnableText" class="btn btn-sm green-meadow" title="Activer">
                                                <i class="fa fa-check"></i>
                                            </a>

                                        <?php
                                        } else if ($text->statut_texte == '1') {
                                        ?>

                                            <a onclick="confirmDisableText(<?php echo $text->id_texte; ?>)"  data-toggle="modal" href="#confirmDisableText" class="btn btn-sm red-thunderbird" title="D&eacute;sactiver">
                                                <i class="fa fa-close"></i>
                                            </a>

                                        <?php
                                        }
                                        ?>

                                        <a onclick="confirmDeleteText(<?php echo $text->id_texte; ?>)" data-toggle="modal" href="#confirmDeleteText" class="btn btn-sm dark" title="Supprimer">
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


<div class="modal fade" id="confirmEnableText" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/enableText'); ?>" method="POST" name="frm_enableText" id="frm_enableText" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-green-meadow" id="title-status">Remarque :</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Vous &ecirc;tes sur le point d'activer ce texte. </p>
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


<div class="modal fade" id="confirmDisableText" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/disableText'); ?>" method="POST" name="frm_disableText" id="frm_disableText" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-red-thunderbird" id="title-status">Attention !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Vous &ecirc;tes sur le point de désactiver ce texte. </p>
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


<div class="modal fade" id="confirmDeleteText" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/deleteText'); ?>" method="POST" name="frm_deleteText" id="frm_deleteText" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-dark" id="title-status">Confirmation de suppression !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Voulez-vous d&eacute;finitivement supprimer ce texte ? </p>
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


<div class="modal fade" id="confirmEnableSelectedTexts" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/enableSelectedTexts'); ?>" method="POST" name="frm_enableSelectedTexts" id="frm_enableSelectedTexts" class="form-horizontal">
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


<div class="modal fade" id="confirmDisableSelectedTexts" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/disableSelectedTexts'); ?>" method="POST" name="frm_disableSelectedTexts" id="frm_disableSelectedTexts" class="form-horizontal">
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


<div class="modal fade" id="confirmDeleteSelectedTexts" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/deleteSelectedTexts'); ?>" method="POST" name="frm_deleteSelectedTexts" id="frm_deleteSelectedTexts" class="form-horizontal">
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
    
    var controller = 'ajax';
	var base_url = '<?php echo site_url(); //you have to load the "url_helper" to use this function ?>';
    
    function confirmDeleteText (rm_tid) {
        $('#rm_tid').val(rm_tid);
    }
    
    function confirmEnableText (e_tid) {
        $('#e_tid').val(e_tid);
    }
    
    function confirmDisableText (d_tid) {
        $('#d_tid').val(d_tid);
    }
    
    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
        function confirmEnableSelectedTexts () {
            
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
        function confirmDisableSelectedTexts () {
            
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
        function confirmDeleteSelectedTexts () {
            
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