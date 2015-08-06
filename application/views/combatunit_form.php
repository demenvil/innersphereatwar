<div class="container">
    <h1>Add a Combat Unit to <?php echo $formation->name; ?></h1>
    <?php echo validation_errors(); ?>
    <form class="form-horizontal" action="<?php echo base_url('index.php/formation/add_combatunit/'.$formation->formation_id); ?>" method="post">
        <div class="form-group">
            <label class="col-md-2 control-label">Name</label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="name" placeholder="Name">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
</div>