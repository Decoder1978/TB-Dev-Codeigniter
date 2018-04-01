<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Overzicht categories</h3>
    </div>

    <div class='panel-body'>
        <?= $errors; ?>
        <?= form_open('categories'); ?> 
        <div class='row'>
            <div class='col-sm-4'>
                <div class="form-group">
                    <label for="name">Naam</label>
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
                    <label for="url">Url</label>
                    <?php echo form_input($url); ?>
                </div>
            </div>
        </div>

        <input type="submit" class="btn btn-default btn-xs" value="Verzenden" />

        <?= form_close(); ?>
    </div>  

    <table class="table table-bordered table-striped">
        <thead>
        <th style='width: 80px;'>ID</th>
        <th style='width: 300px;'>Naam</th>
        <th class='nobr'>Positie</th>
        <th>Url</th>
        <th>Akties</th>

        </thead>

        <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= $cat->id ?></td>
                <td><?= $cat->name ?></td>
                <td><?= $cat->sort ?></td>
                <td class='nobr'><?= $cat->url ?></td>
                <td align='center'>
                    <?= anchor('categories/edit/' . $cat->id, '<span class="glyphicon glyphicon-pencil"></span>', array('title' => 'Aanpassen', 'class' => 'btn btn-primary btn-xs')) ?>
                    <?= anchor('categories/delete/' . $cat->id, '<span class="glyphicon glyphicon-trash"></span>', array('title' => 'Verwijderen', 'class' => 'btn btn-danger btn-xs delete_user')) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>

