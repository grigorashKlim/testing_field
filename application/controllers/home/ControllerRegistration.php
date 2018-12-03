<?php

class ControllerRegistration extends Controller
{
    function __construct()
    {
        $this->model = new ModelBase();
        $this->view = new View();

    }

    function action()
    {
        $this->view->generate('main_view.php');

        if (isset($_POST['register'])) {
            /*$this->model->connectDB();*/
            $a = $this->model->Register();
            if ($a == true) {
                $this->redirection('regfinish');

            }
        }
        if (isset($_POST['reged'])) {
            $this->redirection('login');
        }
    }
}

(New ControllerRegistration)->action();

