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
                        <span class="caption-subject"> Liste des filiales </span>
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
                                    <a href="<?php echo site_url('admin/filiale/newFiliale'); ?>" class="btn red-thunderbird"> Ajouter une filiale
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-9 right">
                                <!--<div class="btn-group actions">
                                    <a onclick="confirmEnableSelectedFiliales()" data-toggle="modal" href="#confirmEnableSelectedFiliale" class="btn green-meadow">
                                        Activer la s&eacute;lection <i class="fa fa-check"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDisableSelectedFiliales()" data-toggle="modal" href="#confirmDisableSelectedFiliale" class="btn red-thunderbird">
                                        D&eacute;sactiver la s&eacute;lection <i class="fa fa-times"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDeleteSelectedFiliale()" data-toggle="modal" href="#confirmDeleteSelectedFiliale" class="btn dark">
                                        Supprimer la s&eacute;lection <i class="fa fa-trash"></i>
                                    </a>
                                </div>-->
                            </div>
                        </div>

                    </div>

                    <?php
                    $disabledChk    = '';
                    if (empty($filiales)) {
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
                                <th> Images </th>
                                <th> Pays </th>
                                <th> Titre (Français) </th>
                                <th> Titre (Anglais) </th>
                                <th> Lien du site </th>
                                <th> Actions </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            //var_dump($filiales); die();
                            if (isset($filiales)) {
                                foreach($filiales as $filiale) {

                                    ?>
                                    <tr class="odd gradeX">
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="checkboxes" name="ids[]" value="<?php echo $filiale->id_description; ?>" onchange="selectItems()" />
                                                <span></span>
                                            </label>
                                        </td>

                                        <td class="sbold">
                                            <b>
                                                <img src="<?php echo site_url('/upload/filiale/'.$filiale->image) ?>" alt="<?php echo $filiale->nom_pays; ?>" width="130" height="100">
                                                <br>
                                                <i><?php echo $this->fonctions->dtDisplay($filiale->dateCreated_description); ?></i>
                                            </b>
                                        </td>
                                        <td class="sbold">
                                            <b><?php echo $filiale->nom_pays; ?></b>
                                        </td>

                                        <td>
                                            <?php echo $filiale->titre_fr; ?>
                                        </td>

                                        <td>
                                            <?php echo $filiale->titre_en; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo $filiale->lien_site_description; ?>" target="_blank"><?php echo $filiale->lien_site_description; ?></a>
                                        </td>
                                        <td>


                                            <a href="<?php echo site_url('admin/filiale/newFiliale?aid='.$filiale->id_description); ?>" class="btn btn-sm btn-outline blue-steel" title="Modifier">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="confirmDeleteFiliale(<?php echo $filiale->id_description; ?>)" data-toggle="modal" href="#confirmDeleteFiliale" class="btn btn-sm dark" title="Supprimer">
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


<div class="modal fade" id="confirmEnableFiliale" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/Filiale/enableFiliale'); ?>" method="POST" name="frm_enableFiliale" id="frm_enableFiliale" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-green-meadow" id="title-status">Remarque :</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Vous &ecirc;tes sur le point d'activer cet administrateur. </p>
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


<div class="modal fade" id="confirmDisableFiliale" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/Filiale/disableFiliale'); ?>" method="POST" name="frm_disableFiliale" id="frm_disableFiliale" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-red-thunderbird" id="title-status">Attention !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Vous &ecirc;tes sur le point de désactiver cet Filiale. </p>
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


<div class="modal fade" id="confirmDeleteFiliale" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/filiale/deleteFiliale'); ?>" method="POST" name="frm_deleteFiliale" id="frm_deleteFiliale" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-dark" id="title-status">Confirmation de suppression !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Voulez-vous d&eacute;finitivement supprimer cet administrateur ? </p>
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


<div class="modal fade" id="confirmEnableSelectedFiliales" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/Filiale/enableSelectedFiliales'); ?>" method="POST" name="frm_enableSelectedFiliales" id="frm_enableSelectedFiliales" class="form-horizontal">
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


<div class="modal fade" id="confirmDisableSelectedFiliales" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/Filiale/disableSelectedFiliales'); ?>" method="POST" name="frm_disableSelectedFiliales" id="frm_disableSelectedFiliales" class="form-horizontal">
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


<div class="modal fade" id="confirmDeleteSelectedFiliale" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/Filiale/deleteSelectedFiliales'); ?>" method="POST" name="frm_deleteSelectedFiliales" id="frm_deleteSelectedFiliales" class="form-horizontal">
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

    function confirmDeleteFiliale (rm_aid) {
        $('#rm_aid').val(rm_aid);
    }

    function confirmEnableFiliale (e_aid) {
        $('#e_aid').val(e_aid);
    }

    function confirmDisableFiliale (d_aid) {
        $('#d_aid').val(d_aid);
    }

    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
    function confirmEnableSelectedFiliales () {

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
    function confirmDisableSelectedFiliales () {

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
    function confirmDeleteSelectedFiliale () {

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