<?php

/**
 * Class Router
 * links url and files
 */
class Router
{
    public $route;
    public $page_arg = null;
    public $controller = null;

    public function __construct()
    {
        $this->table = new Registry;
    }


    public function arg()
    {
        $this->table = new Registry;
    }


    /**
     * @return bool
     * @throws Exception
     * "read" query string and put info into $this->route
     */
    function queryIntoRoute()
    {
        $this->route = (empty($_GET['route'])) ? '' : $_GET['route'];

        if ($this->route && strripos($this->route, "/")) {
            $exploded = explode("/", $this->route);
            $this->route = $exploded[0];
            $this->page_arg = $exploded[1];
        }

        if (isset($_GET['checkSum']) && isset($_GET['email'])) {
            $this->route = 'Login';
            return true;
        }

        if (empty($this->route)) {
            $this->route = 'Info';
            return true;
        }

    }

    /**
     * @return bool
     * @throws Exception
     * first sets into registry income route and output argument pair
     * then gives atribute controller path to document to init
     */
    function init()
    {
        self::queryIntoRoute();

        /*table for converting url request into name of the controller */
        $this->table->set('links', 'InfoDescription');
        $this->table->set('info', 'Info');
        $this->table->set('my_links', 'MyLinks');
        $this->table->set('user_list', 'UserList');
        $this->table->set('profile', 'Profile');
        $this->table->set('registration', 'Registration');
        $this->table->set('logout', 'Logout');
        $this->table->set('access_denied', 'accessDenied');
        $this->table->set('edit', 'Edit');
        $this->table->set('login', 'Login');

        /*check fpr static pages*/
        if ($this->route == 'regfinish') {
            return include_once VIEW_PATH . 'regfinish.php';
        }
        if ($this->route == 'accessDenied') {
            return include_once VIEW_PATH . 'accessDenied.php';
        }
        if ($this->route == 'Logout') {
            return include_once CONT_PATH . 'Logout.php';
        }

        /*first checks if the url needs convert*/
        $arg = $this->table->get($this->route);
        if ($arg !== null) {
            $this->route = $arg;
        }


        foreach (ALL_CONT_PATHS as $path) {
            if (is_file($path . 'Controller' . $this->route . '.php')) {
                $this->controller = 'Controller' . $this->route;
            }
        }
        /*404 check*/
        if (!$this->controller) {

            return include_once VIEW_PATH . '404.php';
        }

        /*if user signed in,cookie must be started as well,so session starts for role checking*/
        $controller = New $this->controller();
        if (isset($_COOKIE['SessionId']) && !isset($_SESSION)) {
            session_start();
        }
        /*loads chosen controller*/
        $controller->action($this->page_arg);
    }
}


