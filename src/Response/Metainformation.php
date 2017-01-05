<?php

namespace GoogleSearch\Response;


class Metainformation {

    protected $_totalResults = 0;

    protected $_searchTime = 0.0;

    protected $_nextInformation = null;

    protected $_prevInformation = null;

    /**
     * @var SearchQuery|null
     */
    protected $_request = null;

    /**
     * Metainformation constructor.
     * @param \stdClass $queries
     * @param \stdClass $searchInformation
     * @param SearchQuery $request
     */
    public function __construct($queries, $searchInformation, $request){
        $this->_request = $request;
        $this->_init($queries, $searchInformation);
    }

    protected function _init($queries, $searchInformation){
        if(isset($queries->nextPage[0])){
            $this->_nextInformation = $queries->nextPage[0];
        }

        if(isset($queries->prevPage[0])){
            $this->_prevInformation = $queries->prevPage[0];
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
     * @return SearchQuery|null
     */
    public function getNextPage() {
        if($this->_nextInformation)
            return $this->_request->setStartIndex($this->_nextInformation->startIndex);

        return null;
    }

    /**
     * Get the Previous page query if exists
     *
     * @return SearchQuery|null
     */
    public function getPrevPage() {
        if($this->_prevInformation)
            return $this->_request->setStartIndex($this->_prevInformation->startIndex);

        return null;
    }


}