<!doctype html>
<html class="no-js" lang="fr">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113215970-12"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-113215970-12');
    </script>

    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SUNU GROUP | <?php echo $titrePage; ?></title>
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Assurance, sunu group, monbonprofil">

    <meta content="© 2018 SUNU GROUP - Site Web" name="copyright" />
    <meta content="180718" name="date-revision-ddmmyyyy" />
    <meta content="never" name="expires" />
    <meta content="General" name="Rating" />
    <meta content="all, index, follow" name="Robots" />

    <!-- favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url(); ?>assets/images/favicon.ico">
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/bootstrap.min.css">
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/owl.transitions.css">
    <!-- meanmenu css -->
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/meanmenu.min.css">
    <!-- font-awesome css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/icon.css">
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/font/flaticon.css">
    <!-- magnific css -->
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/magnific.min.css"> 
    <!-- venobox css -->
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/venobox.css">
    <!-- style css -->
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/nice-select.css">
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/bootstrap-multiselect.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css" rel="stylesheet"
        type="text/css" />
    <!-- responsive css -->
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/responsive.css">
    <link href="<?php echo site_url(); ?>assets/jsmaps/jsmaps.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
    .avatar {
        height: 60px;
        position: relative;
        width: 60px;
        margin: 10px;
    }

    .avatar img {
        border-radius: 9999px;
        height: 100%;
        position: relative;
        width: 100%;
        z-index: 2;
    }

    @keyframes cycle-colors {
        0% {
            border-color: hsl(0, 0%, 76%);
        }

        25% {
            border-color: hsl(0, 0%, 57%);
        }

        50% {
            border-color: hsl(347, 78%, 44%);
        }

        75% {
            border-color: hsl(347, 78%, 44%);
        }

        100% {
            border-color: hsl(347, 78%, 44%);
        }
    }

    @keyframes pulse {
        to {
            opacity: 0;
            transform: scale(1);
        }
    }

    .avatar::before,
    .avatar::after {
        animation: pulse 2s linear infinite;
        border: #fff solid 8px;
        border-radius: 9999px;
        box-sizing: border-box;
        content: ' ';
        height: 140%;
        left: -20%;
        opacity: .6;
        position: absolute;
        top: -20%;
        transform: scale(0.714);
        width: 140%;
        z-index: 1;
    }

    .avatar::after {
        animation-delay: 1s;
    }

    .avatar::before,
    .avatar::after {
        animation: pulse 1s linear infinite, cycle-colors 6s linear infinite;
    }

    .avatar:hover::after {
        animation-delay: .5s;
    }

    .avatarmobile {
        position: absolute;
        margin-top: -0.1em;
        margin-left: 8em;
    }

    @media only screen and (max-width: 1300px) {
        .divtxthommage img {
            width: 100%;
            height: auto;
        }
    }

    @media only screen and (max-width: 1200px) {
        .divtxthommage img {
            display: none;
        }
    }

    .containerPathe {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
    }


    .divtxthommage {
        margin-top: 20px;
        margin-bottom: 20px;
        position: relative;
        color: #c6183d;
        /* margin-left: -0.5rem; */
        text-align: center;
        max-width: 200px;
    }

    .divtxthommage img {
        width: 100%;
        height: 100%;
        position: relative;
    }
    </style>

    <!-- modernizr css -->
    <script src="<?php echo site_url(); ?>assets/js/vendor/modernizr-2.8.3.min.js"></script>

    <meta property="og:title" content="SUNU GROUP - Site Web" />
    <meta property="og:url" content="http://sunu-group.com/" />
    <meta property="og:image" content="http://sunu-group.com/assets/images/logo.png" />
    <meta property="og:site_name" content="Site web du groupe d'assurance SUNU GROUP" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Site web du groupe d'assurance SUNU GROUP" />
</head>

