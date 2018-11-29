<?php

// Класс хранилища
Class Registry
{

    private $vars = array();

    // запись данных
    function set($key, $var)
    {
        if (isset($this->vars[$key]) == true) {
            throw new Exception('Unable to set var `' . $key . '`. Already set.');
        }
        $this->vars[$key] = $var;
        /*echo "Переменная $key со значением $var добавлена <br>";*/
        return true;

    }

    // получение данных
    function get($key)
    {
        if (isset($this->vars[$key]) == false) {

            /*echo "false <br>";*/
            return null;
        }
        $var = $this->vars[$key];
        /*echo "Переменная $key со значением  $var <br>";*/
        return $this->vars[$key];

    }

    // удаление данных
    function remove($var)
    {
        unset($this->vars[$key]);
    }

}