<div class="page-content">
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> <?php echo mb_strtoupper($page_title); ?> <br />
        <small>[ <?php echo ucfirst($page_description); ?> ]</small>
    </h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box red-thunderbird">
                <div class="portlet-title">
                    <div class="caption font-light">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject uppercase"> Gestion des historiques </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                                
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
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="btn-group">
                                    <a onclick="frmHistory(0, false)" data-toggle="modal" href="#frmHistory" class="btn red-thunderbird"> Ajouter un historique
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-md-9 right"> <!--Pour la selection: -->
                                <div class="btn-group actions">
                                    <a onclick="confirmEnableSelectedHistories()" data-toggle="modal" href="#confirmEnableSelectedHistories" class="btn green-meadow">
                                        Activer la s&eacute;lection <i class="fa fa-check"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDisableSelectedHistories()" data-toggle="modal" href="#confirmDisableSelectedHistories" class="btn red-thunderbird"> 
                                        D&eacute;sactiver la s&eacute;lection <i class="fa fa-times"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDeleteSelectedHistories()" data-toggle="modal" href="#confirmDeleteSelectedHistories" class="btn dark">
                                        Supprimer la s&eacute;lection <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <?php
                        $disabledChk    = '';
                    if (empty($histories)) {
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
                            if (isset($histories)) {
        
                                // Set an array of all the month available in a year
                                $month  = array(
                                    '0'     => '',
                                    '1'     => 'Janvier',
                                    '2'     => 'Février',
                                    '3'     => 'Mars',
                                    '4'     => 'Avril',
                                    '5'     => 'Mai',
                                    '6'     => 'Juin',
                                    '7'     => 'Juillet',
                                    '8'     => 'Août',
                                    '9'     => 'Septembre',
                                    '10'    => 'Octobre',
                                    '11'    => 'Novembre',
                                    '12'    => 'Décembre',
                                );
                                
                                // Loop through histories and display each
                                foreach($histories as $history) {
                                    
                                    // Set the history period
                                    $mois_historique = (int)$history->mois_historique;
                                    $annee_historique = (int)$history->annee_historique;
                                    $historyMonth   = (!empty($mois_historique)) ? (int)$history->mois_historique : 0;
                                    $historyYear    = (!empty($annee_historique)) ? (int)$history->annee_historique : date('Y');
                                    $historyPeriod  = ucfirst($month[$historyMonth]).' '.$historyYear;
                            ?>
                                <tr class="odd gradeX">
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" name="ids[]" value="<?php echo $history->id_historique; ?>" onchange="selectItems()" />
                                            <span></span>
                                        </label>
                                    </td>

                                    <td class="sbold">
                                        <a onclick="frmHistory(<?php echo $history->id_historique; ?>, true)" data-toggle="modal" href="#frmHistory" class="btn btn-sm blue-steel" title="D&eacute;tails">
                                            <i><?php echo ucwords($historyPeriod); ?></i>
                                        </a>
                                    </td>

                                    <td>
                                        <i><?php echo $history->texte_historique; ?></i>
                                    </td>
                                    
                                    <td>
                                        <a onclick="frmHistory(<?php echo $history->id_historique; ?>, true)" data-toggle="modal" href="#frmHistory" class="btn btn-sm blue-steel" title="D&eacute;tails">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </a>
                                        
                                        <a onclick="frmHistory(<?php echo $history->id_historique; ?>, false)" data-toggle="modal" href="#frmHistory" class="btn btn-sm btn-outline blue-steel" title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <?php
                                        if ($history->statut_historique == '0') {
                                        ?>

                                            <a onclick="confirmEnableHistory(<?php echo $history->id_historique; ?>)" data-toggle="modal" href="#confirmEnableHistory" class="btn btn-sm green-meadow" title="Activer">
                                                <i class="fa fa-check"></i>
                                            </a>

                                        <?php
                                        } else if ($history->statut_historique == '1') {
                                        ?>

                                            <a onclick="confirmDisableHistory(<?php echo $history->id_historique; ?>)" data-toggle="modal" href="#confirmDisableHistory" class="btn btn-sm red-thunderbird" title="D&eacute;sactiver">
                                                <i class="fa fa-close"></i>
                                            </a>

                                        <?php
                                        }
                                        ?>

                                        <a onclick="confirmDeleteHistory(<?php echo $history->id_historique; ?>)" data-toggle="modal" href="#confirmDeleteHistory" class="btn btn-sm dark" title="Supprimer">
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
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    
</div>


<div class="modal fade" id="confirmEnableHistory" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/enableHistory'); ?>" method="POST" name="frm_enableHistory" id="frm_enableHistory" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-green-meadow" id="title-status">Remarque :</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Vous &ecirc;tes sur le point d'activer cet historique. </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline green-meadow" value="Annuler" />
                        <button type="submit" class="btn green-meadow">Activer <i class="fa fa-check"></i></button>
                        <input type="hidden" name="e_hid" id="e_hid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmDisableHistory" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/disableHistory'); ?>" method="POST" name="frm_disableHistory" id="frm_disableHistory" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-red-thunderbird" id="title-status">Attention !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Vous &ecirc;tes sur le point de désactiver cet historique. </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline red-thunderbird" value="Annuler" />
                        <button type="submit" class="btn red-thunderbird">Désactiver <i class="fa fa-times"></i></button>
                        <input type="hidden" name="d_hid" id="d_hid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmDeleteHistory" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/deleteHistory'); ?>" method="POST" name="frm_deleteHistory" id="frm_deleteHistory" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-dark" id="title-status">Confirmation de suppression !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                        <p> Voulez-vous d&eacute;finitivement supprimer cet historique ? </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline dark" value="Annuler" />
                        <button type="submit" class="btn dark">Supprimer <i class="fa fa-trash"></i></button>
                        <input type="hidden" name="rm_hid" id="rm_hid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmEnableSelectedHistories" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/enableSelectedHistories'); ?>" method="POST" name="frm_enableSelectedHistories" id="frm_enableSelectedHistories" class="form-horizontal">
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


<div class="modal fade" id="confirmDisableSelectedHistories" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/disableSelectedHistories'); ?>" method="POST" name="frm_disableSelectedHistories" id="frm_disableSelectedHistories" class="form-horizontal">
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


<div class="modal fade" id="confirmDeleteSelectedHistories" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/deleteSelectedHistories'); ?>" method="POST" name="frm_deleteSelectedHistories" id="frm_deleteSelectedHistories" class="form-horizontal">
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


<div class="modal fade bs-modal-lg" id="frmHistory" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="displayFrmHistory">
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script type="text/javascript">
    
    var controller = 'admin/ajax';
    var base_url = '<?php echo site_url(); //you have to load the "url_helper" to use this function ?>';
    
    function confirmDeleteHistory (rm_hid) {
        $('#rm_hid').val(rm_hid);
    }
    
    function confirmEnableHistory (e_hid) {
        $('#e_hid').val(e_hid);
    }
    
    function confirmDisableHistory (d_hid) {
        $('#d_hid').val(d_hid);
    }
    
    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
        function confirmEnableSelectedHistories () {
            
            // get all the checkboxes in datatable
            var items = $("[name='ids[]']");
            
            // remove all the previous selected checkboxes form the hidden input
            $('[name="e_hids[]"]').remove();
            
            // process all the checkboxes
            $(items).each(function () {
                // check if the current checkbox is checked
                if (this.checked) { // checked
                    // store the id into a hidden input
                    $("#enableItems").append('<input type="hidden" name="e_hids[]" value="'+parseInt(this.value)+'" />');
                }
            });
        }
    //-------------------------------------------------------
    
    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
        function confirmDisableSelectedHistories () {
            
            // get all the checkboxes in datatable
            var items = $("[name='ids[]']");
            
            // remove all the previous selected checkboxes form the hidden input
            $('[name="d_hids[]"]').remove();
            
            // process all the checkboxes
            $(items).each(function () {
                // check if the current checkbox is checked
                if (this.checked) { // checked
                    // store the id into a hidden input
                    $("#disableItems").append('<input type="hidden" name="d_hids[]" value="'+parseInt(this.value)+'" />');
                }
            });
        }
    //-------------------------------------------------------
    
    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
        function confirmDeleteSelectedHistories () {
            
            // get all the checkboxes in datatable
            var items = $("[name='ids[]']");
            
            // remove all the previous selected checkboxes form the hidden input
            $('[name="rm_hids[]"]').remove();
            
            // process all the checkboxes
            $(items).each(function () {
                // check if the current checkbox is checked
                if (this.checked) { // checked
                    // store the id into a hidden input
                    $("#deleteItems").append('<input type="hidden" name="rm_hids[]" value="'+parseInt(this.value)+'" />');
                }
            });
        }
    //-------------------------------------------------------
    
    //--------------------------------------------------------------------------------
    // LOAD AND DISPLAY A FORM (EMPTY OR FILLED WITH APPRECIATION INFOS) INTO A MODAL
    //--------------------------------------------------------------------------------
        function frmHistory (hid, read) {
            $.ajax({
                'url': base_url + controller + '/loadHistory/',
                'type': 'GET', //the way you want to send data to your URL
                'data': {
                    'hid':      hid, // history's id
                    'readOnly': read, // data state
                },
                'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                    var displayFrmHistory  = $('#displayFrmHistory'); //jquery selector (get element by id)
                    if (data) {
                        displayFrmHistory.html(data);
                        
                        $('#slt_month').select2({
                            placeholder:    'Choisir un mois',
                            language: {
                                noResults: function(params) {
                                    return "Aucun mois disponible";
                                }
                            },
                        });
                        
                        $('#slt_year').select2({
                            placeholder:    'Choisir une année',
                            language: {
                                noResults: function(params) {
                                    return "Aucune année disponible";
                                }
                            },
                        });
                    }
                }
            });
        }
    //--------------------------------------------------------------------------------
    
</script>