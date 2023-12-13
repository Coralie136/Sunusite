<?php echo '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo base_url();?></loc>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc><?php echo base_url('legroupe');?></loc>
        <priority>1.0</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc><?php echo base_url('legroupe/historique');?></loc>
        <priority>1.0</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc><?php echo base_url('legroupe/chiffrescles');?></loc>
        <priority>1.0</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc><?php echo base_url('legroupe/gouvernance');?></loc>
        <priority>1.0</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc><?php echo base_url('legroupe/publications');?></loc>
        <priority>1.0</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc><?php echo base_url('notrereseau');?></loc>
        <priority>1.0</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc><?php echo base_url('notrereseau/filiales');?></loc>
        <priority>1.0</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc><?php echo base_url('actualites');?></loc>
        <priority>0.9</priority>
        <changefreq>weekly</changefreq>
    </url>

    <!-- Sitemap -->
    <?php 
        foreach($items as $item) { 
            // if($lang == 'fr') $titre = $item->titre_article;
            // else $titre = $item->titre_article_en;
    ?>
    <url>
        <loc><?php echo base_url()."actualites/".$item->id_article.'-'.$this->fonctions->ConvertIntoUrl($item->titre_article); ?></loc>
        <priority>0.9</priority>
        <changefreq>weekly</changefreq>
    </url>
    <?php } ?>
</urlset>