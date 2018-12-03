<?php

class View
{
    function __construct()
    {
        $this->role=(New User)->getRole();
        $this->user_login=(New User)->getLogin();
    }

    //public $template_view; // здесь можно указать общий вид по умолчанию.

    /**
     * @param $content_view
     * @param null $data
     * @param null $extra_array
     * generate view of a page
     * takes view file name - $content_view, data to display on page - $data and some extra data,like array with data for paginator
     * also checks role and input compared template for content.
     */
    function generate($content_view, $data = null, $extra_array = null)
    {


        if (is_array($extra_array)) {
            // преобразуем элементы массива в переменные
            extract($extra_array);

        }

        if ($this->user_login=='unreg') {
            $template_view = 'template_unreg_view.php';
        } else {
            $template_view = 'template_' . $this->role . '_view.php';
        }

        $view = VIEW_PATH . $template_view;

        if (!is_file($view)) {
            include ADM_VIEW_PATH . $template_view;
        } else {
            include VIEW_PATH . $template_view;
        }
    }
}

?>