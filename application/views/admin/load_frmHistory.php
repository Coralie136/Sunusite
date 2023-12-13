<?php
    // Process only if an history is defined
    if (isset($history)) {
        
        // title to be set on history form
        $frmTitle   = (empty($history)) ? "Ajouter un historique" : "Modifier l'historique";
        $frmAction  = site_url('admin/group/addHistory');
        $submit     = (empty($history)) ? "Ajouter" : "Modifier";
        $icon       = (empty($history)) ? "plus" : "edit";
        $disabled   = ($readOnly == 'true') ? 'disabled="disabled"' : '';
        
        // Set an array of all the month available in a year
        $month  = array(
            '0'     => 'aucun',
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
        
        // if there is a selected history
        if (!empty($history)) { // set history informations
            
            // history's informations
            $historyYear    = (!empty($history[0]->annee_historique)) ? $history[0]->annee_historique : date('Y');
            $historyMonth   = (!empty($history[0]->mois_historique)) ? $history[0]->mois_historique : date('n');
            $historyText    = (!empty($history[0]->texte_historique)) ? $history[0]->texte_historique : '';
            $historyTextEn  = (!empty($history[0]->texte_historique_en)) ? $history[0]->texte_historique_en : '';
            
            // history's id
            $hid                = $history[0]->id_historique;
            
        } else { // empty all history's informations
            
            // history's informations
            $historyYear    = date('Y');
            $historyMonth   = date('n');
            $historyText    = '';
            $historyTextEn  = '';
            
            // history's id
            $hid                = 0;
            
        }
        
        // if form has been asked in readonly access
        if ($readOnly == 'true') {
            $color      = 'blue-steel';
            $frmTitle   = "Détails historique: ".ucfirst($month[$historyMonth]).' '.$historyYear;
            $frmAction  = "";
        }
?>

    <form action="<?php echo $frmAction; ?>" method="POST" name="form_add" id="form_add" class="horizontal-form">
       
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title font-<?php echo $color; ?>"><?php echo $frmTitle; ?></h4>
        </div>
        <div class="modal-body">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label">
                            Mois
                        </label>
                        <select class="form-control select2" name="slt_month" id="slt_month" <?php echo $disabled; ?>>
                        <?php
                        for ($m = 0; $m < 13; $m++) {
                            $select = '';
                            if (!empty($historyMonth)) {
                                if ($m == $historyMonth) {
                                    $select = 'selected="selected"';
                                } else {
                                    $select = '';
                                } 
                            }
                        ?>
                            <option value="<?php echo $m; ?>" <?php echo $select; ?>>
                                <?php echo ucfirst($month[$m]); ?>
                            </option>
                        <?php
                        } // End loop
                        ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">
                            Année <span class="required">*</span>
                        </label>
                        <select class="form-control select2" name="slt_year" id="slt_year" required="required" <?php echo $disabled; ?>>
                        <?php
                        for ($year = 2030; $year > 1997; $year--) {
                            $select = '';
                            if (!empty($historyYear)) {
                                if ($year == $historyYear) {
                                    $select = 'selected="selected"';
                                } else {
                                    $select = '';
                                } 
                            }
                        ?>
                            <option value="<?php echo $year; ?>" <?php echo $select; ?>>
                                <?php echo ucfirst($year); ?>
                            </option>
                        <?php
                        } // End loop
                        ?>
                        </select>
                    </div>
                </div><br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <textarea class="ckeditor form-control" name="txt_history" id="txt_history" required="required" <?php echo $disabled; ?> autofocus="autofocus"><?php echo $historyText; ?></textarea>
                            <label for="txt_history">
                                Texte (fran&ccedil;ais) <span class="required">*</span>
                            </label>
                            <span class="help-block">Texte de l'historique</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <textarea class="ckeditor form-control" name="txt_history_en" id="txt_history_en" required="required" <?php echo $disabled; ?> autofocus="autofocus"><?php echo $historyTextEn; ?></textarea>
                            <label for="txt_history_en">
                                Text (anglais) <span class="required">*</span>
                            </label>
                            <span class="help-block">History text</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="form-actions">
                <?php
                if ($readOnly == 'true') {
                ?>
                <input type="button" data-dismiss="modal" class="btn <?php echo $color; ?>" value="Ok" />
                <?php
                } else {
                ?>
                <input type="button" data-dismiss="modal" class="btn btn-outline <?php echo $color; ?>" value="Annuler" />
                <button type="submit" class="btn <?php echo $color; ?>"><?php echo $submit; ?> <i class="fa fa-<?php echo $icon; ?>"></i></button>
                <input type="hidden" name="hid" id="hid" value="<?php echo $hid; ?>" />
                <?php
                }
                ?>
            </div>
        </div>
    </form>

<!-- JS SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/admin/global/scripts/app.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/admin/global/plugins/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/custom.js" type="text/javascript"></script>
<?php
    }
?>