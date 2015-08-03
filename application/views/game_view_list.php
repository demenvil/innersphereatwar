<div class="container">
    <h1>Game List</h1>
    
    <table class="table table-striped">
        <tr>
            <th>Name</th>
            <th>&nbsp;</th>
        </tr>
    <?php foreach($game as $g): ?>
        <tr>
            <td><?php echo $g->name; ?></td>
            <td><?php echo anchor('game/view/'.$g->game_id, 'VIEW'); ?></td>
        </tr>    
    <?php endforeach; ?>
    </table>
</div>