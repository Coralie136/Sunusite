

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
                        <span class="caption-subject"> Liste des pays </span>
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
                                    <a href="<?php echo site_url('admin/pays/newPays'); ?>" class="btn red-thunderbird"> Ajouter un Pays
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-9 right"> <!--Pour la selection: -->
                                <div class="btn-group actions">
                                    <a onclick="confirmEnableSelectedpays()" data-toggle="modal" href="#confirmEnableSelectedpays" class="btn green-meadow">
                                        Activer la s&eacute;lection <i class="fa fa-check"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDisableSelectedpays()" data-toggle="modal" href="#confirmDisableSelectedpays" class="btn red-thunderbird">
                                        D&eacute;sactiver la s&eacute;lection <i class="fa fa-times"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDeleteSelectedpays()" data-toggle="modal" href="#confirmDeleteSelectedpays" class="btn dark">
                                        Supprimer la s&eacute;lection <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php
                    $disabledChk    = '';
                    if (empty($pays)) {
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
                                <th> Pays FR </th>
                                <th> Pays EN </th>
                                <th> Site </th>
                                <th> Mon bon profile </th>
                                <th> Actions </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($payss)) {
                                foreach($payss as $pays) {
                            ?>
                                    <tr class="odd gradeX">
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="checkboxes" name="ids[]" value="<?php echo $pays->id_pays; ?>" onchange="selectItems()" />
                                                <span></span>
                                            </label>
                                        </td>

                                        <td>
                                            <?php echo $pays->nom_pays; ?>
                                        </td>

                                        <td>
                                            <?php echo $pays->nom_pays_en; ?>
                                        </td>

                                        <td>
                                            <a href="<?php echo $pays->lien_site; ?>" target="_blank"><?php echo $pays->lien_site; ?></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo $pays->lien_mbp; ?>" target="_blank"><?php echo $pays->lien_mbp; ?></a>
                                        </td>

                                        <td>
                                            <a href="<?php echo site_url('admin/pays/newPays?aid='.$pays->id_pays); ?>" class="btn btn-sm btn-outline blue-steel" title="Modifier">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="confirmDeletePays(<?php echo $pays->id_pays; ?>)" data-toggle="modal" href="#confirmDeletePays" class="btn btn-sm dark" title="Supprimer">
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


<div class="modal fade" id="confirmEnablePays" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/pays/enablePays'); ?>" method="POST" name="frm_enablePays" id="frm_enablePays" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-green-meadow" id="title-status">Remarque :</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Vous &ecirc;tes sur le point d'activer ce pays. </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline green-meadow" value="Annuler" />
                        <button type="submit" class="btn green-meadow">Activer <i class="fa fa-check"></i></button>
                        <input type="hidden" name="e_aid" id="e_aid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmDisablePays" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/pays/disablePays'); ?>" method="POST" name="frm_disablePays" id="frm_disablePays" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-red-thunderbird" id="title-status">Attention !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Vous &ecirc;tes sur le point de désactiver ce pays. </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline red-thunderbird" value="Annuler" />
                        <button type="submit" class="btn red-thunderbird">Désactiver <i class="fa fa-times"></i></button>
                        <input type="hidden" name="d_aid" id="d_aid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmDeletePays" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/pays/deletePays'); ?>" method="POST" name="frm_deletePays" id="frm_deletePays" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-dark" id="title-status">Confirmation de suppression !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Voulez-vous d&eacute;finitivement supprimer ce pays ? </p>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <input type="button" data-dismiss="modal" class="btn btn-outline dark" value="Annuler" />
                        <button type="submit" class="btn dark">Supprimer <i class="fa fa-trash"></i></button>
                        <input type="hidden" name="rm_aid" id="rm_aid" value="" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="confirmEnableSelectedpays" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/pays/enableSelectedpays'); ?>" method="POST" name="frm_enableSelectedpays" id="frm_enableSelectedpays" class="form-horizontal">
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


<div class="modal fade" id="confirmDisableSelectedpays" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/pays/disableSelectedpays'); ?>" method="POST" name="frm_disableSelectedpays" id="frm_disableSelectedpays" class="form-horizontal">
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


<div class="modal fade" id="confirmDeleteSelectedpays" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/pays/deleteSelectedpays'); ?>" method="POST" name="frm_deleteSelectedpays" id="frm_deleteSelectedpays" class="form-horizontal">
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

    function confirmDeletePays (rm_aid) {
        $('#rm_aid').val(rm_aid);
    }

    function confirmEnablePays (e_aid) {
        $('#e_aid').val(e_aid);
    }

    function confirmDisablePays (d_aid) {
        $('#d_aid').val(d_aid);
    }

    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
    function confirmEnableSelectedpays () {

        // get all the checkboxes in datatable
        var items = $("[name='ids[]']");

        // remove all the previous selected checkboxes form the hidden input
        $('[name="e_aids[]"]').remove();

        // process all the checkboxes
        $(items).each(function () {
            // check if the current checkbox is checked
            if (this.checked) { // checked
                // store the id into a hidden input
                $("#enableItems").append('<input type="hidden" name="e_aids[]" value="'+parseInt(this.value)+'" />');
            }
        });
    }
    //-------------------------------------------------------

    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
    function confirmDisableSelectedpays () {

        // get all the checkboxes in datatable
        var items = $("[name='ids[]']");

        // remove all the previous selected checkboxes form the hidden input
        $('[name="d_aids[]"]').remove();

        // process all the checkboxes
        $(items).each(function () {
            // check if the current checkbox is checked
            if (this.checked) { // checked
                // store the id into a hidden input
                $("#disableItems").append('<input type="hidden" name="d_aids[]" value="'+parseInt(this.value)+'" />');
            }
        });
    }
    //-------------------------------------------------------

    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
    function confirmDeleteSelectedpays () {

        // get all the checkboxes in datatable
        var items = $("[name='ids[]']");

        // remove all the previous selected checkboxes form the hidden input
        $('[name="rm_aids[]"]').remove();

        // process all the checkboxes
        $(items).each(function () {
            // check if the current checkbox is checked
            if (this.checked) { // checked
                // store the id into a hidden input
                $("#deleteItems").append('<input type="hidden" name="rm_aids[]" value="'+parseInt(this.value)+'" />');
            }
        });
    }
    //-------------------------------------------------------

</script>