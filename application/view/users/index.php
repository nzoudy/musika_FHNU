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
                <li class="active"><a href="<?php echo URL; ?>users">My songs</a></li>
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
                    <form action="<?php echo URL."songs/addsong/".$user->getUserId(); ?>" method="POST" enctype="multipart/form-data">
                        <label>Track Title *</label>
                        <input type="text" name="track" value="" required />
                        &nbsp; &nbsp; &nbsp;
                        <label>File (MP3 < 5MB)</label>
                        <input style="display: inline-block;" type="file" name="file" value="" required />
                        <br />
                        <br />

                        <input type="submit" name="submit_add_song" value="Add" />
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <h3>Listen</h3>
                    <div>
                        <?php if(!empty($songs)){ ?>
                            <br>
                            <audio preload></audio>
                        <?php  }?>

                    </div>
                </div>
                <div class="col-sm-12">
                    <br>
                    <br>

                    <h3>My list</h3>
                    <table>
                        <thead style="background-color: #ddd; font-weight: bold;">
                        <tr>
                            <td>Artist</td>
                            <td>Track</td>
                            <td>Link</td>
                            <td>DELETE</td>
                            <td>EDIT</td>
                        </tr>
                        </thead>

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
                                    <td><a href="<?php echo URL . 'songs/deletesong/' . htmlspecialchars($song->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                                    <td><a href="<?php echo URL . 'songs/editsong/' . htmlspecialchars($song->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
                                </tr>
                            <?php } ?>
                        <?php } else {?>

                        <?php }?>

                        </tbody>
                    </table>
                    <br>

                </div>
            </div>
        </div>
    </div>
</div>
