<?php
/**
 * menu creation class
 */
class Menu
{
    public $items = array();
    public $menu_name;
    public $menu_storage;
    public $view;

    /**
     * @param $item
     * @param $href
     * @return $this
     * add menu items as item and link pair
     */
    public function addMenuItem($item, $href)
    {
        $this->items[$item] = $href;
        return $this;
    }

    public function getMenu($name = null)
    {
        $this->createMenu();
        return $this->view;
    }

    public function createMenu()
    {
        $this->view = New TheViewCore(MENU_TEMP, $this->items);
        return $this->view;
    }

    public function loadMenu($name = null)
    {
        $this->getMenu($name = null);
        return $this->view->render();
    }


}