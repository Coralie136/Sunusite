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

<div class="blog-page-area area-padding">
    <div class="container">
        <div class="row">
            <div class="section-headline left-headline text-left">
                <h3 class="text-upper"><span class="color"><?php echo lang('actualites'); ?></span></h3>
            </div>
        </div>
        <div class="row">
            <div class=" blog-page-details">
                <!-- Start single blog -->
                <div class="col-md-8 col-sm-8 col-xs-12">
                   <!-- single-blog start -->
                    <article class="blog-post-wrapper">
                        <div class="blog-banner">
                            <?php 
                                if(!empty($photos)): 
                            ?>
                            <div class="blog-images" id="actu_caroussel2">
                                <div class="item">
                                    <img src="<?php echo site_url('upload/article/'.$actualite[0]->fichier_article); ?>" alt="<?php echo $actualite[0]->titre_article; ?>">
                                </div>
                                <?php foreach($photos as $photo): ?>
                                <div class="item">
                                    <img src="<?php echo site_url('upload/'.$photo->id_article.'/'.$photo->fichier_photo); ?>" alt="" />
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php else: ?>
                            <div class="blog-images">
                                <div class="item">
                                    <img src="<?php echo site_url('upload/article/'.$actualite[0]->fichier_article); ?>" alt="<?php echo $actualite[0]->titre_article; ?>">
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="blog-content">
                                <a href="#"><h4><span class="color"><?php echo $actualite[0]->titre_article; ?></span></h4></a>
                                <p><?php echo $actualite[0]->texte_article; ?></p>
                            </div>
                        </div>
                    </article>
                    <div class="clear"></div>
                </div>
                <!-- End main column -->
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="left-head-blog">
                        <div class="left-blog-page">
                            <!-- recent start -->
                            <div class="left-blog">
                                <h4><span class="color"><?php echo lang('autre_actu'); ?></span></h4>
                                <div class="recent-post">
                                    <?php 
                                        foreach($actus as $actu):
                                            $lien = $actu->id_article.'-'.$this->fonctions->ConvertIntoUrl($actu->titre_article);
                                    ?>
                                    <div class="recent-single-post">
                                        <div class="post-img">
                                            <a href="<?php echo site_url('actualites/'.$lien); ?>">
                                                <img src="<?php echo site_url('upload/article/'.$actu->fichier_article); ?>" alt="">
                                            </a>
                                        </div>
                                        <div class="pst-content">
                                            <p><a href="<?php echo site_url('actualites/'.$lien); ?>"><?php echo $actu->titre_article; ?></a></p>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <!-- recent end -->
                        </div>
                    </div>
                </div>
                <!-- End left sidebar -->
            </div>
        </div>
        <!-- End row -->
    </div>
</div>

