<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Aanpassen (<?= $cat->name ?>)</h3>
    </div>
    <div class='panel-body'>
        <?= $errors; ?>
        <?= form_open('categories/edit/' . $cat->id); ?> 
        <div class='row'>
            <div class='col-sm-4'>
                <div class="form-group">
                    <label for="name">Categorie-naam</label>
                    <?php echo form_input($name); ?>
                </div>
            </div>
            <div class='col-sm-4'>
                <div class="form-group">
                    <label for="sort">Positie</label>
                    <?php echo form_input($sort); ?>
                </div>
            </div>
            <div class='col-sm-4'>
                <div class="form-group">
                    <label for="url">Link - Url</label>
                    <?php echo form_input($url); ?>
                </div>
            </div>
        </div>

        <input type="submit" class="btn btn-default btn-xs" value="Aanpassen!" />

        <?= form_close(); ?>
    </div>   
</div>