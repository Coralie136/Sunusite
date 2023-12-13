<?php
    //$date   = date('d-m-Y');
    $date   = "";
//var_dump($clients); die();
/*if (!empty($clients)) {

    //var_dump($clients); die();
    $dt_date_debut  = (!empty($clients[0]->dt_date_debut)) ? $clients[0]->dt_date_debut : '';
    $dt_date_fin = (!empty($clients[0]->dt_date_fin)) ? $clients[0]->dt_date_fin : '';
    $id_pays = (!empty($clients[0]->id_pays))  ? $clients[0]->id_pays : 0;
    $id_assurable = (!empty($clients[0]->id_assurable))  ? $clients[0]->id_assurable : 0;
    $id_categorie = (!empty($clients[0]->id_categorie))  ? $clients[0]->id_categorie : 0;
    $id_age = (!empty($clients[0]->id_age))  ? $clients[0]->id_age : 0;

    $array_reasurables = array();

    //var_dump($id_assurable); die();
    $n = strlen($id_assurable);
    for ($i=0; $i < $n; $i++) {
        $list = explode('|', $contact[$i]->id_assurable);
        $p = sizeof($list);
        for ($j=0; $j < $p; $j++) {
            if($list[$j] != ''){
                //var_dump($list[$j]);
                $array_reasurables[$j] =  $list[$j];
            }
        }
    }
} else {
    $id_assurable = "";
    $id_categorie  = '';
    $id_age = '';
    $id_pays   = '';
    $array_reasurables = array();
    $dt_date_debut  = date("d-m-Y", strtotime(date('d-m-Y'). "- 1 year"));
    $dt_date_fin = date("d-m-Y", strtotime(date('d-m-Y'). "+ 1 year"));
}*/

if(empty($post)){
    $id_assurable = "";
    $id_categorie  = '';
    $id_age = '';
    $id_pays   = '';
    $exporter = '';
    $id_post_pays = '';
    $array_reasurables = array();
    $dt_date_debut  = date("d-m-Y", strtotime(date('d-m-Y'). "- 1 year"));
    $dt_date_fin = date("d-m-Y", strtotime(date('d-m-Y'). "+ 1 day"));
}
else {
    $dt_date_debut  = $dt_post_date_debut;
    $dt_date_fin = $dt_post_date_fin;
    $array_reasurables = $id_post_assurable;
    $exporter = $post_exporter;
    $id_categorie = $post_CATEGORIE;
    $id_age = $post_AGE;
    $id_pays = $id_post_pays;
    $id_montant = $post_MONTANT;
}
?>
<style>
    .datepicker.dropdown-menu {
        padding: 5px;
        box-shadow: 5px 5px rgba(102,102,102,.1);
        border: 1px solid #efefef;
        z-index: 100000 !important;
    }
