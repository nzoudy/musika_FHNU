<?php
/**
 * Created by PhpStorm.
 * User: hermann
 * Date: 06/02/15
 * Time: 01:06
 */

namespace Musika\model;

use Musika\core\Model;
use Utility\form_validation;
use Utility\Hash;
use Utility\Session;

class User extends Model {
    private $userName;
    private $fullName;
    private $userId;
    private $email;
    private $password;
    private $created;
    private $updated;

    // Todo: Refactor the user Table and add groupid, Refactor song table add userid
    // Todo: Remove useless user fields like : address, telephone, zipcode, country
    /** @var Collection - Class configuration options */
    public $config = array(
        'cookieTime'      => '30',
        'cookieName'      => 'auto',
        'cookiePath'      => '/',
        'cookieHost'      => false,
        'userSession'     => 'userData_musika',
    );

    /** @var  Hash - Use to generate hashes */
    protected $hash;
    /** @var array - The user information object */
    protected $_data;
    /** @var Collection - Updates for the user information object */
    protected $_updates;
    /** @var  Session - The namespace session object */
    public $session;

    /** @var Collection - default field validations */
    protected $_validations = array(
        'Username' => array(
            'limit' => '3-15',
            'regEx' => '/^([a-zA-Z0-9_])+$/'
        ),
        'Fullname' => array(
            'limit' => '3-200',
            'regEx' => '/^([a-zA-Z0-9_ .])+$/'
        ),
        'Password' => array(
            'limit' => '3-150',
            'regEx' => ''
        ),
        'Email'    => array(
            'limit' => '3-100',
            'regEx' => '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,63})$/i'
        )
    );

    function __construct($db)
    {
        parent::__construct($db);

        // Instantiate the hash generator
        $this->hash = new Hash();
        $this->form_validation =  new form_validation();

        // Instantiate the session
        $this->session = new Session($this->config['userSession']);
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }


    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * @return mixed set userid is done privately
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Check if a user currently signed-in
     *
     * @return bool
     */
    public function isSigned()
    {
        return (bool) $this->session->signed;
    }

    /**
     * Set sign user session
     * @Return void
     */
    public function setSigned()
    {
        $this->session->key = md5($this->userId.$this->email);
        // set the session signed
        $this->session->signed = true;
        $this->session->userId = $this->userId;

    }


    public function userLogin(){
        // Find if the user exist
        $getUser = $this->getdata('user', $this->userName, 'username');

        // Username doesn't exist
        if(count($getUser) != 1){
            return false;
        }

        // set user created date to generate the correct password
        $this->setCreated($getUser[0]->created);
        $currentPassword = $this->hash->generateUserPassword($this, $this->password, false);

        // Passwords don't match
        if(strcmp($getUser[0]->password, $currentPassword) !== 0){
            return false;
        }

        // set all user info.
        $this->userId = $getUser[0]->id;
        $this->userName = $getUser[0]->username;
        $this->email = $getUser[0]->email;
        //$this->password = $currentPassword;
        $this->fullName = $getUser[0]->fullname;
        $this->updated = $getUser[0]->updated;

        // set user isSigned
        $this->setSigned();
        return true;
    }

    public function userlogout(){
        $this->session->destroy();
    }

    /**
     * Register A New User
     * Takes two parameters, the first being required
     *
     * @access public
     * @api
     *
     * @param array|Collection $info       An associative array, the index being the field name(column in database)and the value
     *                                     its content(value)
     * @param bool             $activation Default is false, if true the user will need required further steps to activate account
     *                                     Otherwise the account will be activated if registration succeeds
     *
     * @return string|bool Returns activation hash if second parameter $activation is true
     *                        Returns true if second parameter $activation is false
     *                        Returns false on Error
     */
    public function register($info, $activation = false)
    {
        // $this->log->channel('registration'); //Index for Errors and Reports

        /*
         * Prevent a signed user from registering a new user
         * NOTE: If a signed user needs to register a new user
         * clone the signed user object a register the new user
         * with the clone.
         */

        if ($this->isSigned()) {
            // $this->log->error(15);
            return false;
        }

        // Saves Registration Data in Class
         $this->updateInfo($info);

        //Validate All Fields
        if (!$this->validateAll()) {
            return false;
        } //There are validations error

        //Set Registration Date
        $this->created = time();

        //Hash Password , always use generate -> false
        if ($this->password) {
            $this->password = $this->hash->generateUserPassword($this, $this->password, false);
        }

        //Check if the email already exists in db
        if($this->email){
            if(!$this->isUnique('user', $this->email, 'email', 'email')){
                //create session log errors
               return false;
            }
        }

        //Check if the Username already exists in db
        if ($this->userName) {
            if (!$this->isUnique('user', $this->userName, 'username', 'username')) {
                //create session log errors
                return false;
            }
        }

        //User Activation
        if (!$activation) {
            //Activates user upon registration
            $this->Activated = 1;
        }

        $data = array();
        $data['username'] = $this->userName;
        $data['fullname'] = $this->fullName;
        $data['email'] = $this->email;
        $data['password'] = $this->password;
        $data['created'] = $this->created;
        $data['updated'] = $this->updated;

        if ($this->addUser('user', $data)){
            // Set the new user ID by getting the last userid
            $this->userId = $this->getLastId('user')->id;
            // created a new session
            $this->setSigned();

            return true;
        }else {
            return false;
        }
    }


