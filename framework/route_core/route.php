<?php

/**
 * Class Router
 * link url and files
 */
class Router
{
    public $route;
    public $controller;

    /**
     * @return mixed
     * "read" query string and put info int $route
     */
    function separate()
    {
        $this->route = (empty($_GET['route'])) ? '' : $_GET['route'];
        if (isset($_GET['checkSum']) && isset($_GET['email'])) {
            $this->route = 'activate';
        }

        if (isset($_GET['link_id'])) {
            $link_id = $_GET['link_id'];
            $this->route = 'info+' . $link_id;
            return $link_id;
        }

        if (isset($_GET['link_id_for_red'])) {
            $link_id_for_red = $_GET['link_id_for_red'];
            $this->route = 'edit+' . $link_id_for_red;
            return $link_id_for_red;
        }
        if (isset($_GET['profile_id'])) {
            $profile_id = $_GET['profile_id'];
            $this->route = 'edit+' . $profile_id;

        }

        if (empty($this->route)) {
            $this->route = 'index';
        }
    }

    /**
     * @return bool
     * @throws Exception
     * first sets into registry income route and output argument pair
     * then gives atribute controller path to document to init
     */
    function compare()
    {
        $link_id = self::separate();
        $link_id_for_red = self::separate();

        $table = new Registry;
        $table->set('accessDenied', 'accessDenied');
        $table->set('registration', 'Registration');
        $table->set('index', 'Info');
        $table->set('info', 'Info');
        if (isset($_GET['profile_id'])) {
            $profile_id = $_GET['profile_id'];
            $this->route = 'profile+' . $profile_id;
            $table->set('profile+' . $profile_id, 'Profile');
        }
        $table->set('info+' . $link_id, 'InfoDescription');
        $table->set('edit+' . $link_id_for_red, 'Edit');
        $table->set('activate', 'Login');
        $table->set('login', 'Login');
        $table->set('logout', 'logout');
        $table->set('regfinish', 'regfinish');
        $table->set('mylinks', 'MyLinks');
        $table->set('userList', 'UserList');
        $arg = $table->get($this->route);
        if ($arg == 'regfinish') {
            $this->controller = VIEW_PATH . 'regfinish.php';
            return true;
        }
        if ($arg == 'accessDenied') {
            $this->controller = VIEW_PATH . 'accessDenied.php';
            return true;
        }
        if ($arg == 'logout') {
            $this->controller = CONT_PATH . 'Logout.php';
            return true;
        }

        $this->controller = CONT_PATH . 'Controller' . $arg . '.php';
        if (!is_file($this->controller)) {
            $this->controller = ADM_CONT_PATH . 'Controller' . $arg . '.php';
            if (!is_file($this->controller)) {
                $this->controller = VIEW_PATH . '404.php';
            }
        }


    }

    /**
     * @throws Exception
     * include called controller
     */
    function init()
    {
        self::compare();
        include $this->controller;
    }

}