</style>
<!-- BEGIN CONTENT -->
<div class="page-content">
   
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> <?php echo strtoupper($page_title); ?> <br />
        <small>[ <?php echo ucfirst($page_description); ?> ]</small>
    </h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->

    <!-- SEARCH FORM -->
    <div class="row" id="filtre">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>Filtre</b>
                </div>
                <div class="panel-body">
                    <form id="form_search" name="form_search" method="POST" action="<?php echo site_url('admin/monbonprofil'); ?>" >
                        <div class="col-md-3">
                            <label class="control-label">Date de début </label>
                            <div class="input-group input-medium date date-picker" data-date="" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                <input type="text" class="form-control" name="dt_date_debut" id="dt_date_debut" value="<?php echo $dt_date_debut; ?>">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Date de fin </label>
                            <div class="input-group input-medium date date-picker" data-date="" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                <input type="text" class="form-control"  name="dt_date_fin" id="dt_date_fin" value="<?php echo $dt_date_fin; ?>">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="str_PAYS">Pays </label>
                            <select name="id_pays" class="form-control select2">
                                <option value=""> pays</option>
                                <?php foreach($payss as $pays): ?>
                                    <option value="<?php echo $pays->id_pays; ?>"
                                        <?php if($id_pays == $pays->id_pays) echo "selected='selected'"; ?>
                                    ><?php echo $pays->nom_pays; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="control-label" for="id_assurable">Assurables  </label>
                            <select name="id_assurable[]" class="form-control ignore select2" data-placeholder="" multiple >
                                <?php

                                if (isset($array_reasurables) ) {;

                                    foreach ($assurables as $assurable) {
                                        $select = '';

                                        $i = 0;
                                        foreach($array_reasurables as $array_reasurable)
                                        {
                                            //var_dump($data , $assurable->id_assurable);
                                            $data = str_replace("'", '', $array_reasurables[$i]);
                                            if ($data == $assurable->id_assurable) {
                                                $select = 'selected="selected"';
                                                break;
                                            } else {
                                                $select = '';
                                            }
                                            $i++;
                                        }

                                        ?>
                                        <option value="<?php echo $assurable->id_assurable; ?>" <?php echo $select; ?> >
                                            <?php echo $assurable->nom_assurable; ?>
                                        </option>
                                        <?php
                                    }
                                } // End if
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="str_CATEGORIE">Categorie socio pro. </label>
                            <select name="str_CATEGORIE" class="form-control select2">
                                <option value="" > Categorie socio pro.</option>
                                <?php foreach($categories as $categorie): ?>
                                    <option value="<?php echo $categorie->id_categorie; ?>"
                                    <?php if($id_categorie == $categorie->id_categorie) echo "selected='selected'"; ?>
                                    >
                                        <?php echo $categorie->nom_categorie; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="str_AGE">Tranche d'age </label>
                            <select name="str_AGE" class="form-control select2">
                                <option value="" > Tranche d'age</option>
                                <?php foreach($ages as $age): ?>
                                    <option value="<?php echo $age->id_age; ?>"
                                    <?php if($id_age == $age->id_age) echo "selected='selected'"; ?>
                                    ><?php echo $age->nom_age; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="int_MONTANT">Montant épargné </label>
                            <select name="int_MONTANT" class="form-control select2">
                                <option value="" > Montant épargné</option>
                                <?php foreach($souscriptions as $souscription): ?>
                                    <option value="<?php echo $souscription->id_souscription; ?>"
                                    <?php if($id_montant == $souscription->id_souscription) echo "selected='selected'"; ?>
                                    ><?php echo $souscription->nom_souscription; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exporter">Exporter ? </label>
                            <input type="checkbox" name="exporter" id="exporter" <?php if(!empty($exporter)) echo "checked='checked'"; ?> >
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <button id="submit-import-file" type="submit" class="btn red-thunderbird"><i class="fa fa-search"></i>  Afficher / exporter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END SEARCH FORM -->

    <!-- BEGIN PAGE BODY -->
    <div class="row">
        <div class="col-md-12">
           
            <!-- BEGIN TABLE PORTLET-->
            <div class="portlet box red-thunderbird">
                
                <!-- BEGIN PORTLET TITLE -->
                <div class="portlet-title">
                    <div class="caption font-light">
                        <i class="fa fa-cogs"></i>
                        <span class="caption-subject"> Liste des inscrits </span>
                    </div>
                </div>
                <!-- END PORTLET TITLE -->

                <!-- BEGIN PORTLET BODY -->
                <div class="portlet-body"><br />
                                
                    <?php
                        $feedBack   = $this->session->flashdata('retour');
                        if (isset($feedBack)) {
                    ?>
                            <div class="alert alert-<?php echo $feedBack['type']; ?> alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <?php echo $feedBack['message']; ?>
                            </div>
                    <?php
                        }
                    ?>

                    <div class="table-toolbar">

                        <!-- Mis en commentaire par JMO le 19/03/2019
                        <div class="row">
                            <div class="col-md-3">
                                <div class="btn-group">
                                    <a href="<?php echo site_url('admin/monbonprofil/export'); ?>" class="btn red-thunderbird" id="extract_data">
                                        <i class="fa fa-file-excel-o"></i>
                                        Exporter la liste
                                    </a>
                                </div>
                            </div>
                        </div>-->
                        
                    </div>
                    
                    <?php
                        $disabledChk    = '';
                    if (empty($clients)) {
                        $disabledChk    = 'disabled="disabled"';
                    }
                    ?>
                    <form method="POST" action="#">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" name="allId" onchange="checkItems()" <?php echo $disabledChk; ?> />
                                            <span></span>
                                        </label>
                                    </th>
                                    <!-- <th> Date </th> -->
                                    <th> Nom </th>
                                    <th> Contacts </th>
                                    <th> Pays </th>
                                    <th> Souscription </th>
                                    <th> Tran. d'âge </th>
                                    <th> Assurables </th>
                                    <th> Catégorie socio pro. </th>
                                    <th> Date d'inscription </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($clients)) {
                                foreach($clients as $client) {
                                    if(!empty($client->id_client)) {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td>
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                    <input type="checkbox" class="checkboxes" name="ids[]"
                                                           value="<?php echo $client->id_client; ?>"/>
                                                    <span></span>
                                                </label>
                                            </td>

                                            <td class="sbold">
                                                <?php echo $client->nom . ' ' . $client->prenoms; ?>
                                            </td>

                                            <td>
                                                <?php echo $client->email . '<br/>' . $client->telephone; ?>
                                            </td>

                                            <td>
                                                <?php echo $client->nom_pays; ?>
                                            </td>

                                            <td>
                                                <?php echo $client->nom_souscription; ?>
                                            </td>

                                            <td>
                                                <?php echo $client->nom_age; ?>
                                            </td>

                                            <td>
                                                <?php echo $client->assurables; ?>
                                            </td>

                                            <td>
                                                <?php echo $client->nom_categorie; ?>
                                            </td>

                                            <td>
                                                <i><?php echo $this->fonctions->dtDisplayNoLe($client->dates_inscription); ?></i>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </form>
                    
                </div>
                <!-- END PORTLET BODY -->
                
            </div>
            <!-- END TABLE PORTLET -->
            
        </div>
    </div>
    
</div>
<script>
    $(document).ready(function(){

        $(".select2, .select2-multiple").select2({placeholder:"Select an elements",width:null})

    });
</script>