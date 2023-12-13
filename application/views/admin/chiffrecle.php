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
                        <span class="caption-subject"> Liste des chiffres clé </span>
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
                                    <a href="<?php echo site_url('admin/chiffrecle/newChiffreCle'); ?>" class="btn red-thunderbird"> Ajouter un chiffre clé
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-9 right"> 
                                <!--<div class="btn-group actions">
                                    <a onclick="confirmEnableSelectedchiffrecles()" data-toggle="modal" href="#confirmEnableSelectedchiffrecles" class="btn green-meadow">
                                        Activer la s&eacute;lection <i class="fa fa-check"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDisableSelectedchiffrecles()" data-toggle="modal" href="#confirmDisableSelectedchiffrecles" class="btn red-thunderbird">
                                        D&eacute;sactiver la s&eacute;lection <i class="fa fa-times"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmdeleteSelectedChiffrecles()" data-toggle="modal" href="#confirmdeleteSelectedChiffrecles" class="btn dark">
                                        Supprimer la s&eacute;lection <i class="fa fa-trash"></i>
                                    </a>
                                </div>-->
                            </div>
                        </div>

                    </div>

                    <?php
                    $disabledChk    = '';
                    if (empty($chiffre_cles)) {
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
                                <th> Titre </th>
                                <!-- <th> Description </th> -->
                                <th> Date </th>
                                <!-- <th> Vues </th> -->
                                <th> Actions </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($chiffre_cles)) {
                                foreach($chiffre_cles as $chiffrecle) {

                                    ?>
                                    <tr class="odd gradeX">
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="checkboxes" name="ids[]" value="<?php echo $chiffrecle->id_chiffre_cle; ?>" onchange="selectItems()" />
                                                <span></span>
                                            </label>
                                        </td>

                                        <td>
                                            <img src="<?php echo site_url('/upload/chiffre_cle/'.$chiffrecle->fichier_chiffre_cle); ?>" alt="image <?php echo $chiffrecle->titre_chiffre_cle; ?>" width="150" height="100" />
                                        </td>
                                        <td>
                                            <?php echo $chiffrecle->titre_chiffre_cle; ?>
                                        </td>

                                        <td>
                                            <i><?php echo $this->fonctions->dtDisplay($chiffrecle->dateCreated_chiffre_cle); ?></i>
                                        </td>

                                        <td>

                                            <a href="<?php echo site_url('admin/chiffrecle/newChiffreCle?aid='.$chiffrecle->id_chiffre_cle); ?>" class="btn btn-sm btn-outline blue-steel" title="Modifier">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <?php
                                            if ($chiffrecle->statut_chiffre_cle == '0') {
                                                ?>

                                                <a onclick="confirmenableChiffrecle(<?php echo $chiffrecle->id_chiffre_cle; ?>)"  data-toggle="modal" href="#confirmenableChiffrecle" class="btn btn-sm green-meadow" title="Activer">
                                                    <i class="fa fa-check"></i>
                                                </a>

                                                <?php
                                            } else if ($chiffrecle->statut_chiffre_cle == '1') {
                                                ?>

                                                <a onclick="confirmdisableChiffrecle(<?php echo $chiffrecle->id_chiffre_cle; ?>)"  data-toggle="modal" href="#confirmdisableChiffrecle" class="btn btn-sm red-thunderbird" title="D&eacute;sactiver">
                                                    <i class="fa fa-close"></i>
                                                </a>

                                                <?php
                                            }
                                            ?>

                                            <a onclick="confirmdeleteChiffrecle(<?php echo $chiffrecle->id_chiffre_cle; ?>)" data-toggle="modal" href="#confirmdeleteChiffrecle" class="btn btn-sm dark" title="Supprimer">
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


<div class="modal fade" id="confirmenableChiffrecle" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/chiffrecle/enableChiffrecle'); ?>" method="POST" name="frm_enableChiffrecle" id="frm_enableChiffrecle" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-green-meadow" id="title-status">Remarque :</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Vous &ecirc;tes sur le point d'activer cet chiffrecle. </p>
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


<div class="modal fade" id="confirmdisableChiffrecle" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/chiffrecle/disableChiffrecle'); ?>" method="POST" name="frm_disableChiffrecle" id="frm_disableChiffrecle" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-red-thunderbird" id="title-status">Attention !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Vous &ecirc;tes sur le point de désactiver cet chiffrecle. </p>
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


<div class="modal fade" id="confirmdeleteChiffrecle" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/chiffrecle/deleteChiffrecle'); ?>" method="POST" name="frm_deleteChiffrecle" id="frm_deleteChiffrecle" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-dark" id="title-status">Confirmation de suppression !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Voulez-vous d&eacute;finitivement supprimer cette ligne ? </p>
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


<div class="modal fade" id="confirmEnableSelectedchiffrecles" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/chiffrecle/enableSelectedchiffrecles'); ?>" method="POST" name="frm_enableSelectedchiffrecles" id="frm_enableSelectedchiffrecles" class="form-horizontal">
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


<div class="modal fade" id="confirmDisableSelectedchiffrecles" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/chiffrecle/disableSelectedchiffrecles'); ?>" method="POST" name="frm_disableSelectedchiffrecles" id="frm_disableSelectedchiffrecles" class="form-horizontal">
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


<div class="modal fade" id="confirmdeleteSelectedChiffrecles" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/chiffrecle/deleteSelectedChiffrecles'); ?>" method="POST" name="frm_deleteSelectedChiffrecles" id="frm_deleteSelectedChiffrecles" class="form-horizontal">
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

    function confirmdeleteChiffrecle (rm_aid) {
        $('#rm_aid').val(rm_aid);
    }

    function confirmenableChiffrecle (e_aid) {
        $('#e_aid').val(e_aid);
    }

    function confirmdisableChiffrecle (d_aid) {
        $('#d_aid').val(d_aid);
    }

    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
    function confirmEnableSelectedchiffrecles () {

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
    function confirmDisableSelectedchiffrecles () {

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
    function confirmdeleteSelectedChiffrecles () {

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