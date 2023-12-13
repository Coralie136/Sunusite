<div class="intro-area intro-area-2 acc">
   <div class="main-overly"></div>
    <div class="intro-carousel">
        <div class="intro-content">
            <div class="slider-images">
                <img src="<?php echo site_url('assets/images/slider/3.jpg') ?>" alt="">
            </div>
        </div>
        <div class="intro-content">
            <div class="slider-images">
                <img src="<?php echo site_url('assets/images/slider/4.jpg') ?>" alt="">
            </div>
        </div>
        <div class="intro-content">
            <div class="slider-images">
                <img src="<?php echo site_url('assets/images/slider/5.jpg') ?>" alt="">
            </div>
        </div>
        <div class="intro-content">
            <div class="slider-images">
                <img src="<?php echo site_url('assets/images/slider/6.jpg') ?>" alt="">
            </div>
        </div>
        <div class="intro-content">
            <div class="slider-images">
                <img src="<?php echo site_url('assets/images/slider/7.jpg') ?>" alt="">
            </div>
        </div>
        <div class="intro-content">
            <div class="slider-images">
                <img src="<?php echo site_url('assets/images/slider/8.jpg') ?>" alt="">
            </div>
        </div>
        <div class="intro-content">
            <div class="slider-images">
                <img src="<?php echo site_url('assets/images/slider/10.jpg') ?>" alt="">
            </div>
        </div>
        <div class="intro-content">
            <div class="slider-images">
                <img src="<?php echo site_url('assets/images/slider/11.jpg') ?>" alt="">
            </div>
        </div>
        <div class="intro-content">
            <div class="slider-images">
                <img src="<?php echo site_url('assets/images/slider/12.jpg') ?>" alt="">
            </div>
        </div>
    </div>
    <div class="formulaire hidden-sm  hidden-xs"><!-- hidden-md -->
        <div class="display-table">
            <div class="display-table-cell">
                <!-- <div class="container"> -->
                    <div class="row">
                        <div class="col-md-12" id="profil1">
                            <div class="layer-1-2">
                                <h1 class="title2"><span class="color"><?php echo lang('profil'); ?></span></h1>
                            </div>
                            <div class="layer-1-3">
                                <a href="#" class="ready-btn left-btn" id="MonProfil" >
                                    <div><?php echo lang('decouvre'); ?></div>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12" id="profil">
                            <div class="layer-1-2">
                                <h1 class="title2"><span class="color"><?php echo lang('profil1'); ?> <br/> <?php echo lang('profil2'); ?></span></h1>
                            </div>
                            <div class="layer-1-3">
                                <a href="#" class="ready-btn left-btn" >
                                    <div><?php echo lang('decouvre'); ?></div>
                                </a>
                            </div>
                            <div class="layer-1-3">
                                <form action="<?php echo site_url('profil') ?>" method="POST" accept-charset="utf-8" id="profilForm" autocomplete='off'>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="nom" placeholder="Nom" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="prenoms" placeholder="Prénoms" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="telephone" placeholder="Numéro de téléphone" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="Adresse mail" required>
                                    </div>
                                    <div class="form-group" required>
                                        <select name="id_pays" class="form-control select">
                                            <option value=""><?php echo lang('pays'); ?></option>
                                            <?php foreach($payss as $pays): ?>
                                            <option value="<?php echo $pays->id_pays; ?>"><?php echo $pays->nom_pays; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select id="pro" name="id_categorie" class="form-control select" required>
                                            <option value=""><?php echo lang('categorie'); ?></option>
                                            <?php foreach($categories as $categorie): ?>
                                            <option value="<?php echo $categorie->id_categorie; ?>"><?php echo $categorie->nom_categorie; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="id_age" class="form-control select" required>
                                            <option value=""><?php echo lang('age'); ?></option>
                                            <?php foreach($ages as $age): ?>
                                            <option value="<?php echo $age->id_age; ?>"><?php echo $age->nom_age.' ans'; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="id_souscription" class="form-control select" required>
                                            <option value=""><?php echo lang('souscrip'); ?></option>
                                            <?php foreach($souscriptions as $souscription): ?>
                                            <option value="<?php echo $souscription->id_souscription; ?>"><?php echo $souscription->nom_souscription; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group" id="lassurable">
                                        <select name="id_assurable[]" class="form-control ignore" data-placeholder="<?php echo lang('precieux'); ?>" multiple required>
                                            <!-- <option value="" selected disabled>Qu'avez-vous de précieux?</option> -->
                                            <?php foreach($assurables as $assurable): ?>
                                            <option value="<?php echo $assurable->id_assurable; ?>"><?php echo $assurable->nom_assurable; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="Valider" value="<?php echo lang('valider'); ?>">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>

