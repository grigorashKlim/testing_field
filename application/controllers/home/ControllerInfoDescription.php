<?php

/*session_start();*/

class ControllerInfoDescription extends Controller
{


    function __construct()
    {
        $this->model = new ModelUser();
        $this->listing = new Listing();
        $this->linking = new Links();
    }

    function action($page_arg = null)
    {
        $template = 'info_view_description.php';
        $header['title'] = 'Подробнее';
        $body['data'] = $this->linking->link_description($page_arg);
        $page = New Page($template, $header, $body);
        $page->composition();
    }
}



