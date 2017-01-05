<?php

namespace GoogleSearch\Response;


class Promotion {

    const TYPE_PLAIN = 0;
    const TYPE_HTML  = 1;

    /**
     * @var string
     */
    private $_htmlTitle = '';

    /**
     * @var string
     */
    private $_plainTile = '';

    /**
     * @var string
     */
    private $_displayLink = '';

    /**
     * @var string
     */
    private $_link = '';

    /**
     * @var string
     */
    private $_image = '';

    public function __construct($rawData){
        $this->_htmlTitle = $rawData->htmlTitle;
        $this->_plainTile = $rawData->title;
        $this->_link = $rawData->link;
        if(isset($rawData->image->source))
            $this->_image = $rawData->image->source;
    }

    /**
     * @param int $type
     * @return string
     */
    public function getTitle($type = self::TYPE_PLAIN){
        if($type == self::TYPE_PLAIN){
            return $this->_plainTile;
        }else {
            return $this->_htmlTitle;
        }
    }

    /**
     * @return string
     */
    public function getDisplayLink()
    {
        return $this->_displayLink;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->_link;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->_image;
    }



}