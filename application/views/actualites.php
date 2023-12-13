<div class="intro-area intro-area-2">
   <div class="main-overly"></div>
    <div class="intro-carousel0">
        <div class="intro-content">
            <div class="slider-images">
                <img src="<?php echo (!empty($images[0]->fichier_image)?site_url('upload/image_site/').$images[0]->fichier_image:site_url('assets/images/actualites.jpg')); ?>" alt="Actualités – SUNU ASSURANCES">
            </div>
        </div>
    </div>
</div>
<div class="welcome-area mg-50">
    <div class="container">
        <div class="row">
            <div class="section-headline left-headline text-left">
                <h3 class="text-upper"><span class="color"><?php echo lang('actualites'); ?></span></h3>
            </div>
        </div>
        <div class="row" id="actus">
            <div class="col-md-12">
                <?php 
                    foreach($articles as $article):
                        $lien = $article->id_article.'-'.$this->fonctions->ConvertIntoUrl($article->titre_article);
                ?>
                <div class="row listActu">
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="single-page">
                            <div class="page-img elec-page">
                                <img src="<?php echo site_url('upload/article/'.$article->fichier_article); ?>" alt="<?php echo $article->titre_article; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="single-well">
                            <a href="<?php echo site_url('actualites/'.$lien); ?>">
                                <h4><span class="color"><?php echo $article->titre_article; ?></span></h4>
                            </a>
                            <p><?php echo $article->texte_article; ?></p>
                        </div>
                    </div>
                    <!-- End single page -->
                </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php echo $this->ajax_pagination->create_links(); ?>
           </div>
        </div>
    </div>
</div>