    public function updateUserdata($info){

        if (!$this->isSigned()) {
            return false;
        }

        // load old user data from the database
          $this->loadData();

        // Check username
        if((strcmp($this->userName, trim($info['username'])) !== 0) &&
            (!$this->isUnique('user', $info['username'], 'username', 'username'))){
            return false;
        }

        // Check email
        if((strcmp($this->email, trim($info['email'])) !== 0) &&
            (!$this->isUnique('user', $this->email, 'email', 'email'))){
            return false;
        }

        // Update userinfo with new data
        $this->updateInfo($info);

        //Validate All Fields
        if (!$this->validateAll()) {
            return false;
        }

        // Saves Registration data in Class
        if ($this->updatedUser('user', $this->userName, $this->fullName, $this->email, $this->updated, $this->userId)){
            return true;
        }else {
            return false;
        }

    }

    public function removeuser($id){
        if(!$this->deleteuser('user', $id)){
            return false;
        }
        return true;
    }

    public function checkTwoPassword($hash, $nonHash){
        $currentPassword = $this->hash->generateUserPassword($this, $nonHash, false);
        if(strcmp($hash, $currentPassword) !== 0){
            return false;
        }
        return true;
    }

    public function updatePassword($newpassword){
        $newpassword = $this->hash->generateUserPassword($this, $newpassword, false);
        $newupdatedtime = time();

        if($this->updatedUserPassword('user', $newpassword, $newupdatedtime, $this->userId)){
            $this->password = $newpassword;
            $this->updated = $newupdatedtime;
            return true;
        }else{
            return false;
        }
    }

    public function loadData(){
        $getUser = $this->getdata('user', $this->session->userId, 'id', 'id, username, fullname, email, updated');
        // check if the user exist in db
        if(count($getUser) != 1){
            return false;
        }

        // set all user info.
        $this->userId = $getUser[0]->id;
        $this->userName = $getUser[0]->username;
        $this->fullName = $getUser[0]->fullname;
        $this->email = $getUser[0]->email;
        $this->updated = $getUser[0]->updated;

        return;
    }

    protected function updateInfo($info){
        $this->setUserName(trim($this->form_validation->mysql_prep($info['username'])));
        $this->setFullName(trim($this->form_validation->mysql_prep($info['fullname'])));
        $this->setEmail(trim($info['email']));

        if(isset($info['password'])){
            $this->setPassword($info['password']);
        }

        $this->updated = time();
    }

    protected function validateAll(){
       $field_errors = array();

        // validate UserName
        if (!$this->validateField('userName', $this->_validations['Username']['limit'], $this->_validations['Username']['regEx'] )){
            $field_errors['Username'] = 'Error username';
        };

        // Todo: Create validation for other fields
        // validate fullname
//        if (!$this->validateField('fullName', $this->_validations['Fullname']['limit'], $this->_validations['Fullname']['regEx'] )){
//            $field_errors['Fullname'] = 'Error fullname';
//        };

        // validate email
        //

        return !count($field_errors) > 0;
    }

    protected function validateField($name, $limit, $regEx = false)
    {
        $Name = ucfirst($name);
        $value = $this->$name;
        $length = explode('-', $limit);
        $min = intval($length[0]);
        $max = intval($length[1]);

        if (!$max and !$min) {
           // $this->log->error("Invalid second parameter for the $name validation");
            return false;
        }

        if (!$value) {
            if (is_null($value)) {
               // $this->log->report("Missing index $name from the input");
            }
            if (strlen($value) == $min) {
              //  $this->log->report("$Name is blank and optional - skipped");
                return true;
            }
          //  $this->log->formError($name, "$Name is required.");
            return false;
        }

        // Validate the value maximum length
        if (strlen($value) > $max) {
           // $this->log->formError($name, "The $Name is larger than $max characters.");
            return false;
        }

        // Validate the value minimum length
        if (strlen($value) < $min) {
          //  $this->log->formError($name, "The $Name is too short. It should at least be $min characters long");
            return false;
        }

        // Validate the value pattern
        if ($regEx) {
            preg_match($regEx, $value, $match);
            if (preg_match($regEx, $value, $match) === 0) {
               // $this->log->formError($name, "The $Name \"{$value}\" is not valid");
                return false;
            }
        }

        /*
         * If the execution reaches this point then the field value
         * is considered to be valid
         */
        //$this->log->report("The $name is Valid");

        return true;
    }

}
