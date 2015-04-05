<div class="container"   style=" width: 850px; margin: 30px auto">
    <!-- main content output -->
    <div class="row">
        <div class="col-sm-12">

            <?php if(!empty($songs)){?>
            <h3>Listen</h3>
            <div>
                <br>
                <audio preload></audio>
            </div>
            <?php }?>
        </div>
        <div class="col-sm-12">
            <h3>Listen our best songs</h3>
            <table>
                <thead style="background-color: #ddd; font-weight: bold;">
                <tr>
                    <td>Artist</td>
                    <td>Track</td>
                    <td>Link</td>
                </tr>
                </thead>
                <tbody>

                <?php if(!empty($songs)){?>

                    <?php foreach ($songs as $song) { ?>
                        <tr>
                            <td><?php if (isset($song->artist)) echo htmlspecialchars($song->artist, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php if (isset($song->track)) echo htmlspecialchars($song->track, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="mangeplay">
                                <?php if (isset($song->link)) { ?>
                                    <a href="#" data-src="<?php echo htmlspecialchars($song->link, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($song->link, ENT_QUOTES, 'UTF-8'); ?></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>

                <?php } else {?>

                <?php }?>

                </tbody>
            </table>


        </div>

    </div>
</div>
