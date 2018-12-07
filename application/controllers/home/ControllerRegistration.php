<?php
class ControllerRegistration extends Controller
{
    function __construct()
    {
        $this->model = new ModelBase();
    }

    function action()
    {
        if (isset($_POST['register'])) {

            $a = $this->model->Register();
            if ($a == true) {
                $this->redirection('regfinish');
            }
        }
        if (isset($_POST['reged'])) {
            $this->redirection('login');
        }
        $template='registration_view.php';
        $header['title']='Регистрация';
        $page= New Page($template,$header);
        $page->composition();
    }
}


