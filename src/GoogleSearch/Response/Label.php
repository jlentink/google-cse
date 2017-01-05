<?php

namespace GoogleSearch\Response;


class Label {

    private $_name = '';

    private $_displayName = '';

    private $_labelWithOp = '';

    public function __construct($data){
        $this->_name = $data->name;
        $this->_labelWithOp = $data->label_with_op;
        $this->_displayName = $data->displayName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->_displayName;
    }

    /**
     * @return string
     */
    public function getLabelWithOp()
    {
        return $this->labelWithOp;
    }

}