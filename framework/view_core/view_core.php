<?php

class View
{
    //public $template_view; // здесь можно указать общий вид по умолчанию.

    function generate($content_view, $data = null, $extra_array = null)
    {

        if (is_array($extra_array)) {
            // преобразуем элементы массива в переменные
            extract($extra_array);

        }

        if (!isset($_SESSION['user_login'])) {
            $template_view = 'template_unreg_view.php';
        } else {
            $template_view = 'template_' . $_SESSION['role'] . '_view.php';
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