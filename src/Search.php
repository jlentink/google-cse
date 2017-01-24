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

    protected function _requestAutoComplete($searchQuery){
        $url = sprintf('https://clients1.google.com/complete/search?client=partner&hl=en&sugexp=gsnos%%2Cn%%3D13&gs_rn=25&gs_ri=partner&partnerid=%s&types=t&ds=cse&cp=4&gs_id=g&q=%s&callback=autocomplete', $this->_apiEngine, $searchQuery);
        $client = new Client();
        $response = $client->request('GET', $url);
        return $response->getBody()->getContents();

    }

    public function autoComplete($searchQuery){
        $matches = [];
        $completes = [];
        $rawCompleteString = $this->_requestAutoComplete($searchQuery);

        preg_match('/autocomplete.(.*?)\((.*)\)/', $rawCompleteString, $matches);

        try {
            $autoCompleteJson = \GuzzleHttp\json_decode($matches[2]);
            foreach($autoCompleteJson[1] as $item){
                $completes[] = $item[0];
            }
            return $completes;
        }catch(\Exception $e){
            return [];
        }
    }

}