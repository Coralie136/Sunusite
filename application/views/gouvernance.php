<div class="intro-area intro-area-2">
   <div class="main-overly"></div>
    <div class="intro-carousel0">
        <div class="intro-content">
            <div class="slider-images">
                <img src="<?php echo (!empty($images[0]->fichier_image)?site_url('upload/image_site/').$images[0]->fichier_image:site_url('assets/images/gouvernance.jpg')); ?>" alt="Gouvernance – SUNU ASSURANCES">
            </div>
        </div>
    </div>
</div>

<div class="welcome-area mg-50">
    <div class="container">
        <div class="row">
            <div class="section-headline left-headline text-left">
                <h3 class="text-upper"><span class="color"><?php echo lang('gouvernance'); ?></span></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tab-menu">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#p-view-1" role="tab" data-toggle="tab"><?php echo lang('administration'); ?></a></li>
                        <li><a href="#p-view-2" role="tab" data-toggle="tab"><?php echo lang('direction'); ?></a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="p-view-1">
                        <div class="tab-inner">
                            <div class="event-content about-content text-justify">
                                <?php echo $administration[0]->contenu_texte; ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="p-view-2">
                        <div class="tab-inner">
                            <div class="event-content about-content text-justify">
                                <?php echo $direction[0]->contenu_texte; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="welcome-area mg-50">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="section-headline left-headline text-left">
                    <h3 class="text-upper"><span class="color"><?php echo lang('comite'); ?></span></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="single-team-member direction">
                    <div class="team-img">
                        <a href="#">
                            <img src="<?php echo site_url('upload/'.$directeur[0]->fichier_equipe); ?>" alt="" class="img-responsive">
                        </a>
                    </div>
                    <div class="team-content">
                        <h4><span class="color"><?php echo mb_strtoupper($directeur[0]->prenom_equipe.' '.$directeur[0]->nom_equipe); ?></span></h4>
                        <p><?php echo $directeur[0]->fonction_equipe; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="section-headline left-headline text-left">
                            <h3 class="text-upper"><span class="color"><?php echo lang('biographie'); ?></span></h3>
                        </div>
                        <div class="about-content text-justify">
                            <?php echo $directeur[0]->biographie_equipe; ?>
                        </div>

                        <div class="section-headline left-headline text-left mar-row">
                            <h3 class="text-upper"><span class="color"><?php echo lang('experience'); ?></span></h3>
                        </div>
                        <?php if(!empty($experiences)): ?>
                        <div class="about-content text-justify">
                            <p>
                                <?php foreach($experiences as $experience): ?>
                                <span class="color"><?php echo $experience->periode_experience; ?>:</span> <?php echo $experience->texte_experience; ?><br/>
                                <?php endforeach; ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mar-row">
            <?php foreach($equipes as $equipe): ?>
            <div class="col-md-4">
                <div class="single-team-member direction" style="margin-left: 10px;">
                    <div class="team-img">
                        <a href="#">
                            <img src="<?php echo site_url('upload/'.$equipe->fichier_equipe); ?>" alt="" class="img-responsive">
                        </a>
                    </div>
                    <div class="team-content">
                        <h4><span class="color"><?php echo mb_strtoupper($equipe->prenom_equipe.' '.$equipe->nom_equipe); ?></span></h4>
                        <p><?php echo $equipe->fonction_equipe; ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
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