<body class="home-2">
    <!--[if lt IE 8]>
			<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

    <div id="preloader"></div>
    <header class="header-two">
        <div id="sticker" class="header-area header-area-2 hidden-xs">
            <div class="headcontainer">
                <div class="row">
                    <!-- Hommage start-->
                    <a href="https://www.pathedione.com" target="_blanc" style="text-decoration: none;">
                        <div class="col-lg-2 col-md-2 col-sm-2 containerPathe">
                            <div>
                                <div class="avatar">
                                    <img src="<?php echo site_url('assets/images/Necrologie_Pathe_Dione_deces.jpg') ?>">
                                </div>
                            </div>
                            <?php
                            $langue = lang('accueil');
                            ?>
                            <div class="divtxthommage">
                                <?php if ($langue == 'Home') {
                                ?>
                                <img src="<?php echo site_url('assets/images/textPatheEn.png') ?>">
                                <?php
                                } else {
                                ?>
                                <img src="<?php echo site_url('assets/images/textPathe.png') ?>">
                                <?php
                                } ?>
                            </div>
                        </div>
                    </a>

                    <!-- Hommage end-->
                    <!-- logo start -->
                    <div class="col-lg-1 col-md-1 col-sm-1">
                        <div class="logo">
                            <!-- Brand -->
                            <a class="navbar-brand page-scroll sticky-logo" href="<?php echo site_url('home'); ?>">
                                <img src="<?php echo site_url('assets/images/logo.png') ?>" alt="">
                            </a>
                        </div>
                    </div>
                    <!-- logo end -->

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <nav class="navbar navbar-default">
                            <div class="collapse navbar-collapse" id="navbar-example">
                                <div class="main-menu">
                                    <ul class="nav navbar-nav navbar-right">
                                        <li class="<?php echo $menu['accueil']; ?>"><a
                                                href="<?php echo site_url('home'); ?>"><?php echo lang('accueil') ?></a>
                                        </li>
                                        <li class="<?php echo $menu['groupe']; ?>">
                                            <a
                                                href="<?php echo site_url('legroupe'); ?>"><?php echo lang('groupe'); ?></a>
                                            <ul class="sub-menu">
                                                <li><a
                                                        href="<?php echo site_url('legroupe/historique') ?>"><?php echo lang('history') ?></a>
                                                </li>
                                                <li><a
                                                        href="<?php echo site_url('legroupe/chiffrescles') ?>"><?php echo lang('chiffres') ?></a>
                                                </li>
                                                <li><a
                                                        href="<?php echo site_url('legroupe/gouvernance') ?>"><?php echo lang('gouvernance') ?></a>
                                                </li>
                                                <li><a
                                                        href="<?php echo site_url('legroupe/publications') ?>"><?php echo lang('publications') ?></a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="<?php echo $menu['reseau']; ?>">
                                            <a
                                                href="<?php echo site_url('notrereseau'); ?>"><?php echo lang('reseau'); ?></a>
                                            <ul class="sub-menu">
                                                <li><a href="<?php echo site_url('notrereseau/filiales') ?>"><?php echo lang('filiales') ?></a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="<?php echo $menu['actualites']; ?>"><a href="<?php echo site_url('actualites'); ?>"><?php echo lang('actualites'); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                        <!-- mainmenu end -->
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="col-md-6 col-sm-6 droit">
                            <div class="top-social">
                                <ul>
                                    <li><a href="<?php echo $network[0]->facebook; ?>" target="_blank"><i
                                                class="fa fa-facebook"></i></a></li>
                                    <li><a href="<?php echo $network[0]->linkedin; ?>" target="_blank"><i
                                                class="fa fa-linkedin"></i></a></li>
                                    <li><a href="<?php echo $network[0]->sunu_sante; ?>" target="_blank"><i
                                                class="fa fa-plus-square"></i>
                                            <strong><?php echo lang('sunu_sante'); ?></strong></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 droit">
                            <div class="top-social flag">
                                <ul>
                                    <li>
                                        <a href="<?php echo site_url('fr'); ?>">
                                            <i class="flag-icon flag-icon-squared flag-icon-fr"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('en'); ?>">
                                            <i class="flag-icon flag-icon-squared flag-icon-gb"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-menu-area hidden-lg hidden-md hidden-sm">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mobile-menu">
                            <div>
                                <div class="avatarmobile">
                                    <a href="https://www.pathedione.com" target="_blanc" style="text-decoration: none;">
                                        <img style="border-radius: 9999px;width: 30%;height: 30%;position: relative;"
                                            src="<?php echo site_url('assets/images/Necrologie_Pathe_Dione_deces.jpg') ?>"></img>
                                    </a>
                                </div>
                                <div class="logo">
                                    <a href="#"><img src="<?php echo site_url('assets/images/logo_mobile.png') ?>"
                                            alt="" /></a>
                                </div>
                                <div>
                                    <nav id="dropdown">
                                        <ul>
                                            <li class="<?php echo $menu['accueil']; ?>"><a
                                                    href="<?php echo site_url(); ?>"><?php echo lang('accueil') ?></a>
                                            </li>
                                            <li class="<?php echo $menu['groupe']; ?>">
                                                <a class="pagess"
                                                    href="<?php echo site_url('legroupe'); ?>"><?php echo lang('data'); ?></a>
                                                <ul class="sub-menu">
                                                    <li><a
                                                            href="<?php echo site_url('legroupe/historique') ?>"><?php echo lang('history') ?></a>
                                                    </li>
                                                    <li><a
                                                            href="<?php echo site_url('legroupe/chiffrescles') ?>"><?php echo lang('chiffres') ?></a>
                                                    </li>
                                                    <li><a
                                                            href="<?php echo site_url('legroupe/gouvernance') ?>"><?php echo lang('gouvernance') ?></a>
                                                    </li>
                                                    <li><a
                                                            href="<?php echo site_url('legroupe/publications') ?>"><?php echo lang('publications') ?></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="<?php echo $menu['reseau']; ?>"><a
                                                    href="<?php echo site_url('notrereseau'); ?>"><?php echo lang('reseau'); ?></a>
                                            </li>
                                            <li class="<?php echo $menu['actualites']; ?>"><a
                                                    href="<?php echo site_url('actualites'); ?>"><?php echo lang('actualites'); ?></a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile-menu-area end -->
    </header>

    <?php echo $output; ?>

    <div class="area-padding2">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="banner-content text-center">
                        <a href="<?php echo $network[0]->facebook; ?>" title="" target="_blank"><i
                                class="fa fa-facebook"></i></a>
                        <a href="<?php echo $network[0]->linkedin; ?>" target="_blank" title=""><i
                                class="fa fa-linkedin"></i></a>
                        <a class="sante" href="<?php echo $network[0]->sunu_sante; ?>" target="_blank"><i
                                class="fa fa-plus-square"></i><span style="color: #fff">
                                <strong><?php echo lang('sunu_sante'); ?></strong></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer-area-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="metier">
                            <p>
                                <?php echo lang('sunu_slogan'); ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="copyright center">
                            <p>Copyright 2018</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="copyright center">
                            <p>All Rights Reserved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- jquery latest version -->
    <script src="<?php echo site_url(); ?>assets/js/vendor/jquery-1.12.4.min.js"></script>
    <!-- bootstrap js -->
    <script src="<?php echo site_url(); ?>assets/js/bootstrap.min.js"></script>
    <!-- owl.carousel js -->
    <script src="<?php echo site_url(); ?>assets/js/owl.carousel.min.js"></script>
    <!-- Counter js -->
    <script src="<?php echo site_url(); ?>assets/js/jquery.counterup.min.js"></script>
    <!-- waypoint js -->
    <script src="<?php echo site_url(); ?>assets/js/waypoints.js"></script>
    <!-- isotope js -->
    <script src="<?php echo site_url(); ?>assets/js/isotope.pkgd.min.js"></script>
    <!-- stellar js -->
    <script src="<?php echo site_url(); ?>assets/js/jquery.stellar.min.js"></script>
    <!-- magnific js -->
    <script src="<?php echo site_url(); ?>assets/js/magnific.min.js"></script>
    <!-- venobox js -->
    <script src="<?php echo site_url(); ?>assets/js/venobox.min.js"></script>
    <!-- meanmenu js -->
    <script src="<?php echo site_url(); ?>assets/js/jquery.meanmenu.js"></script>
    <!-- Form validator js -->
    <script src="<?php echo site_url(); ?>assets/js/form-validator.min.js"></script>
    <!-- plugins js -->
    <script src="<?php echo site_url(); ?>assets/js/plugins.js"></script>
    <script src="<?php echo site_url(); ?>assets/js/jquery.nice-select.min.js"></script>
    <script src="<?php echo site_url(); ?>assets/js/bootstrap-multiselect.js"></script>
    <!-- main js -->
    <script src="<?php echo site_url(); ?>assets/js/main.js"></script>
    <script>
    var base_url = '<?php echo site_url(); ?>';
    </script>
    <script>
    var lang = '<?php echo $lang; ?>';
    </script>


    <?php if (isset($acc)) : ?>
    <script src="<?php echo site_url(); ?>assets/jsmaps/jsmaps-libs.js" type="text/javascript"></script>
    <script src="<?php echo site_url(); ?>assets/jsmaps/jsmaps-panzoom.js"></script>
    <script src="<?php echo site_url(); ?>assets/jsmaps/jsmaps.min.js" type="text/javascript"></script>
    <script src="<?php echo site_url(); ?>assets/maps/africa.js" type="text/javascript"></script>
    <script src="<?php echo site_url(); ?>assets/maps/africaen.js" type="text/javascript"></script>
    <script src="<?php echo site_url(); ?>assets/maps/africa_reseau.js" type="text/javascript"></script>
    <script src="<?php echo site_url(); ?>assets/maps/africa_reseauen.js" type="text/javascript"></script>
    <?php $lg = ($lang != 'fr') ? $lang : ''; ?>
    <?php if ($acc != 'reseau') : ?>
    <script type="text/javascript">
    $(function() {
        $('#sunu-map').JSMaps({
            map: 'africa<?php echo $lg; ?>',
            defaultText: "",
            initialZoom: 2,
            offColor: "#FFF",
            responsive: true,
            textAreaWidth: 0,
            textAreaHeight: 0,
            displayAbbreviationOnDisabledStates: false,
            displayAbbreviations: true,
            abbreviationFontSize: 18,
            // enablePanZoom: true,
            // displayMousePosition: true,
            stateClickAction: "url"
            // initialMapX: 75,
            // initialMapY: 230
        });
    });
    </script>
    <?php else : ?>
    <script type="text/javascript">
    $(function() {
        $('#sunu-reseau').JSMaps({
            map: 'africa_reseau<?php echo $lg; ?>',
            defaultText: "",
            // initialZoom: 3,
            offColor: "#FFF",
            responsive: true,
            textAreaWidth: 0,
            textAreaHeight: 0,
            displayAbbreviationOnDisabledStates: false,
            displayAbbreviations: true,
            abbreviationFontSize: 18,
            // // enablePanZoom: true,
            // // displayMousePosition: true,
            stateClickAction: "url"
            // initialMapX: 75,
            // initialMapY: 230
        });
    });
    </script>
    <?php endif; ?>
    <?php endif; ?>
</body>

</html>