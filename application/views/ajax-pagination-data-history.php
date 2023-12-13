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
