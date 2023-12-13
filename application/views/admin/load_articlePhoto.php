<?php
// Check if there are some photos to display
if (!empty($articlePhotos)) {
?>
<div class="portfolio-content portfolio-1">
<!--
    <div id="js-filters-juicy-projects" class="cbp-l-filters-button">
        <div data-filter="*" class="cbp-filter-item-active cbp-filter-item btn dark btn-outline uppercase"> All
            <div class="cbp-filter-counter"></div>
        </div>
        <div data-filter=".identity" class="cbp-filter-item btn dark btn-outline uppercase"> Identity
            <div class="cbp-filter-counter"></div>
        </div>
        <div data-filter=".web-design" class="cbp-filter-item btn dark btn-outline uppercase"> Web Design
            <div class="cbp-filter-counter"></div>
        </div>
        <div data-filter=".graphic" class="cbp-filter-item btn dark btn-outline uppercase"> Graphic
            <div class="cbp-filter-counter"></div>
        </div>
        <div data-filter=".logos" class="cbp-filter-item btn dark btn-outline uppercase"> Logo
            <div class="cbp-filter-counter"></div>
        </div>
    </div>
-->
    <div id="js-grid-juicy-projects" class="cbp">
    <?php
    // Loop through all the article photos and display each
    foreach ($articlePhotos as $articlePhoto) {
        // Set the photo link
        $photoLink  = (!empty($articlePhoto->fichier_photo)) ? base_url()."upload/$aid/".$articlePhoto->fichier_photo : '';

        // Display photo only if the link is correct and not empty
        if (!empty($photoLink)) {
    ?>
        <div class="cbp-item">
            <div class="cbp-caption">
                <div class="cbp-caption-defaultWrap">
                    <img src="<?php echo $photoLink; ?>" alt=""> </div>
                <div class="cbp-caption-activeWrap">
                    <div class="cbp-l-caption-alignCenter">
                        <div class="cbp-l-caption-body">
                            <button onclick="deleteArticlePhoto(<?php echo $articlePhoto->id_photo; ?>)" class="btn red uppercase">Supprimer</button>
                            <a href="<?php echo $photoLink; ?>" class="cbp-lightbox cbp-l-caption-buttonRight btn red uppercase btn red uppercase">Afficher</a>
                        </div>
                    </div>
                </div>
            </div>
<!--
            <div class="cbp-l-grid-projects-title uppercase text-center uppercase text-center">Dashboard</div>
            <div class="cbp-l-grid-projects-desc uppercase text-center uppercase text-center">Web Design / Graphic</div>
-->
        </div>
    <?php
        } // Enf if

    } // End loop
    ?>
    </div>
<!--
    <div id="js-loadMore-juicy-projects" class="cbp-l-loadMore-button">
        <a href="../assets/global/plugins/cubeportfolio/ajax/loadMore.html" class="cbp-l-loadMore-link btn grey-mint btn-outline" rel="nofollow">
            <span class="cbp-l-loadMore-defaultText">LOAD MORE</span>
            <span class="cbp-l-loadMore-loadingText">LOADING...</span>
            <span class="cbp-l-loadMore-noMoreLoading">NO MORE WORKS</span>
        </a>
    </div>
-->
</div>
<?php
} else {
?>
<h3 class="text-center text-info">Aucune image disponible</h3>
<?php
} // End if
?>



<script src="<?php echo base_url(); ?>assets/admin/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/portfolio-1.min.js" type="text/javascript"></script>