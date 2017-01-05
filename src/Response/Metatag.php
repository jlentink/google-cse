<?php

namespace GoogleSearch\Response;


class Metatag
{
    /**
     * @var string
     */
    private $_label = '';

    /**
     * @var string
     */
    private $_value = '';

    /**
     * Metatag constructor.
     * @param $label
     * @param $value
     */
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