<div class="mg-50 hidden-lg hidden-md">
    <div class="container-full">
        <!-- <div class="row"> -->
            <div class="formulaire2">
                <!-- <div class="row"> -->
                    <div class="col-md-12" id="profil">
                        <div class="layer-1-2">
                            <h1 class="title2"><span class="color"><?php echo lang('profil1') ?> <br/> <?php echo lang('profil2'); ?></span></h1>
                        </div>
                        <div class="layer-1-3">
                            <a href="#" class="ready-btn left-btn" id="proFormAction" >
                                <div><?php echo lang('decouvre'); ?></div>
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </div>
                        <div class="layer-1-3" id="proForm">
                            <form action="<?php echo site_url('profil') ?>" method="POST" accept-charset="utf-8" id="profilForm" autocomplete='off'>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="prenoms" placeholder="Prénoms" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="telephone" placeholder="Numéro de téléphone" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Adresse mail" required>
                                </div>
                                <div class="form-group" required>
                                    <select name="id_pays" class="form-control select">
                                        <option value=""><?php echo lang('pays'); ?></option>
                                        <?php foreach($payss as $pays): ?>
                                        <option value="<?php echo $pays->id_pays; ?>"><?php echo $pays->nom_pays; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="pro1" name="id_categorie" class="form-control select" required>
                                        <option value=""><?php echo lang('categorie'); ?></option>
                                        <?php foreach($categories as $categorie): ?>
                                        <option value="<?php echo $categorie->id_categorie; ?>"><?php echo $categorie->nom_categorie; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="id_age" class="form-control select" required>
                                        <option value=""><?php echo lang('age'); ?></option>
                                        <?php foreach($ages as $age): ?>
                                        <option value="<?php echo $age->id_age; ?>"><?php echo $age->nom_age.' ans'; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="id_souscription" class="form-control select" required>
                                        <option value=""><?php echo lang('souscrip'); ?></option>
                                        <?php foreach($souscriptions as $souscription): ?>
                                        <option value="<?php echo $souscription->id_souscription; ?>"><?php echo $souscription->nom_souscription; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group" id="lassurable1">
                                    <select name="id_assurable[]" class="form-control ignore" multiple data-placeholder="<?php echo lang('precieux'); ?>" required>
                                        <!-- <option value="0" selected>Qu'avez-vous de précieux?</option> -->
                                        <?php foreach($assurables as $assurable): ?>
                                        <option value="<?php echo $assurable->id_assurable; ?>"><?php echo $assurable->nom_assurable; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="Valider" value="Valider">
                                </div>
                            </form>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
        <!-- </div> -->
    </div>
</div>

<div class="mg-50">
    <div class="container-fluid" style="padding-left: 0;">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12" style="padding-right: 0;">
                <div class="carte-inner blkCarte">
                    <h2><span class="color"><?php echo lang('reseau_sunu'); ?></span></h2>
                   <div class="jsmaps-wrapper" id="sunu-map"></div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="about-count row blkCarte">
                    <div class="titre-actu col-lg-5 col-md-6 col-md-offset-6 col-sm-8 col-sm-offset-4">
                        <h2><?php echo lang('actualites'); ?></h2>
                    </div>
                    <div id="actu_caroussel" class=" col-md-12 col-sm-12" style="padding-left: 0;padding-right: 0; background: #C6183C; height: 100%;">
                    <?php 
                        foreach($actus as $actu):
                            $lien = $actu->id_article.'-'.$this->fonctions->ConvertIntoUrl($actu->titre_article);
                    ?>
                        <div class="content-actu col-md-12 col-sm-12">
                            <div class="col-lg-5 col-md-12">
                                <img src="<?php echo site_url('upload/article/'.$actu->fichier_article); ?>" class="img-responsive hidden-lg hidden-xs" style="float: right; margin-left: 15px; margin-bottom: 15px; width: 50%;" alt="<?php echo $actu->titre_article; ?>">
                                <p><strong><?php echo $actu->titre_article; ?></strong><?php echo $this->fonctions->truncate($actu->texte_article, 270, '[...]') ; ?></p>
                                <br/>
                                <a href="<?php echo site_url('actualites/'.$lien); ?>" title="" class="plus-btn left-btn"><?php echo lang('plus'); ?></a>
                            </div>
                            <div class="col-lg-7 col-md-12 col-sm-6 hidden-sm hidden-xs hidden-md" style="padding-left: 0">
                                <div class="content-img ">
                                    <img src="<?php echo site_url('upload/article/'.$actu->fichier_article); ?>" alt="<?php echo $actu->titre_article; ?>">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- end Row -->
    </div>
</div>