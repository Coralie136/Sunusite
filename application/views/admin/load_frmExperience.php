<?php
    // Process only if an experience is defined
    if (isset($experience)) {
        
        // title to be set on experience form
        $frmTitle   = (empty($experience)) ? "Ajouter une exp&eacute;rience" : "Modifier l'exp&eacute;rience";
        $frmAction  = site_url('admin/group/addExperience');
        $submit     = (empty($experience)) ? "Ajouter" : "Modifier";
        $icon       = (empty($experience)) ? "plus" : "edit";
        $disabled   = ($readOnly == 'true') ? 'disabled="disabled"' : '';
        $did        = ((int)$did > 0) ? (int)$did : 0;
        
        // if there is a selected experience
        if (!empty($experience)) { // set experience informations
            
            // experience's informations
            $experiencePeriod   = (!empty($experience[0]->periode_experience)) ? $experience[0]->periode_experience : '';
            $experienceText     = (!empty($experience[0]->texte_experience)) ? $experience[0]->texte_experience : '';
            $experienceTextEn   = (!empty($experience[0]->texte_experience_en)) ? $experience[0]->texte_experience_en : '';
            
            // experience's id
            $eid                = $experience[0]->id_experience;
            
        } else { // empty all experience's informations
            
            // experience's informations
            $experiencePeriod   = date('Y');
            $experienceText     = '';
            $experienceTextEn   = '';
            
            // experience's id
            $eid                = 0;
            
        }
        
        // if form has been asked in readonly access
        if ($readOnly == 'true') {
            $color      = 'blue-steel';
            $frmTitle   = "D&eacute;tails exp&eacute;rience: ".ucwords($experiencePeriod);
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
                    <div class="col-md-12">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" name="txt_period" id="txt_period" class="form-control" placeholder="Période de l'expérience" required="required" autofocus="autofocus" <?php echo $disabled; ?> value="<?php echo $experiencePeriod; ?>" />
                            <label for="txt_period">P&eacute;riode <span class="required">*</span></label>
                            <span class="help-block">P&eacute;riode de l'experience</span>
                        </div>
                    </div>
                </div><br />
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" name="txt_experience" id="txt_experience" class="form-control" placeholder="Conténu de l'expérience" required="required" <?php echo $disabled; ?> value="<?php echo $experienceText; ?>" />
                            <label class="control-label" for="txt_experience">Texte (fran&ccedil;ais) <span class="required">*</span></label>
                            <span class="help-block">Cont&eacute;nu de l'experience</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" name="txt_experience_en" id="txt_experience_en" class="form-control" placeholder="Conténu de l'expérience" required="required" <?php echo $disabled; ?> value="<?php echo $experienceTextEn; ?>" />
                            <label class="control-label" for="txt_experience_en">Texte (anglais) <span class="required">*</span></label>
                            <span class="help-block">Cont&eacute;nu de l'experience</span>
                        </div>
                    </div>
                </div><br />
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
                <input type="hidden" name="did" id="did" value="<?php echo $did; ?>" />
                <input type="hidden" name="eid" id="eid" value="<?php echo $eid; ?>" />
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
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/custom.js" type="text/javascript"></script>
<?php
    }
?>