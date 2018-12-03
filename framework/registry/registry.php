<?php
/**
 * Class Registry
 * data storage class
 */
// Класс хранилища
Class Registry
{

    private $vars = array();

    // запись данных

    /**
     * @param $key
     * @param $var
     * @return bool
     * @throws Exception
     * set data
     */
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

    /**
     * @param $key
     * @return mixed|null
     * get data from storage
     */
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

    /**
     * @param $var
     * remove data
     */
    function remove($var)
    {
        unset($this->vars[$key]);
    }

}