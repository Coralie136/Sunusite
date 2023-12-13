<?php
if(!isset($_SESSION))
    session_start();
if(isset($_SESSION['statut_user']) && $_SESSION['statut_user'] == 0){
    include_once 'composant/com_security/form_update_password.php';
}
else {
    if (isset($_SESSION['str_SECURITY_ID']) && !empty($_SESSION['str_SECURITY_ID'])) {
        ?>
        <!DOCTYPE html>
        <html lang="fr">

        <!-- Mirrored from bootstraplovers.com/templates/float-admin-v1.1/light-version/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 22 Jul 2017 01:04:12 GMT -->
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
            <title> | Admin</title>

            <!-- Common plugins -->
            <script src="services/plugins/jquery/dist/jquery.min.js"></script>
            <link href="services/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="services/plugins/simple-line-icons/simple-line-icons.css" rel="stylesheet">
            <link href="services/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
            <link rel="stylesheet" href="services/plugins/nano-scroll/nanoscroller.css">
            <!-- Debut Insertion des bibliotheque de champs de recherche de liste deroulante et des data -->
            <link rel="stylesheet" type="text/css" href="services/css/select2/select2.min.css"/>

            <link rel="stylesheet" type="text/css" href="services/css/select-bootstrap/select2-bootstrap.min.css"/>
            <link rel="stylesheet" href="services/plugins/select2/select2.css"/>

            <link rel="stylesheet" href="services/plugins/datatables/jquery.dataTables.css"/>
            <link href="services/plugins/toast/jquery.toast.min.css" rel="stylesheet">
            <!--template css-->
            <link href="services/css/style.css" rel="stylesheet">
            <link rel="shortcut icon" href="services/img/logo_mbp.png"/>
            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
            <!-- fin data title
            <script src="services/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>-->
            <script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"
                    type="text/javascript"></script>
            <!--<script src="services/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>-->

            <link rel="stylesheet" href="services/plugins/select2/select2.css"/>

            <link rel="stylesheet" href="services/plugins/datatables/jquery.dataTables.css"/>
            <link rel="stylesheet" href="services/plugins/datatables/dataTables.bootstrap.css"/>
            <script src="services/js/jquery.session.js"></script>

            <script src="services/js/sweetalert.min.js"></script>
            <link rel="stylesheet" type="text/css" href="services/css/sweetalert.css">
            <script src="./services/js/bootstrap-notify.min.js"></script>

            <link rel="stylesheet" type="text/css" href="services/css/jquery.datetimepicker.css"/>
            <link href="services/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
            <!--datepicker -->
            <link rel="stylesheet" type="text/css" href="services/css/jquery.datetimepicker.css"/>
            <!--end datepicker -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
        </head>

        <body><!--oncontextmenu="return false;" onselectstart="return false" ondragstart="return false"-->
        <!--top bar start-->
        <div class="top-bar light-top-bar"><!--by default top bar is dark, add .light-top-bar class to make it light-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-6">
                        <a href="" class="admin-logo">
                            <h1><img src="services/img/logo.png" alt="Logo sunu" width="100" height="75" style="padding-bottom: 10px;"></h1>
                        </a>
                        <div class="left-nav-toggle visible-xs visible-sm">
                            <a href="#">
                                <i class="glyphicon glyphicon-menu-hamburger"></i>
                            </a>
                        </div><!--end nav toggle icon-->
                    </div>
                    <div class="col-xs-6">
                        <?php
                        include_once('topmenu.php');
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- top bar end-->
        <!--left navigation start-->
        <aside class="float-navigation light-navigation">
            <?php
            include('menu.php');
            ?>
        </aside>
        <!--left navigation end-->


        <!--main content start-->
        <section class="main-content container">
            <!--start page content-->
            <div class="row" id="contenue-application">

            </div>
            <!-- End content -->
        </section>
        <!--end main content-->

        <!-- Modal -->
        <div id="Modal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modification</h4>
                    </div>
                    <form class="form-horizontal" role="form" id="edit_key_form">
                        <div class="modal-body">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="str_PASSWORD" class="col-sm-4 control-label">Mot de passe <span
                                                class="require">*</span> :</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" minlength="8" id="str_PASSWORD" name="str_PASSWORD"
                                               placeholder="Nouveau mot de passe" type="password">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button style="background-color: #c8234a; border-color: #c8234a; " type="submit" class="btn btn-warning pull-right" id="saved"
                                    style="margin-left: 3px;">Enregistrer
                            </button>
                            <button type="reset" class="btn btn-default pull-right" data-dismiss="modal">Annuler
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- /Modal -->

        <!--Common plugins-->

        <!--<script src="services/js/jquery-ui.min.js"></script>-->
        <script src="services/plugins/bootstrap/js/bootstrap.min.js"></script>
        <!--<script src="services/plugins/pace/pace.min.js"></script>
        <script src="services/plugins/jasny-bootstrap/services/js/jasny-bootstrap.min.js"></script>-->
        <script src="services/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="services/plugins/nano-scroll/jquery.nanoscroller.min.js"></script>
        <script src="services/plugins/metisMenu/metisMenu.min.js"></script>
        <script src="services/js/float-custom.js"></script>
        <!-- iCheck for radio and checkboxes -->
        <script src="services/plugins/iCheck/icheck.min.js"></script>
        <!-- Message d'alert en vert -->
        <script src="services/plugins/toast/jquery.toast.min.js"></script>

        <!-- FIN Insertion des bibliotheque de champs de recherche dans une liste deroulante et des data -->
        <!-- Datatables-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/dataTables.bootstrap.js"></script>
        <script src="services/js/select2/bootstrap.min.js"></script>
        <script src="services/js/select2/anchor.min.js"></script>

        <script src="services/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="services/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="services/js/build/jquery.datetimepicker.full.js"></script>
        <script src="composant/com_security/security.js"></script>
        <!-- Fin js datepicker -->

        <!--<script src="services/js/build/jquery.datetimepicker.full.js"></script>-->
        <script>
            $('a[href$="#Modal"]').on("click", function () {
                $('#Modal').modal('show');
            });
            $('#edit_key_form').submit(function (e) {
                e.preventDefault();
                var str_PASSWORD = $('#edit_key_form #str_PASSWORD').val();
                editPassword(str_PASSWORD);
                $('#Modal').modal('hide');
            });

            function editPassword(str_PASSWORD) {
                $.ajax({
                    url: "composant/com_security/controlersecurity.php", // La ressource ciblée
                    type: 'POST', // Le type de la requête HTTP.
                    data: "task=str_PASSWORD&str_PASSWORD=" + str_PASSWORD,
                    dataType: 'text',
                    success: function (response) {
                        var obj = $.parseJSON(response);
                        if (obj[0].code_statut == "1") {
                            swal({
                                title: "Opération réussie !",
                                //text: "Operation reussi",
                                type: "success",
                                confirmButtonColor: '#c8234a',
                                confirmButtonText: "Ok"
                            });
                            //$('#modal').modal('hide');
                        } else {
                            swal({
                                title: "Echec de l'opéraion",
                                text: obj[0].results,
                                type: "error",
                                confirmButtonColor: '#c8234a',
                                confirmButtonText: "Ok"
                            });
                        }
                    }
                });
            }

            $.ajax("./services/center.php" + "?task=showHomeAdminPage")
                .done(function (data, status, jqxhr) {
                    $('#contenue-application').empty();
                    $('#contenue-application').append(jqxhr.responseText).fadeIn();
                });

            $('a.m_link').on('click', function (e) {
                e.preventDefault();
                var $btn = $(this);
                var task = $btn.attr('id');
                var content_top_number = "";
                //$.session.set("url_page", task);//en lien avec les boutons a afficher par pages

                $.ajax("./services/center.php" + "?task=" + task)
                    .done(function (data, status, jqxhr) {
                        $('#contenue-application').empty();
                        $('#contenue-application').html(jqxhr.responseText).fadeIn();
                    });
            });

            anchors.options.placement = 'left';
            anchors.add('.container h1, .container h2, .container h3, .container h4, .container h5');

            //$.fn.select2.defaults.set("theme", "bootstrap");

            var placeholder = "Selectionner un élément";

            $(".select2-single, .select2-multiple, .select2me").select2({
                placeholder: placeholder,
                width: null,
                containerCssClass: ':all:'
            });
            $(document).ready(function () {
                $.ajax("./services/center.php" + "?task=showAllMenu")
                    .done(function (data, status, jqxhr) {
                        $('#IdgetMenu').empty();
                        $('#IdgetMenu').append(jqxhr.responseText).fadeIn();
                    });

            });

            $(".default-date-picker").datetimepicker({
                onGenerate: function (ct) {
                    $(this).find('.xdsoft_date').toggleClass('xdsoft_disabled');
                },
                format: 'd/m/Y'
            })
            //$.datetimepicker.setLocale('fr');
            $("#deconnexion").on('click', function (e) {
                e.preventDefault();
                    swal({
                        title: 'Demande de Confirmation',
                        text: "Etes-vous sûr de vouloir vous déconnecter ?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#c8234a',
                        cancelButtonColor: '#fe4500',
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Non',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false,
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location.href = "composant/com_security/controlersecurity.php?task=disconnect";
                        } else {
                            swal({
                                    title: 'Annulation',
                                    text: "Opération annulée",
                                    type: 'error',
                                    showCancelButton: false,
                                    confirmButtonColor: '#c8234a',
                                    confirmButtonText: 'OK'
                                });/*
                            swal(
                                'Annulation',
                                'Opération annulée',
                                'error'
                            );*/
                        }
                    });
            });

        </script>

        <!-- Fin js datepicker -->
        <script type="text/javascript">
            $(document).ready(function () {
                $('#dtgrid').dataTable({
                    language: {
                        url: 'services/js/datatable_en.json'
                    }
                })
                $('[data-toggle="tooltip"]').tooltip();
            });

            $('.default-date-picker').datetimepicker({
                onGenerate: function (ct) {
                    $(this).find('.xdsoft_date')
                        .toggleClass('xdsoft_disabled');
                },
                minDate: '-<?= date("Y/m/d", strtotime("-2 day")); ?>',
                maxDate: '+1970/01/2',
                timepicker: false,
                format: 'd/m/Y',
            });


        </script>

        </body>
        </html>

        <?php
    } else
        header("location:login.php");
}
?>
