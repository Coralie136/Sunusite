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
                        <span class="caption-subject"> Liste des articles </span>
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
                                    <a href="<?php echo site_url('admin/article/newArticle'); ?>" class="btn red-thunderbird"> Ajouter un article
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-9 right"> <!--Pour la selection: -->
                                <div class="btn-group actions">
                                    <a onclick="confirmEnableSelectedArticles()" data-toggle="modal" href="#confirmEnableSelectedArticles" class="btn green-meadow">
                                        Activer la s&eacute;lection <i class="fa fa-check"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDisableSelectedArticles()" data-toggle="modal" href="#confirmDisableSelectedArticles" class="btn red-thunderbird">
                                        D&eacute;sactiver la s&eacute;lection <i class="fa fa-times"></i>
                                    </a>
                                </div>
                                <div class="btn-group actions">
                                    <a onclick="confirmDeleteSelectedArticles()" data-toggle="modal" href="#confirmDeleteSelectedArticles" class="btn dark">
                                        Supprimer la s&eacute;lection <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php
                    $disabledChk    = '';
                    if (empty($articles)) {
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
                                <!-- <th> Vues </th> -->
                                <th> Actions </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($articles)) {
                                foreach($articles as $article) {

                                    // Set the correct message to display totals text
                                    $viewed = ((int)$article->lecture_article > 1) ? $article->lecture_article.' Vues' : $article->lecture_article.' Vue' ;
                                    ?>
                                    <tr class="odd gradeX">
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="checkboxes" name="ids[]" value="<?php echo $article->id_article; ?>" onchange="selectItems()" />
                                                <span></span>
                                            </label>
                                        </td>
                                        <td class="sbold">
                                            <a href="Javascript:;" class="btn btn-sm green-meadow" title="Afficher">
                                                <?php echo $article->titre_article; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <i><?php echo $this->fonctions->dDisplay($article->dateCreated_article); ?></i>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('admin/article/articlePhoto?aid='.$article->id_article); ?>" class="btn btn-sm purple" title="Ajouter des photos">
                                                <i class="fa fa-camera"></i>
                                            </a>

                                            <a href="<?php echo site_url('admin/article/newArticle?aid='.$article->id_article); ?>" class="btn btn-sm btn-outline blue-steel" title="Modifier">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <?php
                                            if ($article->statut_article == '0') {
                                                ?>

                                                <a onclick="confirmEnableArticle(<?php echo $article->id_article; ?>)"  data-toggle="modal" href="#confirmEnableArticle" class="btn btn-sm green-meadow" title="Activer">
                                                    <i class="fa fa-check"></i>
                                                </a>

                                                <?php
                                            } else if ($article->statut_article == '1') {
                                                ?>

                                                <a onclick="confirmDisableArticle(<?php echo $article->id_article; ?>)"  data-toggle="modal" href="#confirmDisableArticle" class="btn btn-sm red-thunderbird" title="D&eacute;sactiver">
                                                    <i class="fa fa-close"></i>
                                                </a>

                                                <?php
                                            }
                                            ?>

                                            <a onclick="confirmDeleteArticle(<?php echo $article->id_article; ?>)" data-toggle="modal" href="#confirmDeleteArticle" class="btn btn-sm dark" title="Supprimer">
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


<div class="modal fade" id="confirmEnableArticle" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/article/enableArticle'); ?>" method="POST" name="frm_enableArticle" id="frm_enableArticle" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-green-meadow" id="title-status">Remarque :</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Vous &ecirc;tes sur le point d'activer cet article. </p>
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


<div class="modal fade" id="confirmDisableArticle" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/article/disableArticle'); ?>" method="POST" name="frm_disableArticle" id="frm_disableArticle" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-red-thunderbird" id="title-status">Attention !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Vous &ecirc;tes sur le point de désactiver cet article. </p>
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


<div class="modal fade" id="confirmDeleteArticle" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/article/deleteArticle'); ?>" method="POST" name="frm_deleteArticle" id="frm_deleteArticle" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title font-dark" id="title-status">Confirmation de suppression !!!</h4>
                </div>
                <div class="modal-body" id="text-status">
                    <p> Voulez-vous d&eacute;finitivement supprimer cet article ? </p>
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


<div class="modal fade" id="confirmEnableSelectedArticles" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/article/enableSelectedArticles'); ?>" method="POST" name="frm_enableSelectedArticles" id="frm_enableSelectedArticles" class="form-horizontal">
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


<div class="modal fade" id="confirmDisableSelectedArticles" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/article/disableSelectedArticles'); ?>" method="POST" name="frm_disableSelectedArticles" id="frm_disableSelectedArticles" class="form-horizontal">
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


<div class="modal fade" id="confirmDeleteSelectedArticles" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo site_url('admin/article/deleteSelectedArticles'); ?>" method="POST" name="frm_deleteSelectedArticles" id="frm_deleteSelectedArticles" class="form-horizontal">
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

    function confirmDeleteArticle (rm_aid) {
        $('#rm_aid').val(rm_aid);
    }

    function confirmEnableArticle (e_aid) {
        $('#e_aid').val(e_aid);
    }

    function confirmDisableArticle (d_aid) {
        $('#d_aid').val(d_aid);
    }

    //-------------------------------------------------------
    // CONFIRM THE ACTION THEN GET ALL THE CHECKED CHECBOXES
    //-------------------------------------------------------
    function confirmEnableSelectedArticles () {

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
    function confirmDisableSelectedArticles () {

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
    function confirmDeleteSelectedArticles () {

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