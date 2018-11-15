<?php
class Controller {
	public $model;
	public $view;
	public $access_lvl;
	
	function __construct()
	{
		$this->view = new View();
		$this->model = new Model();
	}
	
	function action_index()
	{

	}
    function access()
    {
        if (isset($_SESSION['role']))
        {
            $role = $_SESSION['role'];
        }
        else
        {
            $role='unreg';
        }
        if ($role=='admin')
        {
            return false;
        }
        if ($role=='editor' && $this->access_lvl!='admin')
        {
            return false;
        }
        if ($role!=$this->access_lvl)
        {
            exit(header('Location: http://first-test-project.lib/accessDenied'));
        }


    }
}

