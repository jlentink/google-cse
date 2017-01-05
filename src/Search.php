<?php

namespace GoogleSearch;

use GuzzleHttp\Client;

class Search
{
    private $_apiKey = '';

    private $_apiEngine = '';

    private $_pageSize = 10;

    public function __construct($apiKey, $searchEngine)
    {
        $this->_apiKey = $apiKey;
        $this->_apiEngine = $searchEngine;
    }

    /**
     * {@inheritdoc}
     */
    public function setPageSize($pageSize){
        $this->_pageSize = $pageSize;
        return $this;
    }

    /**
     * @return Query
     */
    public function getQuery(){
        $query = new Query();
        $query
            ->setCustomSearchEngine($this->_apiEngine)
            ->setApiKey($this->_apiKey);

        return $query;
    }

    /**
     * @param Query|string $searchQuery
     * @param int|null $startIndex Pages start from 0
     * @return Response
     */
    public function search($searchQuery, $startIndex = null)
    {
        if(!get_class($searchQuery) == 'GoogleSearch\Query'){
            $query = $searchQuery;
            $searchQuery = $this->getQuery();
            $searchQuery->query($query);
        }

        if(is_int($startIndex)){
            $searchQuery->setStartIndex($startIndex);
        }


        $client = new Client();
        return new Response($client->get($searchQuery->getQueryEndpoint(), ['query' => $searchQuery->getQueryStructure()])->getBody(), $searchQuery);
    }
}