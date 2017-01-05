<?php

namespace GoogleSearch\Response;

class Facet {

    /**
     * @var string
     */
    private $_anchor = '';

    /**
     * @var string
     */
    private $_label = '';

    /**
     * @var string
     */
    private $_labelWithOp = '';

    public function __construct($jsonObject){
        $this->_anchor = $jsonObject->anchor;
        $this->_label = $jsonObject->label;
        $this->_labelWithOp = $jsonObject->label_with_op;
    }

    /**
     * @return string
     */
    public function getAnchor()
    {
        return $this->_anchor;
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
    public function getLabelWithOp()
    {
        return $this->_labelWithOp;
    }

}