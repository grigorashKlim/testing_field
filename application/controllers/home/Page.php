<?php

class Page
{
    public $default_template = VIEW_PATH . 'main_template_view.php';

    function __construct($template = null, $header = null, $body = null, $footer = null)
    {
        $this->template = VIEW_PATH . $template;
        $this->header = $header;
        $this->body = $body;
        $this->footer = $footer;
        $this->view = new TheViewCore($this->default_template);
        $this->body_view = New TheViewCore($this->template);
        $this->view->body = $this->body_view;/*hooks main template and body template as main atribute <=> object*/

    }

    /**
     *
     * method creates base template for each page.
     * directly loads info for header and footer.
     * creates object with own template for body of the site.
     */
    function composition()
    {
        $user = New User();
        $role = $user->getRole();

        if (is_array($this->header)) {
            extract($this->header);
            $menu = New Menu();
            if ($role == 'unreg') {
                $menu->addMenuItem('Registration', 'registration');
                $menu->addMenuItem('Login', 'login');
            }

            if ($role !== 'unreg') {
                $log_tmp = VIEW_PATH . 'log_window_view.php';
                $log_window = New TheViewCore($log_tmp);
                $this->view->log_window = $log_window;
                $menu->addMenuItem('Profile', 'profile');
                $menu->addMenuItem('My links', 'my_links');

                if ($role == 'admin') {
                    $menu->addMenuItem('User List', 'user_list');
                }

            }
            $menu->addMenuItem('Info', 'info');
            $menu = $menu->loadMenu();
            $this->view->title = $title;
            $this->view->menu = $menu;
        }

        if (is_array($this->body)) {
            extract($this->body);
            if (isset($data_for_render) && is_array($data_for_render)) {
                extract($data_for_render);
            }
            if (isset($data)) {
                $this->body_view->data = $data;
            }

            if (isset($errors)) {
                $this->body_view->errors = $errors;
            }
            if (isset($pag_array)) {
                $pager = New Paginator($pag_array);
                $this->body_view->pager = $pager->loadPaginator();
            }

        }
        if (is_array($this->footer)) {
            extract($this->footer);
        }
        echo $this->view->render();
    }

}
