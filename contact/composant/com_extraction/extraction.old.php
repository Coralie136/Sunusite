<?php

class Extraction {

    static function showAllExtraction() {
        ?>
        <!-- Angular -->
        <script src="services/js/angular/angular.min.js"></script>
        <script src="services/js/angular/angular-datatables.min.js"></script>
        <!-- Fin angular -->
        <!--<script src="composant/com_extraction/extraction.js"></script>-->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">
                        Tableau de bord
                    </h3>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="#" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">
                            -
                        </li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
								<span class="m-nav__link-text">
									Courrier
								</span>
                            </a>
                        </li>
                        <li class="m-nav__separator">
                            -
                        </li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
								<span class="m-nav__link-text">
									extraction
								</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="m-content">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Liste des courriers extrait
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body" ng-app="customerApp" ng-controller="customerController">
                        <!--<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                            <div class="pull-right">
                                <button type="button" class="btn btn-danger" id="modal_add_key" data-toggle="modal">
                                    <i class="fa fa-plus"></i> Ajouter
                                </button>
                            </div>
                        </div>-->
                        <table datatable="ng" dt-options="vm.dtOptions" class="table table-striped table-hover clo" id="examples" >
                            <thead>
                                <tr>
                                    <td>ID extractions</td>
                                    <td>Libelles</td>
                                    <td>Paramètres</td>
                                    <td>Nombre d'extraction</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
								<tr ng-repeat="extract in extractions" id="{{ extract.str_EXTRACTION_ID}}">
									<td>{{ extract.str_EXTRACTION_ID }}</td>
									<td>{{ extract.str_PARAM }}</td>
									<td>{{ extract.dt_CREATED }}</td>
									<td>{{ extract.int_NUMBER_EXTRACT }}</td>
									<td><a href="{{ extract.str_FILE }}" target="_blank" class=" btn-action-custom fa fa-download"  title="Télécharger le courrier"></a></td>
								</tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-success fade" id="modal_add_key" role="dialog">
            <div class="modal-dialog ">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div> 
                    <form class="form-horizontal" role="form" id="add_key_form">
                        <div class="modal-body">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="str_LIBELLE" class="col-sm-12 control-label">Libelle <span class="require">*</span> :</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="str_LIBELLE" name="str_LIBELLE" placeholder="extraction" type="text" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="str_DATE_DEBUT" class="col-sm-12 control-label">Date de début <span class="require">*</span> :</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control date_timepicker_start" id="str_DATE_DEBUT" name="str_DATE_DEBUT">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="str_DATE_FIN" class="col-sm-12 control-label">Date de fin <span class="require">*</span> :</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control date_timepicker_end" id="str_DATE_FIN" name="str_DATE_FIN">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger pull-right" id="saved" style="margin-left: 3px;">Enregistrer</button>
                            <button type="reset" class="btn btn-default pull-right" data-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal modal-success fade" id="modal_edit_key" role="dialog">
            <div class="modal-dialog ">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Modifier</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form class="form-horizontal" role="form" id="edit_key_form">
                        <div class="modal-body">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="str_LIBELLE_EDIT" class="col-sm-12 control-label">Libelle <span class="require">*</span> :</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="str_LIBELLE_EDIT" name="str_LIBELLE_EDIT" placeholder="extraction" type="text" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="str_DATE_DEBUT" class="col-sm-12 control-label">Date de début <span class="require">*</span> :</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control date_timepicker_start" id="str_DATE_DEBUT_EDIT" name="str_DATE_DEBUT">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="str_DATE_FIN" class="col-sm-12 control-label">Date de fin <span class="require">*</span> :</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control date_timepicker_end" id="str_DATE_FIN_EDIT" name="str_DATE_FIN">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="str_PHASE_ID" id="str_PHASE_ID" />
                            <button type="submit" class="btn btn-danger pull-right" id="saved_edit" style="margin-left: 3px;">Enregistrer</button>
                            <button type="reset" class="btn btn-default pull-right" data-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="composant/com_extraction/angular-extraction.js"></script>
        <!--<script>
            var app = angular.module('customerApp', ['datatables']);
            //console.log(app)
            app.controller('customerController', function($scope, $http){
                $http.get("/composant/com_extraction/controlerExtraction.php?task=getAllExtraction").success(function(data, status, headers, config){
                    $scope.extractions = data;
                });
            });
        </script>-->
        <?php

    }

}
