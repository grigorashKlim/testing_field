<?php
session_start();

class Controller
{
    public $model;
    public $view;
    public $access_lvl;
    public $default_template = VIEW_PATH . 'main_template_view.php';

    function __construct()
    {
        $this->view = new TheViewCore($this->default_template);
        $this->model = new Model();
    }

    function action()
    {
        echo $this->view->render();
    }

    /**
     * @param $url
     * replace header redirection to function
     */
    function redirection($url)
    {
        exit(header('Location: ' . $url));
    }

    /**
     * @return bool
     * role check for page access
     * if page need access protection it declares "access" atribute with role needed for access.
     * if user role unset (user didnt sign in) its "unreg" as default
     * if role doesnt compare acces level redirects to "access denied" page.
     */
    function access()
    {
        $role = (New User)->getRole();

        if (!$role) {
            $role = 'unreg';
        }
        if ($role == 'admin') {
            return false;
        }
        if ($role == 'editor' && $this->access_lvl != 'admin') {
            return false;
        }
        if ($role != $this->access_lvl) {
            $this->redirection('accessDenied');
        }
    }

}

