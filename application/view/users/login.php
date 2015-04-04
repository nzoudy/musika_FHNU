<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <h2>Login</h2>
            <hr/>
            <form method="post" action="<?php echo URL . 'users/postLogin' ?>" data-success="<?php echo URL ?>/users/register">
                <input name="musika_user_login" type="hidden" value="<?php echo APPNAME; ?>">

                <div class="form-group">
                    <input name="username" type="text" required class="form-control" placeholder="User account" autofocus>
                </div>
                <div class="form-group">
                    <input name="password" type="password" required class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <span class="form-group text-right">
                        <input type="submit" class="btn btn-primary" value="Login" />
                    </span>
                    <a class="small" href="<?php echo URL ?>/users/forgotpassword">Forgot your password?</a>
                </div>
            </form>
            <div>
                <span class="form-group text-left">
                    <a href="<?php echo URL ?>/users/register" class="">Register</a>
                </span>
            </div>
        </div>
</div>
