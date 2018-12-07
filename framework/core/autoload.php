<?php

/**
 * Class Autoloader
 * simple class loader
 */
class Autoloader
{

// Define a custom load method

    /**
     * @param $classname
     * if class is not declared autholoader started.
     * if requested class starts with "Controller" or "Model" words require file with such name from dirs respectively
     * if it wont find classes with above classes starts looking for class=name requested=name of the file;
     */
    public function load($classname)
    {

        // Here simply autoload app’s controller and model classes

        if (substr($classname, 0, 10) == "Controller") {

            // Controller
            $class = CONT_PATH . "$classname.php";
            if (!is_file($class)) {

                require_once ADM_CONT_PATH . "$classname.php";
            } else {
                require_once $class;
            }


        } elseif (substr($classname, 0, 5) == "Model") {

            // Model

            require_once MODEL_PATH . "$classname.php";
        }
        if (is_file(CONT_PATH . "$classname.php"))
        {
            require_once CONT_PATH . "$classname.php";
        }

    }

    function autoload()
    {
        spl_autoload_register(array(__CLASS__, 'load'));
    }

    function putter()
    {
        self::autoload();
    }
}