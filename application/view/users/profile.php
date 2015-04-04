<div class="container">
    <div class="row">
        <div class="col-sm-4 col-md-offset-3 text-right">
            <a href="<?php echo URL . 'users/logout' ?>"> Logout </a>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-8 ">
            <h2>My Profil</h2>

            <hr/>

            <form method="post" action="<?php echo URL . 'users/addUser/' ?>" data-success="<?php echo URL ?>/users/login">
                <div class="form-group">
                    <label>Username:</label>
                    <input name="username" type="text" required class="form-control" autofocus>
                </div>

                <div class="form-group">
                    <label>First Name:</label>
                    <input name="first_name" type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label>Last Name:</label>
                    <input name="last_name" type="text" class="form-control">
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

                <div class="form-group">
                    <label>Telephone: </label>
                    <input name="telephone" type="telephone" class="form-control">
                </div>

                <div class="form-group">
                    <label>Address: </label>
                    <input name="address" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>City: </label>
                    <input name="city" type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label>Zip Code: </label>
                    <input name="zipcode" type="number" min="0" max="999999" class="form-control">
                </div>

                <div class="form-group">
                    <label>Country: </label>
                    <input name="country" type="text" class="form-control">
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
