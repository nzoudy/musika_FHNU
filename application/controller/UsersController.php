<?php
/**
 * Created by PhpStorm.
 * User: hermann
 * Date: 06/02/15
 * Time: 01:08
 */

use Musika\core\Controller;
use Musika\model\User;
use Musika\model\Song;

// TODO: Create the table roles, authentication, and users table

class Users  extends Controller{

    public function index()
    {
        // New user instance
        $user = new User($this->db);
        $emp = $user->isSigned();

        if(empty($emp)){
            $this->view->redirect_to( URL. 'users/login');
            return;
        }

        // load user data from the database
        $user->loadData();

        $songModel = new Song($this->db);
        // user details
        $this->view->user = $user;


        // getting all songs and amount of songs
        $this->view->songs = $songModel->getAllSongs();
        $this->view->amount_of_songs = $songModel->getAmountOfSong();

        // set page title
        $this->view->title = "Profile";
        // load views
        $this->view->render('index.php');
    }

    public function register(){
        // New user instance
        $user = new User($this->db);
        $emp = $user->isSigned();
        if(!empty($emp)){
            $this->view->redirect_to( URL. 'users/');
            return;
        }

        // set page title
        $this->view->title = "Register a new user";
        // load views
        $this->view->render('register.php');
        // Todo: Handle errors in user data register by cookies
    }

    public function profile(){
        // New user instance
        $user = new User($this->db);
        $emp = $user->isSigned();

        if(empty($emp)){
            $this->view->redirect_to( URL. 'users/login');
            return;
        }

        // load user data from the database
        $user->loadData();

        $this->view->user = $user;

        // set page title
        $this->view->title = "Edit profile";
        // load views
        $this->view->render('profile.php');
        // Todo: Handle errors in user data register by cookies
    }

    public function postProfile(){

        // New user instance
        $user = new User($this->db);
        $emp = $user->isSigned();

        $user->loadData();

        $temp_username= $user->getUserName();

        if(empty($emp)){
            $this->view->redirect_to( URL. 'users/');
            return;
        }

        if(!isset($_POST["musika_user_updateprofile"])){
            // where to go after song has been added
            $this->view->redirect_to( URL. 'error/index');
        }

        // errors array
        // Todo: if errors exists redirect to the register view with errors message
        $errors = array();
        // validate data
        // perform validations on the form data
        $required_fields = array('username','fullname', 'email', 'musika_user_updateprofile');

        $errors = array_merge($errors, $user->form_validation->check_required_fields($required_fields, $_POST));

        if (count($errors) > 0 ){
            // Todo: Return to the register with errors message.
            // errors
            $this->view->redirect_to( URL. 'error/index');
        }

        // Add the new user in the database
        if(!$user->updateUserdata($_POST)){
            // with errors
            $this->view->redirect_to( URL. 'users/profile'.$temp_username);
        }
        // Todo: Render user index account page with success message
        $this->view->redirect_to(URL. 'users/profile'.$temp_username);
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
        $required_fields = array('username','fullname',  'email', 'password', 'password2', 'musika_user_registration');

        $errors = array_merge($errors, $user->form_validation->check_required_fields($required_fields, $_POST));

        // Check passwords match
        $validePassword = $user->form_validation->checkMatchPassword($_POST['password'], $_POST['password2']) ;
        if (count($errors) > 0 || (!$validePassword)){
            // Todo: Return to the register with errors message.
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
            return;
        }

        // Render user index account page
        $this->index();
    }


    /*
     * Use to load login page
     * @Return  login view and errors if exist
     */
    public function login($errors = null ){
        // New user instance
        $user = new User($this->db);
        $emp = $user->isSigned();
        if(!empty($emp)){
            $this->view->redirect_to( URL. 'users/index');
            return;
        }
        // set page title
        $this->view->title = "Login";
        // load views
        $this->view->render('login.php');

        // Todo: Handle errors in user data login by cookies
    }

    /*
     * Login post request
     * @Return to the user account page if success login or send error to login page
     */
    public function postLogin(){
        //Get Post
        if(!isset($_POST["musika_user_login"])){
            // where to go after song has been added
            $this->view->redirect_to( URL. 'users/login');
        }

        // check if username exist
        $user = new User($this->db);
        $user->setUserName(trim($_POST["username"]));
        $user->setPassword($_POST["password"]);

        if(!$user->userLogin()){
            // error login send in cookie
            $this->view->redirect_to( URL. 'users/login');
            return;
        }else{
            $this->view->redirect_to( URL. 'users/');
            return;
        }
    }

    public function deleteaccount($id){
        // New user instance
        $user = new User($this->db);
        $emp = $user->isSigned();
        if (empty($emp)) {
            $this->view->redirect_to( URL. 'users/login');
            return;
        }
        // load old user data from the database
        $user->loadData();

        if( $id != $user->getUserId()) {
            $this->view->redirect_to( URL. 'users/');
            return;
        }

        if($user->removeuser($id)){
            $user->session->destroy();
            $this->view->redirect_to( URL. 'users/login');
            return;
        }else{
            $this->view->redirect_to( URL. 'users/profile/'.$user->getUserName());
            return;
        }
      //  echo $user->getUserId()."<br>";
    //    die;
    }


    public function logout(){
        // New user instance
        $user = new User($this->db);
        $user->userlogout();
        $this->view->redirect_to( URL. 'users/login');
    }

    // Todo: Reset password
    public function changePassword(){
        //Get Post
        // return to user/profile.php
        // Todo: Handle errors in user data resetPassword by cookies
    }

    // Todo: Update user information
    public function updateUserInfo(){
        //Get Post
        // return to user/profile.php
        // Todo: Handle errors in user data updatedUserInfo by cookies

    }

}