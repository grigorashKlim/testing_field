<?php

class Autoloader
{

// Define a custom load method

    public function load($classname)
    {

        // Here simply autoload app’s controller and model classes

        if (substr($classname, 0, 10) == "controller") {

            // Controller
            $class = CONT_PATH . "$classname.php";
            if (!is_file($class)) {
                require_once ADM_CONT_PATH . "$classname.php";
            } else {
                require_once CONT_PATH . "$classname.php";
            }


        } elseif (substr($classname, 0, 5) == "model") {

            // Model

            require_once MODEL_PATH . "$classname.php";
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