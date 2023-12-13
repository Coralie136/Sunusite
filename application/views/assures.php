<select name="id_assurable[]" class="form-control ignore" data-placeholder="<?php echo lang('precieux'); ?>" multiple required>
    <!-- <option value="" selected disabled>Qu'avez-vous de précieux?</option> -->
    <?php foreach($assurables as $assurable): ?>
    <option value="<?php echo $assurable->id_assurable; ?>"><?php echo $assurable->nom_assurable; ?></option>
    <?php endforeach; ?>
</select>