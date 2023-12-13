<?php

class Table {

    static function showAllTable() {
        ?>
        <script src="composant/com_table/table.js"></script>
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4><span class="str_COUNTRY"></span> : Administrateur filiale</h4>
                </div>
                <div class="col-sm-6 text-right">
                    <ol class="breadcrumb">
                        <li><a href="javascript: void(0);"><i class="icon-home"></i> </a></li>
                        <li>Tableau de bord</li> <li>Liste des clients</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="" id="filtre">
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="page-title">Filtre</h4><hr>
                            </div>
                            <div class="panel-body">
                                <form action="/action_page.php" role="form" id="form_filter">
                                    <div class="col-lg-4 col-sm-3">
                                        <div class="form-group">
                                            <label for="str_DATE_DEBUT">Date de début :</label>
                                            <input type="text" class="form-control date_timepicker_start " id="str_DATE_DEBUT" name="str_DATE_DEBUT">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-3">
                                        <div class="form-group">
                                            <label for="str_DATE_FIN">Date de fin :</label>
                                            <input type="text" class="form-control date_timepicker_end " id="str_DATE_FIN" name="str_DATE_FIN">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-3">
                                        <div class="form-group">
                                            <label for="str_ASSURABLE">Assurables :</label>
                                            <select name="str_ASSURABLE[]" id="str_ASSURABLE" class="form-control select2me" multiple="" >
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-3">
                                        <div class="form-group">
                                            <label for="lg_AGE_ID">Age :</label>
                                            <select name="lg_AGE_ID" id="lg_AGE_ID" class="form-control select2me" >
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-3">
                                        <div class="form-group">
                                            <label for="lg_SOUSCRIPTION_ID">Souscription :</label>
                                            <select name="lg_SOUSCRIPTION_ID" id="lg_SOUSCRIPTION_ID" class="form-control select2me" >
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-3">
                                        <div class="form-group">
                                            <label for="lg_CATEGORIE_ID">Catégorie socio pro. :</label>
                                            <select name="lg_CATEGORIE_ID" id="lg_CATEGORIE_ID" class="form-control select2me" >
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-danger" >
                <div class="panel-heading" style="text-transform: none !important;background-color:#c8234a !important" id="nombre_element_contenainer">
                    <span class="str_COUNTRY"></span> : <span id="current_elements"></span><span id="nombre_element"></span> clients
                    <button type="button" class="pull-right btn btn-default btn-outline btn-sm" id="modal_add_key" data-toggle="modal">
                        <!--<i class="fa fa-file-excel-o"></i>--> Exporter
                    </button>
                </div>
                <div class="panel-body table-responsive">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="pagination">
                                <li class="paginate_button page-item first" id="precedent" style="cursor: pointer">
                                    <a  aria-controls="m_table_1" data-dt-idx="0" tabindex="0" class="page-link">
                                        <i class="angle-double-left" ><< Précédent</i>
                                    </a>
                                </li>
                                <li class="paginate_button page-item last" id="suivant" style="cursor: pointer">
                                    <a  aria-controls="m_table_1" data-dt-idx="8" tabindex="0" class="page-link">
                                        <i class="angle-double-right" >Suivant >></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <table class="table table-striped table-hover clo" id="examples" >
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Nom et Prénom(s)</td>
                                <td>E-mail</td>
                                <td>Téléphone</td>
                                <td>Date d'inscription</td>
                                <td>Pays</td>
                                <td>Catégorie socio-pro.</td>
                                <td>T. âge</td>
                                <td>Montant</td>
                                <td>Assurables</td>
                                <td>Action</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal modal-success fade" id="modal_add_key" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Ajouter</h4>
                    </div>
                    <form class="form-horizontal" role="form" id="add_key_form">
                        <div class="modal-body">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="str_NAME" class="col-sm-4 control-label">Nom du fichier <span class="require">*</span> :</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" id="str_FILE_NAME" name="str_FILE_NAME" placeholder="Nom du fichier" type="text" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="services/document_uploader/sinistre_traite.xls" id="download" class="hidden btn btn-default"><i class="icon icon-download"></i>Telecharger</a>
                            <button type="submit" class="btn btn-warning pull-right" id="saved" style="background-color:#c8234a !important; margin-left: 3px;">Enregistrer</button>
                            <button type="reset" class="btn btn-default pull-right" data-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--
        <div class="modal modal-success fade" id="modal_add_key" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Ajouter</h4>
                    </div> 
                    <form class="form-horizontal" role="form" id="add-key-form">
                        <div class="modal-body">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="str_WORDING" class="col-sm-4 control-label">Libellé <span class="require">*</span> :</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" id="str_WORDING" name="str_WORDING" placeholder="Nom" type="text" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="int_NUMBER_PLACE" class="col-sm-4 control-label">Nombre place <span class="require">*</span> :</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" id="int_NUMBER_PLACE" name="int_NUMBER_PLACE" placeholder="4" type="number" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning pull-right" style="margin-left: 3px;">Enregistrer</button>
                            <button type="reset" class="btn btn-default pull-right" data-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal modal-success fade" id="modal_edit_key" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modification</h4>
                    </div> 
                    <form class="form-horizontal" role="form" id="edit-key-form">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="str_WORDING" class="col-sm-4 control-label">Libellé <span class="require">*</span> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_WORDING" name="str_WORDING" placeholder="Nom" type="text" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="int_NUMBER_PLACE" class="col-sm-4 control-label">Nombre place <span class="require">*</span> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="int_NUMBER_PLACE" name="int_NUMBER_PLACE" placeholder="4" type="number" required="">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input id="lg_TABLE_ID" name="lg_TABLE_ID" type="hidden">
                            <button type="submit" class="btn btn-warning pull-right" style="margin-left: 3px;">Enregistrer</button>
                            <button type="reset" class="btn btn-default pull-right" data-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>

            </div>
        </div> -->
        <?php

    }

}
