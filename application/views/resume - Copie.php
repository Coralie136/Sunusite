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
		<title>SUNU GROUP | VOTRE RESUME</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">

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
                    </div>
                </div>
            </div>	
        </header>
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

        <div class="welcome-area" style="margin-bottom: 30px;">
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
                </div>
            </div>
        </div>
        <?php endif; ?>

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
	</body>
</html>