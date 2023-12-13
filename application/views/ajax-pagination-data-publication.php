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