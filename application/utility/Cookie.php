<?php
/**
 * Created by PhpStorm.
 * User: hermann
 * Date: 18/03/15
 * Time: 23:21
 */

namespace Utility;


class Cookie {

    /** @var  Log - Log errors and report */
    public $log;

    /** @var  string The name of the cookie */
    private $name;
    /** @var  string The content of the cookie */
    private $value;
    /** @var  int The lifetime in days of the cookie */
    private $lifetime;
    /** @var  string The path of the cookie */
    private $path;

    /**
     * Initializes a cookie
     *
     * @param string $name     The name of the cookie
     * @param string $value    _(optional)_ The content of the cookie
     * @param int    $lifetime _(optional)_ The lifetime in days of the cookie
     * @param string $path     _(optional)_ The URL path of the cookie
     * @param null   $host     _(optional)_ The host for which the host belongs to
     */
    public function __construct($name, $value = null, $lifetime = 15, $path = '/')
    {
        $this->name = $name;
        //Defaults
        $this->value = $value;
        $this->setLifetime($lifetime);
        $this->setPath($path);
    }

    /**
     * Set the lifetime of the cookie
     *
     * @param int $lifetime - The number of days to last
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = $lifetime;
    }

    /**
     * Set the path of the cookie relative to the site domain
     *
     * @param string $path - The path of the cookie
     */
    public function setPath($path)
    {
        $this->path = $path;
    }


    /**
     * Sends the cookie to the browser
     *
     * @return bool
     */
    public function add()
    {
        setcookie(
            $this->name,
            $this->value,
            round(time() + 60 * 60 * 24 * $this->lifetime),
            $this->path
        );
    }

    /**
     * Destroys the cookie
     *
     * @return bool
     */
    public function destroy()
    {
        if (!is_null($this->getValue())) {

            return setcookie(
                $this->name,
                '',
                time() - 3600,
                $this->path,
                $this->host
            ); //Deletes Cookie

        } else {
            // The cookie does not exists, there is nothing to destroy
            return true;
        }
    }

    /**
     * Get the value of the cookie
     *
     * @return null|mixed - Returns null if the cookie does not exists
     */
    public function getValue()
    {
        if (isset($_COOKIE[$this->name])) {
            return $_COOKIE[$this->name];
        } else {
            return null;
        }
    }

    /**
     * Sets the value for
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}