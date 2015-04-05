<div class="container">
    <div class="row">
        <div class="col-sm-3" >
            <ul>
                <li class=""><a href="<?php echo URL; ?>users">My songs</a></li>
                <li class="active"><a href="<?php echo URL; ?>users/profile/<?php echo htmlspecialchars($user->getUserName(), ENT_QUOTES, 'UTF-8'); ?>">My profile</a></li>
                <li class=""><a href="<?php echo URL; ?>users/resetpassword/<?php echo htmlspecialchars($user->getUserName(), ENT_QUOTES, 'UTF-8');  ?>">Reset Password</a></li>
                <li class=""><a onclick="javascript: return confirm('Please confirm deletion');" href="<?php echo URL; ?>users/deleteaccount/<?php echo htmlspecialchars($user->getUserId(), ENT_QUOTES, 'UTF-8');?>">Delete your account</a></li>
            </ul>

        </div>

        <!-- add song form -->
        <div class="col-sm-9">
            <h3>Edit a song</h3>
            <form action="<?php echo URL; ?>songs/updatesong" method="POST">
                <label>Artist</label>
                <input autofocus type="text" name="artist" value="<?php echo htmlspecialchars($song->artist, ENT_QUOTES, 'UTF-8'); ?>" required />
                <label>Track</label>
                <input type="text" name="track" value="<?php echo htmlspecialchars($song->track, ENT_QUOTES, 'UTF-8'); ?>" required />
                <label>Link</label>
                <input type="text" name="link" value="<?php echo htmlspecialchars($song->link, ENT_QUOTES, 'UTF-8'); ?>" />
                <input type="hidden" name="song_id" value="<?php echo htmlspecialchars($song->id, ENT_QUOTES, 'UTF-8'); ?>" />
                <input type="submit" name="submit_update_song" value="Update" />
            </form>
        </div>
    </div>

</div>

