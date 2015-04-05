<div class="container" style="width: 850px; height: 360px; margin: 30px auto">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3" style="">
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
                       <button type="submit" class="btn btn-primary" style="background-color: #acb82d; margin-top: 15px; width: 130px; margin-right: 20px; font-family: Arial">Login</button>
                    </span>
                    <a class="small" href="<?php echo URL ?>/users/forgotpassword">Forgot your password?</a>
                </div>
            </form>
            <div>
                <span class="form-group text-left">
                    <a href="<?php echo URL ?>/users/register" class="btn btn-primary" style="background-color: #acb82d; margin-top: 15px; width: 130px; font-family: Arial">Register</a>
                </span>
            </div>
        </div>
</div>
