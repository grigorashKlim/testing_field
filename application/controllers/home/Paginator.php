<?php

/**
 * Class Paginator
 * class for pager creation
 */
class Paginator
{
    public $pag_data=array();
    public function __construct($pag_data)
    {
        $this->pag_data=$pag_data;
        $this->getPagArray();

    }

    /**
     * @param null $pag_data
     * @return $this
     * array is prepared in listing class cos it depends on lists going to be displayed;
     * received data converts into atributes ready to be rendered
     */
    public function getPagArray($pag_data=null)
    {
        foreach ($this->pag_data as $index=>$value)
        {
            $this->$index=$value;
        }
        return $this;
    }

    /**
     * @return false|string
     * returns string with full rendered menu (template+data);
     */
    public function loadPaginator()
    {
        $view=New TheViewCore(PAG_TEMP,$this->pag_data);
        return $view->render();
    }
}