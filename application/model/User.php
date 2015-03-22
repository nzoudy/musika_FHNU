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
    private $firstName;
    private $lastName;
    private $userId;
    private $email;
    private $password;
    private $telephone;
    private $address;
    private $city;
    private $zipcode;
    private $country;
    private $created;
    private $updated;

    /** @var Collection - Class configuration options */
    public $config = array(
        'cookieTime'      => '30',
        'cookieName'      => 'auto',
        'cookiePath'      => '/',
        'cookieHost'      => false,
        'userSession'     => 'userData',
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
        'Firstname' => array(
            'limit' => '3-15',
            'regEx' => '/^([a-zA-Z0-9_])+$/'
        ),
        'Lastname' => array(
            'limit' => '3-15',
            'regEx' => '/^([a-zA-Z0-9_])+$/'
        ),
        'Country' => array(
            'limit' => '3-15',
            'regEx' => '/^([a-zA-Z ])+$/'
        ),

        'city' => array(
            'limit' => '3-15',
            'regEx' => '/^([a-zA-Z0-9_ ])+$/'
        ),
        'zipcode' => array(
            'limit' => '2-8',
            'regEx' => '/^([0-9])+$/'
        ),

        'Password' => array(
            'limit' => '3-15',
            'regEx' => ''
        ),
        'Email'    => array(
            'limit' => '4-45',
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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }


    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
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
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param mixed $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
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
       /* if ($this->isSigned()) {
            // $this->log->error(15);
            return false;
        }*/


       // Saves Registration Data in Class
         $this->updateInfo($info);

        //Validate All Fields
        if (!$this->validateAll()) {
            return false;
        } //There are validations error

        //Set Registration Date
        $this->created = time();

        /*
         * Built in actions for special fields
         */

        //Hash Password , always use generate -> false
        if ($this->password) {
            $this->password = $this->hash->generateUserPassword($this, $this->password);
        }


        // Todo: // create a function to avoid duplicate email and username
        //Check for Email in database
     /*   if($this->email){
            if($this->isUnique('user', $this->email, 'email')){
                return false;
            }
        }*/


        //Check for Username in database
      /*  if ($this->userName) {
            if ($this->isUnique('user', $this->userName, 'username')) {
                return false;
            }
        }*/


        //User Activation
        if (!$activation) {
            //Activates user upon registration
            $this->Activated = 1;
        }

        $data = array();
        $data['username'] = $this->userName;
        $data['firstname'] = $this->fistName;
        $data['lastname'] = $this->lastName;
        $data['email'] = $this->email;
        $data['password'] = $this->password;
        $data['telephone'] = $this->telephone;
        $data['address'] = $this->address;

        $data['city'] = $this->city;
        $data['zipcode'] = $this->zipcode;
        $data['country'] = $this->country;

        $data['created'] = $this->created;
        $data['updated'] = $this->updated;

        if ($this->addUser('user', $data)){
            // Set the new user ID by getting the last userid
            $this->userId = $this->getLastId('user')->id;
            // created a new session
            $this->session->data = md5( $this->userId.$this->email);

            print_r($this->session->data);
            die;
            // set the session signed
            $this->session->signed = true;
            return true;
        }else {
            return false;
        }
    }

    protected  function updateInfo($info){
        $this->userName = trim($this->form_validation->mysql_prep($info['username']));
        $this->fistName = trim($this->form_validation->mysql_prep($info['first_name']));
        $this->lastName = trim($this->form_validation->mysql_prep($info['last_name']));

        $this->email = trim($info['email']);
        $this->password = trim($info['password']);
        $this->telephone = trim($info['telephone']);

        $this->address = trim($this->form_validation->mysql_prep($info['address']));
        $this->city = trim($this->form_validation->mysql_prep($info['city']));
        $this->zipcode = trim($info['zipcode']);
        $this->country = trim($this->form_validation->mysql_prep($info['country']));

        $this->updated = time();

    }

    protected function validateAll(){
       $field_errors = array();

        // Check UserName
        if (!$this->validateField('userName', $this->_validations['Username']['limit'], $this->_validations['Username']['regEx'] )){
            $field_errors['Username'] = 'Error username';
        };

        // ToDo: Create validation for other fields

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
