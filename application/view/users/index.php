<div class="container">
    <div class="row">
       <?php $u = $user->getFullName(); if(!empty($u)) { ?>
            <h4> Hi, <?php echo htmlspecialchars($user->getFullName(), ENT_QUOTES, 'UTF-8'); ?></h4>
        <?php }?>
        <div class="col-sm-12 text-right">
            <a href="<?php echo URL . 'users/logout' ?>">Logout</a>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-3">
            <ul>
                <li class="active"><a href="<?php echo URL; ?>/users">My songs</a></li>
                <li class=""><a href="<?php echo URL; ?>users/profile/<?php echo htmlspecialchars($user->getUserName(), ENT_QUOTES, 'UTF-8'); ?>">My profile</a></li>
                <li class=""><a href="<?php echo URL; ?>users/resetpassword/<?php echo htmlspecialchars($user->getUserName(), ENT_QUOTES, 'UTF-8');  ?>">Reset Password</a></li>
                <li class=""><a onclick="javascript: return confirm('Please confirm deletion');" href="<?php echo URL; ?>users/deleteaccount/<?php echo htmlspecialchars($user->getUserId(), ENT_QUOTES, 'UTF-8');?>">Delete your account</a></li>

            </ul>
        </div>
        <div class="col-sm-9" style="border-left: 1px solid #000;">
            <!-- add song form -->
            <div class="row">
                <div class="col-sm-12">
                    <h3>Add a song</h3>
                    <form action="<?php echo URL; ?>users/addsong" method="POST">
                        <label>Track Title</label>
                        <input type="text" name="track" value="" required />
                        <label>add your file MP3</label>
                        <input type="text" name="link" value="" />
                        <input type="submit" name="submit_add_song" value="Submit" />
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div>
                        Audio Listner with HTML5
                    </div>
                </div>
                <div class="col-sm-12">

                    <h3>List of songs (data from first model)</h3>
                    <table>
                        <thead style="background-color: #ddd; font-weight: bold;">
                        <tr>
                             <td>Id</td>
                            <td>Artist</td>
                            <td>Track</td>
                            <td>Link</td>
                            <td>DELETE</td>
                            <td>EDIT</td>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($songs as $song) { ?>
                            <tr>
                                <td><?php if (isset($song->id)) echo htmlspecialchars($song->id, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php if (isset($song->artist)) echo htmlspecialchars($song->artist, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php if (isset($song->track)) echo htmlspecialchars($song->track, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?php if (isset($song->link)) { ?>
                                        <a href="<?php echo htmlspecialchars($song->link, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($song->link, ENT_QUOTES, 'UTF-8'); ?></a>
                                    <?php } ?>
                                </td>
                                <td><a href="<?php echo URL . 'songs/deletesong/' . htmlspecialchars($song->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                                <td><a href="<?php echo URL . 'songs/editsong/' . htmlspecialchars($song->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <br>

                   <<  < page (1/20) >  >>

                </div>
            </div>
        </div>
    </div>
</div>
