<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <h2>Login</h2>

            <hr/>

            <form method="post" action="<?php echo URL . 'users/checkLogin/' ?>" data-success="<?php echo URL ?>/users/register">
                <div class="form-group">
                    <input name="Username" type="text" required class="form-control" placeholder="User account" autofocus>
                </div>
                <div class="form-group">
                    <input name="Password" type="password" required class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <span class="form-group text-left">
                        <a href="<?php echo URL ?>/users/register" class="btn btn-primary">Login</a>
                    </span>
                    <span class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Connexion</button>
                    </span>
                </div>
            </form>

        </div>
</div>
