<?php
    if(isset($produits)){
        if(!empty($produits)):
            if($produits[0]->slide != '') $slide = $produits[0]->slide;
            else $slide = 'mixte.jpg';
            $accroche = $produits[0]->accroche;
        else:
            $slide = 'mixte.jpg';
            $accroche = '';
        endif;
    }
    else{
        $slide = 'mixte.jpg';
    }
?>
<!doctype html>
<html class="no-js" lang="fr">

<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>SUNU GROUP | ACCUEIL</title>
        <meta name="description" content="Mon bon profil SUNU GROUP">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <meta name="keywords" content="Assurance, sunu group, mon bon profil">
        
        <meta content="© 2018 SUNU GROUP -Mon bon profil" name="copyright" />
        <!-- <meta content="140817" name="date-revision-ddmmyyyy" /> -->
        <meta content="never" name="expires" />
        <meta content="General" name="Rating" />

		<!-- favicon -->		
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url(); ?>assets/images/favicon.ico">
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/bootstrap.min.css">
		<!-- owl.carousel css -->
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/owl.carousel.css">
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/owl.transitions.css">
        <!-- meanmenu css -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/meanmenu.min.css">
		<!-- font-awesome css -->
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/icon.css">
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/flaticon.css">
		<!-- magnific css -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/magnific.min.css">
		<!-- venobox css -->
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/venobox.css">
        <!-- responsive css -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/responsive.css">
		<!-- style css -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/nice-select.css">
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/style.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css" rel="stylesheet" type="text/css" />

		<!-- modernizr css -->
		<script src="<?php echo site_url(); ?>assets/js/vendor/modernizr-2.8.3.min.js"></script>
	</head>
		<body class="home-2">

		<!--[if lt IE 8]>
			<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

        <div id="preloader"></div>
        <header class="header-two">
            
            <div id="sticker" class="header-area header-area-2 hidden-xs">
                <div class="container">
                    <div class="row">
                        <!-- logo start -->
                        <div class="col-md-3 col-sm-3">
                            <div class="logo">
                                <!-- Brand -->
                                <a class="navbar-brand page-scroll sticky-logo" href="#">
                                    <img src="<?php echo site_url('assets/images/logo.png'); ?>" alt="">
                                </a>
                            </div>
                        </div>
                        <!-- logo end -->
                        <div class="col-md-6 col-sm-6">
                            <nav class="navbar navbar-default">
                                <div class="collapse navbar-collapse" id="navbar-example">
                                    <div class="main-menu">
                                        <ul class="nav navbar-nav navbar-right">
                                            <li><a href="<?php echo site_url(); ?>">ACCUEIL</a></li>
											<li><a href="http://sunu-group.com/index.php/le-groupe" target="_blank">LE GROUPE</a></li>
                                            <li><a href="http://sunu-group.com/index.php/les-filiales" target="_blank">NOTRE RÉSEAU</a></li>
											<li><a href="http://sunu-group.com/index.php/actualites" target="_blank">ACTUALITÉS</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <!-- <div class="col-md-6"> -->
                                <div class="top-social">
                                    <ul>
                                        <li><a href="https://web.facebook.com/sunuassurances/" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="https://www.linkedin.com/company/1820547/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    </ul> 
                                <!-- </div> -->
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="top-social flag">
                                    <ul>
                                        <li><a href="#"><i class="flag-icon flag-icon-squared flag-icon-fr"></i></a></li>
                                        <li><a href="#"><i class="flag-icon flag-icon-squared flag-icon-gb"></i></a></li>
                                    </ul> 
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- header-area end -->
            <!-- mobile-menu-area start -->
            <div class="mobile-menu-area hidden-lg hidden-md hidden-sm">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mobile-menu">
                                <div class="logo">
                                    <a href="#"><img src="<?php echo site_url('assets/images/logo_mobile.png') ?>" alt="" /></a>
                                </div>
                                <nav id="dropdown">
                                    <ul>
                                        <li><a href="<?php echo site_url(); ?>">ACCUEIL</a></li>
                                        <li><a href="http://sunu-group.com/index.php/le-groupe">LE GROUPE</a></li>
                                        <li><a href="http://sunu-group.com/index.php/les-filiales">NOTRE RÉSEAU</a></li>
                                        <li><a href="http://sunu-group.com/index.php/actualites">ACTUALITÉS</a></li>
                                    </ul>
                                </nav>
                            </div>					
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile-menu-area end -->		
        </header>
        <!-- header end -->
        <!-- Start Slider Area -->
        <div class="intro-area intro-area-2">
           <div class="main-overly"></div>
            <div class="intro-carousel0">
                <div class="intro-content">
                    <div class="slider-images">
                        <img src="<?php echo site_url('assets/images/slider/'.$slide); ?>" alt="">
                    </div>
                </div>
            </div>
        </div>

        <?php if(!isset($message)): ?>

        <div class="welcome-area mg-50" id="#resultat">
            <div class="container">
               <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="section-headline text-center">
                            <h2>AVEC SUNU ASSURANCES</h2>
                        </div>
                        <h3 class="txtProfil text-center"><span class="color"><?php echo $name; ?></span>, <?php echo $accroche; ?></h3>
                    </div>
                </div>
                <div class="row produits">
                    <div class="col-md-10 col-md-offset-1">
                        <h3 class="text-center"><span class="color">PRODUITS</span></h3>
                        <?php 
                            $n = sizeof($produits);
                            if($n == 1 ) $class = "col-md-4 col-sm-4 col-md-offset-4";
                            else $class = "col-md-4 col-sm-4";
                        ?>
                            <?php 
                                if($n == 2):
                            ?>
                            <div class="col-md-2 col-sm-2">
                                
                            </div>
                            <?php endif; ?>
                        <?php foreach($produits as $produit): ?>
                        <div class="<?php echo $class; ?> col-xs-12">
                            <div class="well-services text-center">
                                <div class="services-img">
                                    <img src="<?php echo site_url('assets/images/'.$produit->image) ?>" alt="">
                                </div>
                                <div class="main-services">
                                    <div class="service-content">
                                        <h3><?php echo $produit->nom_produit; ?></h3>
                                    </div>
                                        <p><?php echo $produit->texte; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="welcome-area mgt-20">
            <div class="container">
               <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 prodContact">
                        <h3 class="text-center"><span class="color"><?php echo $pays[0]->nom_pays; ?>:</span></h3>
                        <?php 
                            $n = sizeof($contacts);
                            if($n > 1):
                        ?>
                        <div class="col-md-10 col-md-offset-1 cont">
                            <?php foreach($contacts as $contact): ?>
                            <div class="col-md-6 cont">
                                <div class="paysContact">
                                    <h4><span class="color">SUNU ASSURANCES <?php echo $contact->nom_type_produit; ?></span></h4>
                                    <p><?php echo $contact->contact; ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php 
                            else:
                        ?>
                        <div class="col-md-4 col-md-offset-4">
                            <div class="paysContact nomarge">
                                <h4><span class="color">SUNU ASSURANCES <?php echo $contacts[0]->nom_type_produit; ?></span></h4>
                                <p><?php echo $contacts[0]->contact; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 infoMail">
                        <input type="hidden" name="id_client" class="id_client" value="<?php echo $id_client; ?>">
                        <!-- <a href="#" title="" class="ready-btn" id="sendResult">JE SOUHAITE RECEVOIR PAR MAIL CES INFORMATIONS</a> -->
                        <a href="#" title="" class="ready-btn" id="sendResult">JE SOUHAITE RECEVOIR PAR MAIL CES INFORMATIONS</a>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>

        <div class="page-head area-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="error-page">
                                <!-- map area -->
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="error-main-text text-center">
                                        <h2 class="error-easy-text"><?php echo $message; ?></h2>
                                        <a  class="error-btn" href="<?php echo site_url(); ?>">Retour à l'accueil</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <?php endif; ?>

        <div class="area-padding2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="banner-content text-center">
                            <a href="https://web.facebook.com/sunuassurances/" title="" target="_blank"><i class="fa fa-facebook"></i></a>
                            <a href="https://www.linkedin.com/company/1820547/" target="_blank" title=""><i class="fa fa-linkedin"></i></a>
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
                                    Notre métier, l'assurance.
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
        <script>var base_url = '<?php echo site_url(); ?>';</script> 
	</body>
</html>