<?php
/**
 * Created by PhpStorm.
 * User: hermann
 * Date: 06/02/15
 * Time: 01:08
 */

use Musika\core\Controller;
use Musika\model\User;

// TODO: Create the table roles, authentication, and users table
// TODO: Create User login and profile view


class Users  extends Controller{



    public function index()
    {

        // set page title
        $this->view->title = "Profile";
        // load views
        $this->view->render('index.php');

    }

    public function register(){
        // set page title
        $this->view->title = "Register a new user";
        // load views
        $this->view->render('register.php');

    }


    public function createUser(){
        if(!isset($_POST["musika_user_registration"])){
            // where to go after song has been added
            header('location: ' . URL . 'error/index');
        }

        // New user instance
        $user = new User($this->db);

        // errors array

        $errors = array();
        // validate data
        // perform validations on the form data
        $required_fields = array('username','first_name', 'last_name', 'password', 'password2', 'email', 'telephone',
            'address', 'zipcode', 'city', 'country', 'musika_user_registration');

        $errors = array_merge($errors,$user->form_validation->check_required_fields($required_fields, $_POST));
        $validePassword = $user->form_validation->checkMatchPassword($_POST['password'], $_POST['password2']) ;
        if (count($errors) > 0 || (!$validePassword)){
            // errors
            header('location: ' . URL . 'error/index');
        }
        if(!$user->register($_POST)){
            // errors
            header('location: ' . URL . 'error/index');
        }

        // Get User id
        if(!$user->isSigned()){
            header('location: ' . URL . 'users/login');
        }

        // where to go after song has been added
        header('location: ' . URL . 'users/index');
    }


    public function login(){

       // echo $_POST;

    }

}