<div class="intro-area intro-area-2">
   <div class="main-overly"></div>
    <div class="intro-carousel0">
        <div class="intro-content">
            <div class="slider-images">
                <img src="<?php echo (!empty($images[0]->fichier_image)?site_url('upload/image_site/').$images[0]->fichier_image:site_url('assets/images/publication.jpg')); ?>"  alt="Publications – SUNU ASSURANCES">
            </div>
        </div>
    </div>
</div>

<div class="welcome-area mg-50">
    <div class="container">
        <div class="row">
            <div class="section-headline left-headline text-left">
                <h3 class="text-upper"><span class="color"><?php echo lang('publications'); ?></span></h3>
            </div>
        </div>
        <div class="row" id="pubs">
            <div class="col-md-12">
                <?php foreach($publications as $publication): ?>
                <div class="col-md-6 publication">
                    <h3><a href="<?php echo site_url('upload/post/'.$publication->fichier_publication); ?>" target="_blank" title="<?php echo $publication->titre_publication ?>"><span class="color"><i class="fa fa-file-pdf-o"></i> <?php echo $publication->titre_publication ?></span></a></h3>
                    <?php echo $publication->texte_publication ?></p>
                </div>
                <?php endforeach; ?>
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