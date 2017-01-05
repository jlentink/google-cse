<?php

namespace GoogleSearch\Response;


class Metatag
{
    private $_label = '';

    private $_value = '';

    public function __construct($label, $value){
        $this->_label = $label;
        $this->_value = $value;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->_value;
    }


}