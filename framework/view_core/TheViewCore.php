<?php

class TheViewCore
{
    public $template;
    public $fields = array();

    /**
     * TheViewCore constructor.
     * @param null $template
     * @param null $fields
     * you may set template and data as object's attributes;
     * data will be converted into the object attributes as well;
     */
    public function __construct($template = null, $fields = null)
    {
        if ($template !== null) {
            $this->setTemplate($template);
        }
        $this->fields = $fields;
        if (!empty($fields)) {
            foreach ($fields as $name => $value) {
                $this->$name = $value;
            }
        }
    }

    /**
     * @param $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     * all data is being added into data array for render in future;
     */
    public function __set($name, $value)
    {
        $this->fields[$name] = $value;
        return $this;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (!isset($this->fields[$name])) {
            throw new InvalidArgumentException(
                "Unable to get the field '$field'.");
        }
        $field = $this->fields[$name];
        return $field instanceof Closure ? $field($this) : $field;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->fields[$name]);
    }

    /**
     * @param $name
     * @return $this
     */
    public function __unset($name)
    {
        if (!isset($this->fields[$name])) {
            throw new InvalidArgumentException(
                "Unable to unset the field '$field'.");
        }
        unset($this->fields[$name]);
        return $this;
    }

    /**
     * @return false|string
     * loads data and template for being displayed
     */
    public function render()
    {
        if (is_array($this->fields)) {
            extract($this->fields);
        }
        ob_start();
        include $this->template;
        return ob_get_clean();
    }
}