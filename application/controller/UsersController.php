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

        // Todo: Handle errors in user data register by cookies
    }


    public function addUser($errors = null){

        if(!isset($_POST["musika_user_registration"])){
            // where to go after song has been added
            $this->view->redirect_to( URL. 'error/index');
        }

        // New user instance
        $user = new User($this->db);

        // errors array
        // Todo: if errors exists redirect to the register view with errors message
        $errors = array();
        // validate data
        // perform validations on the form data
        $required_fields = array('username','first_name', 'last_name', 'password', 'password2', 'email', 'telephone',
            'address', 'zipcode', 'city', 'country', 'musika_user_registration');

        $errors = array_merge($errors, $user->form_validation->check_required_fields($required_fields, $_POST));

        // Check passwords match
        $validePassword = $user->form_validation->checkMatchPassword($_POST['password'], $_POST['password2']) ;
        if (count($errors) > 0 || (!$validePassword)){
            // errors
            $this->view->redirect_to( URL. 'error/index');
        }

        // Add the new user in the database
        if(!$user->register($_POST)){
            // errors
            $this->view->redirect_to( URL. 'error/index');
        }

        // Get User id
        if(!$user->isSigned()){
           $this->login();
        }

        // Render user index account page
        $this->index();
    }


    public function login($errors = null ){
        // set page title
        $this->view->title = "Login";
        // load views
        $this->view->render('login.php');

        // Todo: Handle errors in user data login by cookies
    }


    public function checkLogin(){
        //Get Post
        // return to users/index.php
    }

    public function logout(){
        //logout user

        // return to home/index.php
    }

    public function changePassword(){
        //Get Post
        // return to user/account.php
        // Todo: Handle errors in user data resetPassword by cookies
    }

    public function updateUserInfo(){
        //Get Post
        // return to user/account.php
        // Todo: Handle errors in user data updatedUserInfo by cookies

    }

}