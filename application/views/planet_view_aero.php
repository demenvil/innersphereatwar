<script type="text/javascript">                                         
    // Set variables
    <?php echo 'var $updateurl = "'.base_url('index.php/planet/update/'.$planet->planet_id.'/aero').'";'; ?>
     
</script>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h1><?php echo $planet->name; ?><small> Star System Radar Map</small></h1>
            <table class="table">
                <tr>
                    <th>ISW Turn: </th>
                    <td><?php echo $game->turn; ?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <th>ACS Turn: </th>
                    <td><?php echo $planet->turn; ?></td>
                    <td><?php echo anchor('planet/update_turn/'.$planet->planet_id.'/-1', '-'); ?> / <?php echo anchor('planet/update_turn/'.$planet->planet_id.'/1', '+'); ?></td>
                </tr>
                <tr>    
                    <th>ACS Phase: </th>
                    <td><?php echo $planet->phase; ?></td>
                    <td><?php echo anchor('planet/update_phase/'.$planet->planet_id.'/-1', '-'); ?> / <?php echo anchor('planet/update_phase/'.$planet->planet_id.'/1', '+'); ?></td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
        <div class="col-md-8">
            <h2>Token <small>Info</small></h2>
            <div id="token_info">
                ...
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            
            <img src="<?php echo base_url('images/spacemap.png') ?>" />
            
            <?php 
                // Display each token on this view
                foreach ($tokens as $t)
                {
                    unset($data);
                    $data['token'] = $t;
                    $this->load->view('token_view', $data);
                }
            ?>

            
        </div>
    </div>
</div>