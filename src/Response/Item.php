<?php

namespace GoogleSearch\Response;


class Item{

    const TYPE_PLAIN     = 0;
    const TYPE_HTML      = 1;
    const TYPE_FORMATTED = 2;
    const TYPE_DISPLAY   = 3;

    /**
     * @var string
     */
    private $_cacheId = '';

    /**
     * @var string
     */
    private $_link = '';

    /**
     * @var string
     */
    private $_displayLink = '';

    /**
     * @var string
     */
    private $_formattedUrl = '';

    /**
     * @var string
     */
    private $_htmlFormattedUrl = '';

    /**
     * @var string
     */
    private $_image = '';

    /**
     * @var Metatag[]
     */
    private $_metaTags = [];

    /**
     * @var string
     */
    private $_snippet = '';

    /**
     * @var string
     */
    private $_htmlSnippet = '';

    /**
     * @var string
     */
    private $_title = '';

    /**
     * @var string
     */
    private $_htmlTitle = '';


    /**
     * @var Label[]
     */
    private $_labels = [];


    public function __construct($data){
        $this->_init($data);
    }

    protected function _init($data){
        $this->_cacheId = $data->cacheId;
        $this->_displayLink = $data->displayLink;
        $this->_formattedUrl = $data->formattedUrl;
        $this->_htmlFormattedUrl = $data->htmlFormattedUrl;
        $this->_htmlSnippet = $data->htmlSnippet;
        $this->_htmlTitle = $data->htmlTitle;
        $this->_link = $data->link;
        if(isset($data->pagemap->cse_image->src))
            $this->_image = $data->pagemap->cse_image->src;
        $this->_snippet = $data->snippet;
        $this->_title = $data->title;

        if(isset($data->pagemap->metatags[0])){
            foreach($data->pagemap->metatags[0] as $label => $value){
                $this->_metaTags[] = new Metatag($label, $value);
            }
        }
        if(isset($data->labels)){
            foreach($data->labels as $label){
                $this->_labels[] = new Label($label);
            }
        }
    }

    /**
     * @return string
     */
    public function getCacheId()
    {
        return $this->_cacheId;
    }


    /**
     * @param int $type
     * @return string
     */
    public function getFormattedUrl($type = self::TYPE_PLAIN)
    {
        if($type == self::TYPE_HTML)
            return $this->_htmlFormattedUrl;
        return $this->_formattedUrl;
    }

    /**
     * @param int $type
     * @return string
     */
    public function getLink($type = self::TYPE_PLAIN)
    {
        if($type == self::TYPE_DISPLAY)
            return $this->_displayLink;

        return $this->_link;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->_image;
    }


    /**
     * @return Metatag[]
     */
    public function getMetaTags()
    {
        return $this->_metaTags;
    }

    /**
     * @param int $type
     * @return string
     */
    public function getSnippet($type = self::TYPE_PLAIN)
    {
        if($type == self::TYPE_HTML)
            return $this->_htmlSnippet;

        return $this->_snippet;
    }

    /**
     * @param int $type
     * @return string
     */
    public function getTitle($type = self::TYPE_PLAIN)
    {
        if($type == self::TYPE_HTML)
            return $this->_displayLink;
        return $this->_title;
    }

    /**
     * @return Label[]
     */
    public function getLabels()
    {
        return $this->_labels;
    }

}