<?php

namespace GoogleSearch\Response;


use GoogleSearch\Query;

class Metainformation {

    /**
     * @var int
     */
    protected $_totalResults = 0;

    /**
     * @var float
     */
    protected $_searchTime = 0.0;

    /**
     * @var null|\stdClass
     */
    protected $_nextInformation = null;

    /**
     * @var null|\stdClass
     */
    protected $_prevInformation = null;

    /**
     * @var Query|null
     */
    protected $_request = null;

    /**
     * Metainformation constructor.
     * @param \stdClass $queries
     * @param \stdClass $searchInformation
     * @param Query $request
     */
    public function __construct($queries, $searchInformation, $request){
        $this->_request = $request;
        $this->_init($queries, $searchInformation);
    }

    protected function _init($queries, $searchInformation){
        if(isset($queries->nextPage[0])){
            $this->_nextInformation = $queries->nextPage[0];
        }

        if(isset($queries->previousPage[0])){
            $this->_prevInformation = $queries->previousPage[0];
        }
        $this->_searchTime = $searchInformation->searchTime;
        $this->_totalResults = $searchInformation->totalResults;
    }

    /**
     * @return int
     */
    public function getTotalResults() {
        return $this->_totalResults;
    }

    /**
     * @return float
     */
    public function getSearchTime() {
        return $this->_searchTime;
    }

    /**
     * Get the Next page query query if exists
     *
     * @return Query|null
     */
    public function getNextPage() {
        if($this->_nextInformation && isset($this->_nextInformation->startIndex))
            return $this->_request->setStartIndex($this->_nextInformation->startIndex);

        return null;
    }

    /**
     * Get the Previous page query if exists
     *
     * @return Query|null
     */
    public function getPrevPage() {
        if($this->_prevInformation && isset($this->_prevInformation->startIndex))
            return $this->_request->setStartIndex($this->_prevInformation->startIndex);

        return null;
    }


}