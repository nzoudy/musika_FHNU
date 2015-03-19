<div class="container">

    <div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <h2>Register</h2>

        <hr/>

        <form method="post" action="<?php echo URL . 'users/register/' ?>" data-success="<?php echo URL ?>/users/login">
            <div class="form-group">
                <label>Username:</label>
                <input name="Username" type="text" required class="form-control" autofocus>
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
                <input name="Email" type="text" required class="form-control">
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input name="Password" type="password" required class="form-control">
            </div>

            <div class="form-group">
                <label>Confirm Password:</label>
                <input name="Password2" type="password" required class="form-control">
            </div>

            <div class="form-group">
                <label>Website: </label>
                <input name="website" type="text" class="form-control">
            </div>

            <div class="form-group">
                <label>Group: </label>
                <select name="GroupID" class="form-control">
                    <option value="1">User</option>
                    <option value="2">Developer</option>
                    <option value="3">Designer</option>
                </select>
            </div>


            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Register</button>
                <br>
                <a href="<?php echo URL ?>/users/login" class="">Login</a>
            </div>
        </form>

    </div>
</div>

</div>
