<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Modification de mot de passe</title>

        <!--<script src="AdminLTE-master/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>-->
        <script
                src="https://code.jquery.com/jquery-2.2.4.min.js"
                integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
                crossorigin="anonymous"></script>
        <!--<script src="services/js/jquery-2.2.3.min.js" type="text/javascript"></script>-->
        <script src="AdminLTE-master/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

        <script src="AdminLTE-master/dist/js/app.js" type="text/javascript"></script>
        <!--<script src="AdminLTE-master/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>-->
        <script src="AdminLTE-master/plugins/iCheck/icheck.js" type="text/javascript"></script>

        <script src="services/js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="services/css/sweetalert.css">

        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">
        <!--btn-->    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!--btn-    <link rel="stylesheet" href="AdminLTE-master/bootstrap/css/bootstrap.css" />-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

        <link rel="stylesheet" href="AdminLTE-master/dist/css/AdminLTE.min.css" />
        <!--
                 <link rel="stylesheet/less" type="text/css" href="AdminLTE-master/build/less/AdminLTE.less" />
                <link rel="stylesheet" href="AdminLTE-master/plugins/sweet-alert/dist/sweetalert.css" />
                <link rel="stylesheet" href="AdminLTE-master/plugins/sweet-alert/themes/facebook/facebook.css" />
        -->
        <link rel="stylesheet" href="services/css/style.css" />
        <script src="composant/com_security/security.js"></script>

        <style>
            html {
                margin:0;
                padding:0;
                background-color: lightgrey;
                background: url(services/img/background_mbp_.png) no-repeat fixed;
                -webkit-background: url(services/img/background_mbp_.png) no-repeat fixed;
                -webkit-background-size: cover;
                background-size: cover; /* version standardisée */
                overflow-y: auto;
            }
            .login-page{
                background: inherit;
            }
            .login-box {
                margin-top: 65vh; /* poussé de la moitié de hauteur de viewport */
                transform: translateY(-60%); /* tiré de la moitié de sa propre hauteur */
                -webkit-backface-visibility: hidden;
                margin-bottom: 0px;
                -webkit-margin-bottom: 0px;
            }
            .login-box-body{
                background: rgba(255,255,255,0.1);
                box-shadow: 0px 0px 20px #fff;
                -webkit-box-shadow: 0px 0px 20px #fff;
            }
            .login-box-msg{
                font-weight: bold;
                color: #fff;
            }
            .login-logo a{
                color: white;
            }
            .login-box-body a{
                color: black;
                font-weight: bold;
            }
            .login-box-body a:hover{
                color: white;
                text-decoration: underline;
            }
            .form-control{
                background: rgba(255,255,255,0.6);
                color : black;
                font-weight: bold;
            }
            fieldset, input[type="text"] {
                display: none !important;
            }
            button{
                background-color: #c8234a !important;
                border-color: #c8234a !important;
            }
        </style>
    </head>
    <body class="login-page" > <!--oncontextmenu="return false;" onselectstart="return false" ondragstart="return false" -->
    <div class="login-box">
        <div class="login-logo">
            <!--<img src="services/img/logo_mbp.png" alt="logo sunu" width="135" height="100"/> <br> <br>
            <a href="">Gestionnaire </a> <br> <br>
            <a href="">des contacts</a>-->
        </div><!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Modifier votre mot de passe</p>
            <form method="post" id="modal_edit_key" role="form" >
                <div class="form-group">
                    <input  required="required" class="form-control" id="str_PASSWORD" placeholder="Entrez un mot de passe" name="str_PASSWORD" type="password" min="5"/>
                </div>
                <div class="form-group">
                    <input  required="required" class="form-control" id="str_PASSWORD2" placeholder="Entrez le même mot de passe" name="str_PASSWORD" type="password" min="5"/>
                </div>
                <div class="form-group">
                    <button style="background-color: #c8234a !important; border-color: #c8234a !important; " type="button" class="btn btn-warning" id="updating">
                        <i class="fa fa-unlock"></i>
                        Modifier
                    </button>
                </div>
            </form>
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    </body>
</html>