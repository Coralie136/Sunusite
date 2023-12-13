<?php
    if (isset($produits[0])) {
        if ($produits[0]->slide != '') {
            $slide = $produits[0]->slide;
        } else {
            $slide = 'mixte.jpg';
        }
        $accroche = $produits[0]->accroche;
        $nom_produit = $produits[0]->nom_produit;
    } else {
        $slide = 'mixte.jpg';
        $accroche = '';
        $nom_produit = '';
    }
    
?>
        <div class="intro-area intro-area-2">
           <div class="main-overly"></div>
            <div class="intro-carousel0">
                <div class="intro-content">
                    <div class="slider-images">
                        <img src="<?php echo site_url('assets/images/slider/'.$slide); ?>" alt="">
                    </div>
                </div>
            </div>
        </div>

        <?php 
            if(!isset($message)):
                if(!empty($produits)):
        ?>

        <div class="welcome-area mg-50" id="#resultat">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="section-headline text-center">
                            <h2><?php echo lang('with'); ?> SUNU ASSURANCES</h2>
                        </div>
                        <h3 class="txtProfil text-center"><span class="color"><?php echo $name; ?></span>, <?php echo lang('avec') ?> <?php echo $nom_produit.' '.$accroche; ?></h3>
                    </div>
                </div>
                <div class="row produits">
                    <div class="col-md-10 col-md-offset-1">
                        <h3 class="text-center"><span class="color"><?php echo lang('produits'); ?></span></h3>
                        <?php 
                            $n = sizeof($produits);
                            if($n == 1 ) $class = "col-md-4 col-sm-4 col-md-offset-4";
                            else $class = "col-md-4 col-sm-4";
                        ?>
                            <?php 
                                if($n == 2):
                            ?>
                            <div class="col-md-2 col-sm-2">
                                
                            </div>
                            <?php endif; ?>
                        <?php foreach($produits as $produit): ?>
                        <div class="<?php echo $class; ?> col-xs-12">
                            <div class="well-services text-center">
                                <div class="services-img">
                                    <img src="<?php echo site_url('assets/images/'.$produit->image) ?>" alt="">
                                </div>
                                <div class="main-services">
                                    <div class="service-content">
                                        <h3><?php echo $produit->nom_produit; ?></h3>
                                    </div>
                                        <p><?php echo $produit->texte; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="welcome-area mgt-20">
            <div class="container">
               <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 prodContact">
                        <h3 class="text-center"><span class="color"><?php echo $pays[0]->nom_pays; ?>:</span></h3>
                        <?php 
                            $n = sizeof($contacts);
                            if($n > 1):
                        ?>
                        <div class="col-md-10 col-md-offset-1 cont">
                            <?php foreach($contacts as $contact): ?>
                            <div class="col-md-6 cont">
                                <div class="paysContact">
                                    <!-- <h4><span class="color">SUNU Assurance <?php echo $contact->nom_type_produit; ?></span></h4> -->
                                    <p><?php echo $contact->contact; ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php 
                            else:
                        ?>
                        <div class="col-md-4 col-md-offset-4">
                            <div class="paysContact nomarge">
                                <!-- <h4><span class="color">SUNU Assurance <?php echo $contacts[0]->nom_type_produit; ?></span></h4> -->
                                <p><?php echo $contacts[0]->contact; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 infoMail">
                        <input type="hidden" name="id_client" class="id_client" value="<?php echo $id_client; ?>">
                        <!-- <a href="#" title="" class="ready-btn" id="sendResult">JE SOUHAITE RECEVOIR PAR MAIL CES INFORMATIONS</a> -->
                        <a href="#" title="" class="ready-btn" id="sendResult"><?php echo lang('souhait'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <?php 
                else:
        ?>
        <div class="page-head area-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="error-page">
                                <!-- map area -->
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="error-main-text text-center">
                                        <h2 class="error-easy-text"><?php echo lang('aucun'); ?></h2>
                                        <a  class="error-btn" href="<?php echo site_url(); ?>"><?php echo lang('back'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
                endif;
            else: 
        ?>

        <div class="page-head area-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="error-page">
                                <!-- map area -->
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="error-main-text text-center">
                                        <h2 class="error-easy-text"><?php echo $message; ?></h2>
                                        <a  class="error-btn" href="<?php echo site_url(); ?>"><?php echo lang('back'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <?php endif; ?>