<?php
/**
 * Created by PhpStorm.
 * User: hermann
 * Date: 06/02/15
 * Time: 01:06
 */

namespace Musika\model;

use Musika\core\Model;

class User extends Model {
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

    function __construct()
    {
        // Instantiate the hash generator
        $this->hash = new Hash();
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

    // return list de song de cette utilisateur

    // 1 to N add new users

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
        if ($this->isSigned()) {
            // $this->log->error(15);
            return false;
        }

        //Saves Registration Data in Class
        $this->_updates = $info = $this->toCollection($info);

        //Validate All Fields
        if (!$this->validateAll(true)) {
            return false;
        } //There are validations error

        //Set Registration Date
        $info->RegDate = time();

        /*
         * Built in actions for special fields
         */

        //Hash Password
        if ($info->Password) {
            $info->Password = $this->hash->generateUserPassword($this, $info->Password);
        }

        //Check for Email in database
        if ($info->Email) {
            if ($this->table->isUnique('Email', $info->Email, 16)) {
                return false;
            }
        }

        //Check for Username in database
        if ($info->Username) {
            if ($this->table->isUnique('Username', $info->Username, 17)) {
                return false;
            }
        }

        //Check for errors
        if ($this->log->hasError()) {
            return false;
        }

        //User Activation
        if (!$activation) {
            //Activates user upon registration
            $info->Activated = 1;
        }

        //Prepare Info for SQL Insertion
        $data = array();
        $into = array();
        foreach ($info->toArray() as $index => $val) {
            if (!preg_match("/2$/", $index)) { //Skips double fields
                $into[] = $index;
                //For the statement
                $data[$index] = $val;
            }
        }

        // Construct the fields
        $intoStr = implode(', ', $into);
        $values = ':' . implode(', :', $into);

        //Prepare New User Query
        $sql = "INSERT INTO _table_ ({$intoStr})
                VALUES({$values})";

        //Enter New user to Database
        if ($this->table->runQuery($sql, $data)) {
            $this->log->report('New User has been registered');
            // Update the new ID internally
            $this->_data['ID'] = $info->ID = $this->table->getLastInsertedID();
            if ($activation) {
                // Generate a user specific hash
                $info->Confirmation = $this->hash->generate($info->ID);
                // Update the newly created user with the confirmation hash
                $this->update(array('Confirmation' => $info->Confirmation));
                // Return the confirmation hash
                return $info->Confirmation;
            } else {
                return true;
            }
        } else {
            $this->log->error(1);
            return false;
        }
    }

}
