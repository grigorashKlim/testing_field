<?php
class controller_login extends Controller
{
	function __construct()
	{
		$this->model = new model_base();
		$this->view= new View();
	}

	function action_index()
	{
		$this->view->generate('login_view.php', 'template_unreg_view.php');
        if(isset($_GET['checkSum'])&&isset($_GET['email'])) {
            $this->model->mail_check();
        }
        if( isset($_POST['enter'])) {
            $this->login = $_POST['login'];
            $this->password = $_POST['password'];
            $user_login = $this->model->sign_in($this->login,$this->password);
            if ($user_login) {

                exit(header('Location: http://first-test-project.lib/info'));

            }
        }
	}
}
(New controller_login)->action_index();

