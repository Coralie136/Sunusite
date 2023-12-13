
<div class="intro-area intro-area-2">
   <div class="main-overly"></div>
    <div class="intro-carousel0">
        <div class="intro-content">
            <div class="slider-images">
                <img src="<?php echo (!empty($images[0]->fichier_image)?site_url('upload/image_site/').$images[0]->fichier_image:site_url('assets/images/chiffrescles.jpg')); ?>" alt="Chiffres clés – SUNU ASSURANCES">
            </div>
        </div>
    </div>
</div>

<div class="welcome-area mg-50">
    <div class="container">
        <div class="row">
            <div class="section-headline left-headline text-left">
                <h3 class="text-upper"><span class="color"><?php echo lang('chiffres'); ?></span></h3>
            </div>
        </div>
        <div class="row">

            <div class="row">
                <img src="<?php echo site_url('upload/chiffre_cle/'.$chiffrecle[0]->fichier_chiffre_cle_en); ?>" alt="<?php echo $chiffrecle->titre_chiffre_cle ?>">
            </div>
        </div>
    </div>
</div>


<div class="welcome-area mg-50">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12 rubrique">
                <div class="single-rubrique">
                    <div class="rubrique-img <?php echo $menu2['historique'] ?>">
                        <a href="<?php echo site_url('legroupe/historique'); ?>">
                            <img src="<?php echo site_url(); ?>assets/images/history-img.jpg" alt="Historique – SUNU ASSURANCES" class="img-responsive">
                        </a>
                    </div>
                    <div class="rubrique-content">
                        <p><i class="flaticon-open-book color"></i></p>
                        <h4><a href="<?php echo site_url('legroupe/historique'); ?>" title=""><?php echo lang('history'); ?></a></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 rubrique">
                <div class="single-rubrique">
                    <div class="rubrique-img <?php echo $menu2['chiffres'] ?>">
                        <a href="<?php echo site_url('legroupe/chiffrescles'); ?>">
                            <img src="<?php echo site_url(); ?>assets/images/chiffres-img.jpg" alt="Chiffres clés – SUNU ASSURANCES" class="img-responsive">
                        </a>
                    </div>
                    <div class="rubrique-content">
                        <p><i class="flaticon-graphic color"></i></p>
                        <h4><a href="<?php echo site_url('legroupe/chiffrescles'); ?>" title=""><?php echo lang('chiffres'); ?></a></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 rubrique">
                <div class="single-rubrique">
                    <div class="rubrique-img <?php echo $menu2['gouv'] ?>">
                        <a href="<?php echo site_url('legroupe/gouvernance'); ?>">
                            <img src="<?php echo site_url(); ?>assets/images/gouvernance-img.jpg" alt="Gouvernance – SUNU ASSURANCES" class="img-responsive">
                        </a>
                    </div>
                    <div class="rubrique-content">
                        <p><i class="flaticon-people color"></i></p>
                        <h4><a href="<?php echo site_url('legroupe/gouvernance'); ?>" title=""><?php echo lang('gouvernance'); ?></a></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 rubrique">
                <div class="single-rubrique">
                    <div class="rubrique-img <?php echo $menu2['publications'] ?>">
                        <a href="<?php echo site_url('legroupe/publications'); ?>">
                            <img src="<?php echo site_url(); ?>assets/images/publications-img.jpg" alt="Publications – SUNU ASSURANCES" class="img-responsive">
                        </a>
                    </div>
                    <div class="rubrique-content">
                        <p><i class="flaticon-loudspeaker-with-two-sound-waves color"></i></p>
                        <h4><a href="<?php echo site_url('legroupe/publications'); ?>" title=""><?php echo lang('publications'); ?></a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>