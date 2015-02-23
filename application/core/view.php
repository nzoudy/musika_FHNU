<?php

namespace Musika\core;


// TODO: create another view with the loadView template and Variables from the controller
// TODO: Render the view from different Controller with the baseController

class View {

    function __construct()
    {

    }

    /**
     * The variable property contains the variables
     * that can be used inside of the templates.
     *
     * @access private
     * @var array
     */
    private $variables = array();

    /**
     * The directory where the templates are stored
     *
     * @access private
     * @var string
     */
    private $template_dir = null;

    /**
     * Adds a variable that can be used by the templates.
     *
     * Adds a new array index to the variable property. This
     * new array index will be treated as a variable by the templates.
     *
     * @param string $name The variable name to use in the template
     * @param string $value The content you assign to $name
     * @access public
     * @return void
     * @see getVars, $variables
     *
     */
    public function __set($name, $value)
    {
        $this->variables[$name] = $value;
    }

    /**
     * @Returns names of all the added variables
     *
     * Returns a numeral array containing the names of all
     * added variables.
     *
     * @access public
     * @return array
     * @see addVar, $variables
     *
     */
    public function getVars()
    {
        $variables = array_keys($this->variables);
        return !empty($variables) ? $variables : false;
    }

    /**
     *
     * Outputs the final template output
     *
     * Fetches the final template output, and echoes it to the browser.
     *
     * @param string $file Filename (with path) to the template you want to output
     * @param string $id The cache identification number/string of the template you want to fetch
     * @access public
     * @return void
     * @see fetch
     *
     */
    public function render($file, $id = null)
    {
        echo $this->fetch($file, $id);
    }


    /**
     * Fetch the final template output and returns it
     *
     * @param string $template_file Filename (with path) to the template you want to fetch
     * @param string $id The cache identification number/string of the template you want to fetch
     * @access private
     * @return string Returns a string on success, FALSE on failure
     * @see render
     *
     */
    public function fetch($template_file, $id = null)
    {
        /*** if the template_dir property is set, add it to the filename ***/
        if (!empty($this->template_dir))
        {
            $template_file = realpath($this->template_dir) . '/' . $template_file;
        }

        /*** get the cached file contents ***/
        /* if ($this->caching == true && $this->isCached($template_file, $id))
         {
             $output = $this->getCache($template_file, $id);
         }
         else
         {
             $output = $this->getOutput($template_file);
             /*** create the cache file ***/
        /*       if ($this->caching == true)
               {
                   $this->addCache($output, $template_file, $id);
               }
           }*/
        $output = $this->getOutput($template_file);
        return isset($output) ? $output : false;
    }


    /**
     *
     * Fetch the template output, and return it
     *
     * @param string $template_file Filename (with path) to the template to be processed
     * @return string Returns a string on success, and FALSE on failure
     * @access private
     * @see fetch, render
     *
     */
    public function getOutput( $template_file )
    {
        /*** extract all the variables ***/
        extract( $this->variables );

        if (file_exists($template_file))
        {
            ob_start();
            require APP . 'view/_templates/header.php';
            include($template_file);
            require APP . 'view/_templates/footer.php';
            $output = ob_get_contents();
            ob_end_clean();
        }
        // load footer here
        else
        {
            throw new \Exception("The template file '$template_file' does not exist");
        }
        return !empty($output) ? $output : false;
    }




    /**
     *
     * Sets the template directory
     *
     * @param string $dir Path to the template dir you want to use
     * @access public
     * @return void
     *
     */
    public function setTemplateDir($dir)
    {
        $template_dir = realpath($dir);
        if (is_dir($template_dir))
        {
            $this->template_dir = $template_dir;
        }
        else
        {
            throw new \Exception("The template directory '$dir' does not exist");
        }
    }


}