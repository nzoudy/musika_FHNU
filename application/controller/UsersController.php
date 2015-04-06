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
use Utility\Cookie;

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
        $this->view->songs = $songModel->getAllSongs($user->getUserId());
        // set page title
        $this->view->title = "Profile";
        // load views
        $this->view->render('index.php');
    }

    public function register(){
        // errors and sucess message
        $cookie = new Cookie('messageregister');
        $c = $cookie->getValue();
        $msgArray = explode(":", $c);
        $errArray = array();

        if(!empty($c)){
            if(!empty($msgArray)) {
                if($msgArray[0]=='error'){
                    $errArray[] = $msgArray[1];
                    $this->view->errors = $errArray;
                }
            }
        }
        $cookie->destroy();

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

    public function profile($username = null ){
        // errors and sucess message
        $cookie = new Cookie('messageprofile');
        $c = $cookie->getValue();
        $msgArray = explode(":", $c);
        $errArray = array();

        if(!empty($c)){
            if(!empty($msgArray)) {
                if($msgArray[0]=='error'){
                    $errArray[] = $msgArray[1];
                    $this->view->errors = $errArray;
                }elseif($msgArray[0]=='success'){
                    $this->view->success = $msgArray[1];
                }
            }
        }
        $cookie->destroy();

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

        $cookie = new Cookie('messageprofile');
        $c = $cookie->getValue();
        if(!empty($c)){
            $cookie->destroy();
        }

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
        $errors = array();
        // perform validations on the form data
        $required_fields = array('username','fullname', 'email', 'musika_user_updateprofile');

        $errors = array_merge($errors, $user->form_validation->check_required_fields($required_fields, $_POST));

        if (count($errors) > 0 ){
            // errors
            $msg = "error:";
            $msg .= implode("<br>", $errors);
            $cookie->setValue($msg);
            $cookie->add();
            $this->view->redirect_to( URL. 'users/profile/'.$temp_username);
        }

        // Add the new user in the database
        if(!$user->updateUserdata($_POST)){
            // errors
            $msg = "error: Error updating your data, please try again. <br>";
            $msg .= implode("<br>", $user->getFieldErrors());
            $cookie->setValue($msg);
            $cookie->add();
            $user->setFieldErrors(null);
            $this->view->redirect_to( URL. 'users/profile/'.$temp_username);
        }

        // Send a success message
        $msg = "success: Your data have been updated successfully";
        $cookie->setValue($msg);
        $cookie->add();
        $this->view->redirect_to(URL. 'users/profile/'.$temp_username);
    }

    public function resetpassword(){
        // errors and sucess message
        $cookie = new Cookie('messageresetpassword');
        $c = $cookie->getValue();
        $msgArray = explode(":", $c);
        $errArray = array();

        if(!empty($c)){
            if(!empty($msgArray)) {
                if($msgArray[0]=='error'){
                    $errArray[] = $msgArray[1];
                    $this->view->errors = $errArray;
                }elseif($msgArray[0]=='success'){
                    $this->view->success = $msgArray[1];
                }
            }
        }
        $cookie->destroy();

        // New user instance
        $user = new User($this->db);
        $emp = $user->isSigned();
        if(empty($emp)){
            $this->view->redirect_to( URL. 'users/');
            return;
        }

        $user->loadData();

        $this->view->user = $user;

        // set page title
        $this->view->title = "Reset password";
        // load views
        $this->view->render('resetpassword.php');

    }

    public function postresetpassword($userid){
        $cookie = new Cookie('messageresetpassword');
        $c = $cookie->getValue();
        if(!empty($c)){
            $cookie->destroy();
        }
        $msg = '';
        // New user instance
        $user = new User($this->db);
        $emp = $user->isSigned();

        $user->loadData();

        if(empty($emp)){
            $this->view->redirect_to( URL. 'users/');
            return;
        }

        if(!isset($_POST["musika_user_resetpassword"])){
            // where to go after song has been added
            $this->view->redirect_to( URL. 'error/index');
            return;
        }
        // Find if the user exist
        $getUser = $user->getdata('user', $user->getUserName(), 'username');

        // set user created date to generate the correct password
        $user->setCreated($getUser[0]->created);

        if (!$user->checkTwoPassword($getUser[0]->password, $_POST['oldpassword'])) {
            // error cookie don't match
            $msg = "error: Error old passwords is wrong";
            $cookie->setValue($msg);
            $cookie->add();
            $this->view->redirect_to( URL. 'users/resetpassword');
            return;
        }

        //Check both password
        if(strcmp($_POST['newpassword'], $_POST['confirmpassword']) !== 0 ){
            // error cookie password don't match
            $msg= "error:Error passwords don't match";
            $cookie->setValue($msg);
            $cookie->add();
            $this->view->redirect_to( URL. 'users/resetpassword');
            return;
        }

        // Update new password
        if($user->updatePassword($_POST['newpassword'])){
            // success message
            $msg = "success:Your password have been updated";
            $cookie->setValue($msg);
            $cookie->add();
            $this->view->redirect_to( URL. 'users/resetpassword');
            return;

        }else{
            // error creating your new password
            $msg = "error:Error creating your new password";
            $cookie->setValue($msg);
            $cookie->add();
            $this->view->redirect_to( URL. 'users/resetpassword');
            return;
        }

        return;
    }

    public function addUser($errors = null){

        $cookie = new Cookie('messageregister');
        $c = $cookie->getValue();
        if(!empty($c)){
            $cookie->destroy();
        }

        if(!isset($_POST["musika_user_registration"])){
            // where to go after song has been added
            $this->view->redirect_to( URL. 'error/index');
        }

        // New user instance
        $user = new User($this->db);

        $errors = array();
        // validate data
        // perform validations on the form data
        $required_fields = array('username','fullname',  'email', 'password', 'password2', 'musika_user_registration');

        $errors = array_merge($errors, $user->form_validation->check_required_fields($required_fields, $_POST));

        // Check passwords match
        $validePassword = $user->form_validation->checkMatchPassword($_POST['password'], $_POST['password2']) ;

        if (count($errors) > 0 ){
            // errors
            $msg = "error:";
            $msg .= implode("<br>", $errors);
            $cookie->setValue($msg);
            $cookie->add();
            $this->view->redirect_to( URL. 'users/register');
            return;
        }

        if(!$validePassword){
            // errors
            $msg = "error:";
            $msg .= "Invalid or Passwords don't match <br>";
            $cookie->setValue($msg);
            $cookie->add();
            $this->view->redirect_to( URL. 'users/register');
            return;
        }

        // Add the new user in the database
        if(!$user->register($_POST)){
            // errors
            $msg = "error: Error registering your data, please try again. <br>";
            $msg .= implode("<br>", $user->getFieldErrors());
            $cookie->setValue($msg);
            $cookie->add();
            $user->setFieldErrors(null);
            $this->view->redirect_to( URL. 'users/register');
        }

        // Get User id
        if(!$user->isSigned()){
            $this->view->redirect_to( URL. 'users/login');
            return;
        }

        // Render user index account page
        $this->view->redirect_to( URL. 'users/');
        return;
    }


    /*
     * Use to load login page
     * @Return  login view and errors if exist
     */
    public function login(){
        // errors and sucess message
        $cookie = new Cookie('userlogin');
        $c = $cookie->getValue();
        $msgArray = explode(":", $c);
        $errArray = array();

        if(!empty($c)){
            if(!empty($msgArray)) {
                if($msgArray[0]=='error'){
                    $errArray[] = $msgArray[1];
                    $this->view->errors = $errArray;
                }
            }
        }
        $cookie->destroy();

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
        $cookie = new Cookie('userlogin');
        $c = $cookie->getValue();
        if(!empty($c)){
            $cookie->destroy();
        }

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
            $msg = "error:";
            $msg .= implode("<br>", $user->getFieldErrors());
            $cookie->setValue($msg);
            $cookie->add();
            $user->setFieldErrors(null);
            $this->view->redirect_to( URL. 'users/login');
            return;
        }else{
            $this->view->redirect_to( URL. 'users/profile');
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