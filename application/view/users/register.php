<div class="container">

    <div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <h2>Register</h2>

        <hr/>

        <form method="post" action="<?php echo URL . 'users/addUser/' ?>" data-success="<?php echo URL ?>/users/login">
            <div class="form-group">
                <label>Username:</label>
                <input name="username" type="text" required class="form-control" autofocus>
            </div>

            <div class="form-group">
                <label>Fullname:</label>
                <input name="fullname" type="text" class="form-control">
            </div>

            <div class="form-group">
                <label>Email: </label>
                <input name="email" type="text" required class="form-control">
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input name="password" type="password" required class="form-control">
            </div>

            <div class="form-group">
                <label>Confirm Password:</label>
                <input name="password2" type="password" required class="form-control">
            </div>

            <? $getWebsitehost = APPNAME; ?>
            <input name="musika_user_registration" type="hidden" value="<?php echo $getWebsitehost; ?>">
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Register</button>
                <br>
            </div>
        </form>

    </div>
</div>

</div>
