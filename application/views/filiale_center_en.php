<div class="intro-area intro-area-2">
    <div class="main-overly"></div>
    <div class="intro-carousel0" style="border:1px solid #cccccc;">

    </div>
</div>

<div class="single-services-page mg-50">
    <div class="container">
        <div class="row">
            <div class="section-headline left-headline text-left">
                <h3 class="text-upper"><span class="color"><?php echo lang('nosfiliales') ?></span></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="page-head-left">
                    <!-- strat single area -->
                    <div class="single-page-head">
                        <div class="left-menu">
                            <ul>
                                <?php foreach($payss as $pays): ?>
                                    <li <?php echo ($menu==$pays->lien_mbp?'class="active"':'') ?>>
                                        <a href="<?php echo (!empty($pays->lien_site)?$pays->lien_site:site_url('notrereseau/filiales/'.$pays->lien_mbp)); ?>" >
                                            <?php echo $pays->nom_pays; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End left sidebar -->
            <!-- Start service page -->
            <div class="col-md-9 col-sm-8 col-xs-12">
                <?php foreach($filiales as $filiale): ?>
                    <?php if(empty($filiale->lien_site_description)){  ?>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <a href="#">
                                    <h3><?php echo $filiale->titre_en ?></h3>
                                </a>
                                <?php echo $filiale->detail_en ?>
                            </div>
                            <?php if(!empty($filiale->image)): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="single-page">
                                        <div class="page-img elec-page">
                                            <img src="<?php echo site_url('/upload/filiale/'.$filiale->image) ?>" alt="<?php echo $filiale->titre_en; ?>" width="100%" >
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row row-eq-height">
                            <div class="col-md-6 col-sm-12 col-xs-12 single-well">
                                <a href="#">
                                    <h6>Head Office</h6>
                                </a>
                                <?php echo $filiale->siege_social_en ?>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 single-well">
                                <a href="#">
                                    <h6>Legal Information</h6>
                                </a>
                                <?php echo $filiale->info_juridique_en ?>
                            </div>
                        </div>
                        <div class="row row-eq-height">
                            <div class="col-md-6 col-sm-12 col-xs-12 single-well">
                                <a href="#">
                                    <h6>Management Team</h6>
                                </a>
                                <?php echo $filiale->direction_general_en ?>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 single-well">
                                <a href="#">
                                    <h6>Shareholders</h6>
                                </a>
                                <?php echo $filiale->actionnariat_en ?>
                            </div>
                        </div>
                        <div class="row row-eq-height">
                            <div class="col-md-6 col-sm-12 col-xs-12 single-well">
                                <a href="#">
                                    <h6>Board Of Directors</h6>
                                </a>
                                <?php echo $filiale->conseil_admin_en ?>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 single-well">
                                <a href="#">
                                    <h6>Products</h6>
                                </a>
                                <?php echo $filiale->produit_en ?>
                            </div>
                        </div>
                    <?php }else{
                        ?>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="<?php echo $filiale->lien_site_description ?>">
                                <h3><?php echo $filiale->titre_en ?></h3>
                            </a>
                            <div class="price-btn" style="padding-top: 10px;">
                                <a href="<?php echo $filiale->lien_site_description ?>" target="_blank"><?php echo $labelbouton ?></a>
                            </div>
                        </div>
                        <?php
                    } ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>