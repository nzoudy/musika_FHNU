<?php
/**
 * Created by PhpStorm.
 * User: hermann
 * Date: 18/03/15
 * Time: 23:19
 */

namespace Utility;


class Session extends LinkedCollection
{
    /** @var  Log - Log errors and report */
    public $log;

    /** @var null|string Session index to manage */
    protected $namespace;

    /**
     * Initialize a session handler by namespace
     *
     * @param string $namespace - Session namespace to manage
     * @param   Log  $log
     */
    public function __construct($namespace = null, Log $log = null)
    {
       // $this->log = $log instanceof Log ? $log : new Log('Session');
        $this->namespace = $namespace;

        // Starts the session if it has not been started yet
        if (!isset($_SESSION) && !headers_sent()) {
            session_start();
           // $this->log->report('Session is been started...');
        } elseif (isset($_SESSION)) {
           // $this->log->report('Session has already been started');
        } else {
          //  $this->log->error('Session could not be started');
        }

        if (is_null($namespace)) {
            // Manage the whole session
           // parent::__construct($_SESSION);
        } else {
            if (!isset($_SESSION[$namespace])) {
                // Initialize the session namespace if does not exists yet
                $_SESSION[$namespace] = array();
            }

        }

    }


    /**
     * Get current session ID identifier
     *
     * @return string
     */
    public function getID()
    {
        return session_id();
    }

    /**
     * Empty the session namespace
     */
    public function destroy()
    {
        if (is_null($this->namespace)) {
            // Destroy the whole session
            session_destroy();
        } else {
            // Just empty the current session namespace
            $_SESSION[$this->namespace] = array();
            unset($_SESSION[$this->namespace]);
        }
    }
}