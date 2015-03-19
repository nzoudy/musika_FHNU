<?php
/**
 * Created by PhpStorm.
 * User: hermann
 * Date: 06/02/15
 * Time: 01:08
 */

use Musika\core\Controller;

// TODO: Create the table roles, authentication, and users table
// TODO: Create User login and profile view


class Users  extends Controller{

    public function index()
    {
        // set page title
        $this->view->title = "Profile";
        // load views
        $this->view->render('register.php');

    }

    public function register(){

        echo $_POST;

    }

}