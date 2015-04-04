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
                <li class=""><a href="<?php echo URL; ?>/users">My songs</a></li>
                <li class="active"><a href="<?php echo URL; ?>users/profile/<?php echo htmlspecialchars($user->getUserName(), ENT_QUOTES, 'UTF-8'); ?>">My profile</a></li>
                <li class=""><a href="<?php echo URL; ?>users/resetpassword/<?php echo htmlspecialchars($user->getUserName(), ENT_QUOTES, 'UTF-8');  ?>">Reset Password</a></li>
                <li class=""><a onclick="javascript: return confirm('Please confirm deletion');" href="<?php echo URL; ?>users/deleteaccount/<?php echo htmlspecialchars($user->getUserId(), ENT_QUOTES, 'UTF-8');?>">Delete your account</a></li>
            </ul>
        </div>
        <div class="col-sm-9 ">
            <h2>My Profil</h2>

            <hr/>

            <form method="post" action="<?php echo URL . 'users/postProfile' ?>">
                <div class="form-group">
                    <label>Username:</label>
                    <input name="username" type="text" required class="form-control" autofocus value="<?php echo htmlspecialchars($user->getUserName(), ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="form-group">
                    <label>Fullname:</label>
                    <input name="fullname" type="text" class="form-control" value="<?php echo htmlspecialchars($user->getFullName(), ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="form-group">
                    <label>Email: </label>
                    <input name="email" type="text" required class="form-control" value="<?php echo htmlspecialchars($user->getEmail(), ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <?php $getWebsitehost = APPNAME; ?>
                <input name="musika_user_updateprofile" type="hidden" value="<?php echo $getWebsitehost; ?>">
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <br>
                </div>
            </form>

        </div>
    </div>

</div>
