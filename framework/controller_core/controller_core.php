<?php


class Controller
{
    public $model;
    public $view;
    public $access_lvl;

    function __construct()
    {
        $this->view = new View();
        $this->model = new Model();
    }

    function action()
    {

    }

    /**
     * @param $url
     * replace header redirection to function
     */
    function redirection($url)
    {
        exit(header('Location: '.$url));
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
        $role=(New User)->getRole();

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

