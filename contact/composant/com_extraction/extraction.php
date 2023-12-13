<?php

class Extraction {

    static function showAllExtraction() {
        ?>

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
                                <h3 style="display: none" id="nombre_element_contenainer" class="m-portlet__head-text">
                                    <span id="nombre_element"></span> courriers extrait
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body" ng-app="customerApp" ng-controller="customerController">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="pagination">
                                    <li class="paginate_button page-item first" id="precedent">
                                        <a  aria-controls="m_table_1" data-dt-idx="0" tabindex="0" class="page-link">
                                            <i class="la la-angle-double-left"></i>
                                        </a>
                                    </li>
                                    <li class="paginate_button page-item last" id="suivant">
                                        <a  aria-controls="m_table_1" data-dt-idx="8" tabindex="0" class="page-link">
                                            <i class="la la-angle-double-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <table  class="table table-striped table-hover clo" id="list_courrier" >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>ID extractions</th>
                                <th>Libelles</th>
                                <th>Paramètres</th>
                                <th>Nombre d'extraction</th>
                                <th>Actions</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>
                                    <input id="id" type="text" class="critere form-control" placeholder="Id">
                                </th>
                                <th>
                                    <input id="libelle" type="text" class="critere form-control" placeholder="libelle">
                                </th>
                                <th>
                                    <input id="params" type="text" class="critere form-control" placeholder="parametre">
                                </th>
                                <th>
                                    <input id="nbre" type="text" class="critere form-control" placeholder="nombre extraction">
                                </th>
                            </tr>
                            </thead>
                            <tbody id="tbody">

                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>


        <script src="composant/com_extraction/extraction.js"></script>

        <?php
    }
}
        ?>