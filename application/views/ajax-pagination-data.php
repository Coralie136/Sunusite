<div class="col-md-12">
    <?php 
        foreach($articles as $article):
            $lien = $article->id_article.'-'.$this->fonctions->ConvertIntoUrl($article->titre_article);
    ?>
    <div class="row listActu">
        <div class="col-md-5 col-sm-12 col-xs-12">
            <div class="single-page">
                <div class="page-img elec-page">
                    <img src="<?php echo site_url('upload/article/'.$article->fichier_article); ?>" alt="">
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
    <?php echo $this->ajax_pagination->create_links(); ?>