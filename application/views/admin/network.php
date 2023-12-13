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
                        <span class="caption-subject"> Gestion du r&eacute;seau </span>
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
                                    <a href="<?php echo site_url('admin/group/newNetwork'); ?>" class="btn red-thunderbird"> Ajouter
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div><!--
                            <div class="col-md-9 right">
                                <div class="btn-group actions">
                                    <a onclick="confirmEnableSelectedNetworks()" data-toggle="modal" href="#confirmEnableSelectedNetworks" class="btn green-meadow">
                                        Activer la s&eacute;lection <i class="fa fa-check"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDisableSelectedNetworks()" data-toggle="modal" href="#confirmDisableSelectedNetworks" class="btn red-thunderbird">
                                        D&eacute;sactiver la s&eacute;lection <i class="fa fa-times"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDeleteSelectedNetworks()" data-toggle="modal" href="#confirmDeleteSelectedNetworks" class="btn dark">
                                        Supprimer la s&eacute;lection <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>-->
                        </div>

                    </div>

                    <?php
                    $disabledChk    = '';
                    if (empty($networks)) {
                        $disabledChk    = 'disabled="disabled"';
                    }
                    ?>
                    <form method="POST" action="<?php echo site_url('admin/comptes/actions'); ?>">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                            <tr>
                                <th>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="radio" class="group-checkable" data-set="#sample_1 .checkboxes" name="allId" onchange="checkItems()" <?php echo $disabledChk; ?> />
                                        <span></span>
                                    </label>
                                </th>
                                <th> Facebook </th>
                                <th> Linkedin </th>
                                <th> Sunu santé </th>
                                <th> Actions </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($networks)) {
                                foreach($networks as $network) {

                                     ?>
                                    <tr class="odd gradeX">
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="radio"
                                                       <?php echo ($network->is_active==1?'checked="checked"':''); ?>
                                                       class="checkboxes" name="ids"
                                                       value="<?php echo $network->id_reseau_social; ?>"
                                                       onchange="selectItems()"
                                                />
                                                <span></span>
                                            </label>
                                        </td>

                                        <td>
                                            <i> <a href="<?php echo $network->facebook; ?>" target="_blank"><?php echo $network->facebook; ?></a> </i>
                                        </td>
                                        <td>
                                            <i><a href="<?php echo $network->linkedin; ?>" target="_blank"><?php echo $network->linkedin; ?></a></i>
                                        </td>
                                        <td>
                                            <i><a href="<?php echo $network->sunu_sante; ?>" target="_blank"><?php echo $network->sunu_sante; ?></a></i>
                                        </td>

                                        <td>

                                            <a href="<?php echo site_url('admin/group/newNetwork?tid='.$network->id_reseau_social); ?>" class="btn btn-sm btn-outline blue-steel" title="Modifier">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <?php
                                            if ($network->is_active == '0') {
                                                ?>

                                                <a onclick="confirmEnableNetwork(<?php echo $network->id_reseau_social; ?>)"  data-toggle="modal" href="#confirmEnableNetwork" class="btn btn-sm green-meadow" title="Activer">
                                                    <i class="fa fa-check"></i>
                                                </a>

                                                <a onclick="confirmDeleteNetwork(<?php echo $network->id_reseau_social; ?>)" data-toggle="modal" href="#confirmDeleteNetwork" class="btn btn-sm dark" title="Supprimer">
                                                    <i class="fa fa-trash"></i>
                                                </a>

                                                <?php
                                            } /*else if ($network->is_active == '1') {
                                                ?>

                                                <a onclick="confirmDisableNetwork(<?php echo $network->id_reseau_social; ?>)"  data-toggle="modal" href="#confirmDisableNetwork" class="btn btn-sm red-thunderbird" title="D&eacute;sactiver">
                                                    <i class="fa fa-close"></i>
                                                </a>

                                                <?php
                                            }*/
                                            ?>

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


<div class="modal fade" id="confirmEnableNetwork" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/enableNetwork'); ?>" method="POST" name="frm_enableNetwork" id="frm_enableNetwork" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-green-meadow" id="title-status">Remarque :</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Vous &ecirc;tes sur le point d'activer les liens. </p>
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


<div class="modal fade" id="confirmDisableNetwork" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/disableNetwork'); ?>" method="POST" name="frm_disableNetwork" id="frm_disableNetwork" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-red-thunderbird" id="title-status">Attention !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Vous &ecirc;tes sur le point de désactiver les liens. </p>
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


<div class="modal fade" id="confirmDeleteNetwork" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/deleteNetwork'); ?>" method="POST" name="frm_deleteNetwork" id="frm_deleteNetwork" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-dark" id="title-status">Confirmation de suppression !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Voulez-vous d&eacute;finitivement supprimer les liens ? </p>
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


<div class="modal fade" id="confirmEnableSelectedNetworks" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/enableSelectedNetworks'); ?>" method="POST" name="frm_enableSelectedNetworks" id="frm_enableSelectedNetworks" class="form-horizontal">
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


<div class="modal fade" id="confirmDisableSelectedNetworks" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/disableSelectedNetworks'); ?>" method="POST" name="frm_disableSelectedNetworks" id="frm_disableSelectedNetworks" class="form-horizontal">
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


<div class="modal fade" id="confirmDeleteSelectedNetworks" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/group/deleteSelectedNetworks'); ?>" method="POST" name="frm_deleteSelectedNetworks" id="frm_deleteSelectedNetworks" class="form-horizontal">
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

    function confirmDeleteNetwork (rm_tid) {
        $('#rm_tid').val(rm_tid);
    }

    function confirmEnableNetwork (e_tid) {
        $('#e_tid').val(e_tid);
    }

    function confirmDisableNetwork (d_tid) {
        $('#d_tid').val(d_tid);
    }

    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
    function confirmEnableSelectedNetworks () {

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
    function confirmDisableSelectedNetworks () {

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
    function confirmDeleteSelectedNetworks () {

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