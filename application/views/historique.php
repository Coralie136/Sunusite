<div class="intro-area intro-area-2">
   <div class="main-overly"></div>
    <div class="intro-carousel0">
        <div class="intro-content">
            <div class="slider-images">
                <img src="<?php echo (!empty($images[0]->fichier_image)?site_url('upload/image_site/').$images[0]->fichier_image:site_url('assets/images/historique.jpg')); ?>" alt="">
            </div>
        </div>
    </div>
</div>

<div class="welcome-area mg-50">
    <div class="container">
        <div class="row">
            <div class="section-headline left-headline text-left">
                <h3 class="text-upper"><span class="color"><?php echo lang('history'); ?></span></h3>
            </div>
        </div>
        <div class="row" id="hists">
            <div class="col-md-8">
                <?php 
                if($lang == 'fr'): 
                    $month  = array(
                        '0'     => '',
                        '1'     => 'Janvier',
                        '2'     => 'Février',
                        '3'     => 'Mars',
                        '4'     => 'Avril',
                        '5'     => 'Mai',
                        '6'     => 'Juin',
                        '7'     => 'Juillet',
                        '8'     => 'Août',
                        '9'     => 'Septembre',
                        '10'    => 'Octobre',
                        '11'    => 'Novembre',
                        '12'    => 'Décembre',
                    );
                else:
                    $month  = array(
                        '0'     => '',
                        '1'     => 'January',
                        '2'     => 'February',
                        '3'     => 'March',
                        '4'     => 'April',
                        '5'     => 'May',
                        '6'     => 'June',
                        '7'     => 'July',
                        '8'     => 'August',
                        '9'     => 'September',
                        '10'    => 'October',
                        '11'    => 'November',
                        '12'    => 'December',
                    );
                endif;
                    foreach($annees as $annee):
                ?>
                <div class="section-headline left-headline text-left">
                    <h4 class="text-upper"><span class="color bold"><?php echo $annee->annee_historique; ?></span></h4>
                </div>
                    <?php 
                        foreach($annee->dates as $date):
                    ?>
                    <div class="about-content text-justify">
                        <p>
                            <?php 
                                if($date->mois_historique != 0):
                            ?>
                            <span class="bold"><?php echo ucfirst($month[$date->mois_historique]).' '.$date->annee_historique; ?>:</span>
                            <?php endif; ?>
                            <?php echo $date->texte_historique; ?>
                        </p>
                        <p></p>
                    </div>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
            <div class="col-md-4">
                <div class="about-content">
                    <p class="hist-icon text-center"><i class="flaticon-open-book hist-icon color"></i></p>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php echo $this->ajax_pagination->create_links(); ?>
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