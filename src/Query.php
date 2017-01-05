<?php

namespace GoogleSearch;

class Query
{

    const API_ENDPOINT = 'https://www.googleapis.com/customsearch/v1';

    const ENABLED  = 1;
    const DISABLED = 0;

    const SAFESEARCH_HIGH = 'hight';
    const SAFESEARCH_MEDIUM = 'medium';
    const SAFESEARCH_OFF = 'off';

    const IMAGECOLORTYPE_COLOR = 'color';
    const IMAGECOLORTYPE_GRAY = 'gray';
    const IMAGECOLORTYPE_MONO = 'mono';

    const IMAGECOLORDOMINANT_BLACK = 'black';
    const IMAGECOLORDOMINANT_BLUE = 'blue';
    const IMAGECOLORDOMINANT_BROWN = 'brown';
    const IMAGECOLORDOMINANT_GRAY = 'gray';
    const IMAGECOLORDOMINANT_GREEN = 'green';
    const IMAGECOLORDOMINANT_PINK = 'pink';
    const IMAGECOLORDOMINANT_PURPLE = 'purple';
    const IMAGECOLORDOMINANT_TEAL = 'teal';
    const IMAGECOLORDOMINANT_WHITE = 'white';
    const IMAGECOLORDOMINANT_YELLOW = 'yellow';

    const FILETYPE_PDF = 'pdf';
    const FILETYPE_PS  = 'ps';
    const FILETYPE_WK1 = 'wk1';
    const FILETYPE_WK2 = 'wk2';
    const FILETYPE_WK3 = 'wk3';
    const FILETYPE_WK4 = 'wk4';
    const FILETYPE_WK5 = 'wk5';
    const FILETYPE_WKI = 'wki';
    const FILETYPE_WKS = 'wks';
    const FILETYPE_WKU = 'wku';
    const FILETYPE_MW  = 'mw';
    const FILETYPE_XLS = 'xls';
    const FILETYPE_PPT = 'ppt';
    const FILETYPE_DOC = 'doc';
    const FILETYPE_WPS = 'wps';
    const FILETYPE_WDB = 'wdb';
    const FILETYPE_WRI = 'wri';
    const FILETYPE_RTF = 'rtf';
    const FILETYPE_SWF = 'swf';
    const FILETYPE_ANS = 'ans';
    const FILETYPE_TXT = 'txt';

    const RIGHTS_PUBLIC_DOMAIN = 'cc_publicdomain';
    const RIGHTS_ATTRIBUTE     = 'cc_attribute';
    const RIGHTS_SHARELIKE     = 'cc_sharealike';
    const RIGHTS_NONCOMMERCIAL = 'cc_noncommercial';
    const RIGHTS_NONDERIVED    = 'cc_nonderived';


    const DATE_DAY = 'd';
    const DATE_WEEK = 'w';
    const DATE_MONTH = 'm';
    const DATE_YEAR = 'y';

    const SEACH_TYPE_IMAGE = 'image';

    const SORT_BY_DATE = 'date';
    const SORT_BY_RELEVANCE = 'relevance';

    private $_options = ['num' => 10];

    /**
     * the query parameter specifies the search query entered by the user.
     * Even though this parameter is optional, you must specify a value for at
     * least one of the query parameters (as_epq, as_lq, as_oq, as_q, as_rq) to get search results.
     *
     * @param $query
     * @return $this
     */
    public function query($query){
        $this->_options['q'] = $query;
        return $this;
    }

    /**
     * Get Query Parameter
     * @return string|null
     */
    public function getQuery(){
        return $this->_getValueFromQuery('q');
    }

    /**
     * Set the api key for the Query
     *
     * @param $key
     * @return $this
     */
    public function setApiKey($key){
        $this->_options['key'] = $key;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getApiKey(){
        return $this->_getValueFromQuery('key');
    }


    /**
     * set the requested number of search results
     *
     * @param integer $number
     * @return $this
     * @throws Exception
     */
    public function setPageSize($number){
        if(!is_int($number))
            throw new Exception('Page size must be a integer');

        $this->_options['num'] = $number;
        return $this;
    }

    /**
     * Get Page size
     * @return integer|null
     */
    public function getPageSize(){
        return $this->_getValueFromQuery('num');
    }

    /**
     * Set the safe parameter indicates how search results should be filtered for adult and pornographic content.
     * The default value for the safe parameter is off
     *
     * @param string $level
     * @return $this
     * @throws Exception
     */
    public function setSafeSearch($level = self::SAFESEARCH_OFF){
        if(!in_array($level, [self::SAFESEARCH_OFF, self::SAFESEARCH_MEDIUM, self::SAFESEARCH_HIGH]))
            throw new Exception('Search seach must be one of the valid options in the self::SAFESEARCH_* list');

        $this->_options['safe'] = $level;
        return $this;
    }

    /**
     * Get the safe parameter
     *
     * @return string|null
     */
    public function getSafeSearch(){
        return $this->_getValueFromQuery('safe');
    }

    /**
     * Set the cx parameter specifies a unique code that identifies a custom search engine.
     * You must specify a Custom Search Engine using the cx parameter to retrieve search results from that CSE.
     *
     * To find the value of the cx parameter, go to Control Panel > Codes tab of your CSE and you will find it in
     * the text area under 'Paste this code in the page where you'd like your search box to appear.
     * The search results will be shown on a Google-hosted page.'
     *
     * @param string $customSearchEngineIdentifier
     * @return $this
     */
    public function setCustomSearchEngine($customSearchEngineIdentifier){
        $this->_options['cx'] = $customSearchEngineIdentifier;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomSearchEngine(){
        return $this->_options['cx'];
    }

    /**
     * The sort parameter specifies that the results be sorted according to the specified expression.
     * For example, sort by date.
     * @param $sortOption
     * @return $this
     */
    public function setSort($sortOption){
        return $this;
    }

    /**
     * Use cref for a linked custom search engine (does not apply for Google Site Search).
     *
     * @param string $linkedCustomSearchEngineIdentifier
     * @return $this
     */
    public function setLinkedCustomSearchEngine($linkedCustomSearchEngineIdentifier){
        $this->_options['cref'] = $linkedCustomSearchEngineIdentifier;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLinkedCustomSearchEngine(){
        return $this->_options['cref'];
    }

    /**
     * The sort parameter specifies that the results be sorted according to the specified expression.
     * For example, sort by date.
     *
     * @param string $order
     * @return $this
     * @throws Exception
     */
    public function setSortOrder($order = self::SORT_BY_DATE){
        if(!in_array($order, [self::SORT_BY_DATE]))
            throw new Exception('Sort order must be a value from the self::SORT_BY_* list');

        $this->_options['sort'] = $order;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSortOrder(){
        return $this->_getValueFromQuery('sort');
    }

    /**
     * Controls turning on or off the duplicate content filter.
     * See Automatic Filtering for more information about Google's search results filters.
     * Note that host crowding filtering applies only to multi-site searches.
     *
     * By default, Google applies filtering to all search results to improve the quality of those results.
     *
     * @param int $enable
     * @return $this
     */
    public function enableFilter($enable = self::ENABLED){
        if($enable != self::ENABLED)
            $enable = self::DISABLED;

        $this->_options['filter'] = $enable;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getEnabledFilter(){
        return $this->_getValueFromQuery('filter');
    }

    /**
     * Restricts search results to documents originating in a particular country.
     * - You may use Boolean operators in the cr parameter's value.
     * - Google Search determines the country of a document by analyzing:
     *    - the top-level domain (TLD) of the document's URL
     *    - the geographic location of the Web server's IP address
     * - See the Country Parameter Values page (https://developers.google.com/custom-search/docs/xml_results#countryCollections) for a list of valid values for this parameter.
     *
     * @param $countryCode
     * @return $this
     */
    public function setGeolocation($countryCode){
        $this->_options['cr'] = $countryCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGeolocation(){
        return $this->_getValueFromQuery('cr');
    }

    /**
     * The local Google domain (for example, google.com, google.de, or google.fr) to use to perform the search.
     * @param $host
     * @return $this
     */
    public function setGooglehost($host){
        $this->_options['googlehost'] = $host;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGooglehost(){
        return $this->_getValueFromQuery('googlehost');
    }

    /**
     * Simplified Chinese and Traditional Chinese are two writing variants of the Chinese language.
     * The same concept may be written differently in each variant. Given a query in one of the variants,
     * the Google WebSearch service can return results that include pages in both variants.
     *
     * @param integer $enable
     * @return $this
     */
    public function enableSimplifiedChinese($enable = self::ENABLED){

        if($enable != self::ENABLED)
            $enable = self::DISABLED;

        $this->_options['c2coff'] = $enable;

        return $this;
    }

    /**
     *
     * @return null|boolean
     */
    public function getSimplifiedChinese(){
        return $this->_getValueFromQuery('c2coff');
    }

    /**
     * Appends the specified query terms to the query, as if they were combined with a logical AND operator.
     *
     * @param $term
     * @return $this
     */
    public function setCombinedSeachTerm($term){
        $this->_options['hq'] = $term;
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function getCombinedSeachTerm(){
        return $this->_getValueFromQuery('hq');
    }

    /**
     * Sets the user interface language.
     *  - Explicitly setting this parameter improves the performance and the quality of your search results.
     *  - See the Interface Languages (https://developers.google.com/custom-search/docs/xml_results#wsInterfaceLanguages)
     *    section of Internationalizing Queries and Results Presentation for more information, and Supported Interface
     *    (https://developers.google.com/custom-search/docs/xml_results#interfaceLanguages) Languages
     *    for a list of supported languages.
     *
     * @param $language
     * @return $this
     */
    public function setInterfaceLanguage($language){
        $this->_options['hl'] = $language;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInterfaceLanguage(){
        return $this->_getValueFromQuery('hl');
    }

    /**
     * Specifies all search results should be pages from a given site.
     *
     * @param $site
     * @return $this
     */
    public function setSiteSearch($site){
        $this->_options['siteSearch'] = $site;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSiteSearch(){
        return $this->_getValueFromQuery('siteSearch');
    }

    /**
     * Identifies a phrase that all documents in the search results must contain.
     *
     * @param $term
     * @return $this
     */
    public function setExactTerm($term){
        $this->_options['exactTerms'] = $term;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExactTerm(){
        return $this->_getValueFromQuery('exactTerms');
    }

    /**
     * Identifies a word or phrase that should not appear in any documents in the search results.
     *
     * @param $term
     * @return $this
     */
    public function setexcludeTerm($term){
        $this->_options['excludeTerms'] = $term;
        return $this;
    }

    public function getexcludeTerm(){
        return $this->_getValueFromQuery('excludeTerms');
    }


    /**
     * set the starting index for the results
     *
     * @param integer $index
     * @return $this
     * @throws Exception
     */
    public function setStartIndex($index){
        if(!is_int($index))
            throw new Exception('Start must be a integer');

        $this->_options['start'] = $index;
        return $this;
    }

    /**
     * Get Query Parameter
     * @return integer|null
     */
    public function getStartIndex(){
        return $this->_getValueFromQuery('start');
    }

    /**
     * Specifies that all search results should contain a link to a particular URL
     *
     * @param string $link
     * @return $this
     */
    public function setLinkSite($link) {
        $this->_options['linkSite'] = $link;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLinkSite() {
        return $this->_getValueFromQuery('linkSite');
    }

    /**
     * Provides additional search terms to check for in a document, where each document in
     * the search results must contain at least one of the additional search terms.
     *
     * @param $term
     * @return $this
     */
    public function setOrTerm($term){
        $this->_options['orTerms'] = $term;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getOrTerm(){
        return $this->_getValueFromQuery('orTerms');
    }

    /**
     * Specifies that all search results should be pages that are related to the specified URL.
     *
     * @param $term
     * @return $this
     */
    public function setRelatedSite($site){
        $this->_options['relatedSite'] = $site;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getRelatedSite(){
        return $this->_getValueFromQuery('relatedSite');
    }


    /**
     * Restricts results to URLs based on date
     *
     * @param string $measurementUnit
     * @param integer $quantity
     * @return $this
     * @throws Exception
     */
    public function setDateRestriction($measurementUnit, $quantity){
        if(!in_array($measurementUnit, [self::DATE_DAY, self::DATE_WEEK, self::DATE_MONTH, self::DATE_YEAR]))
            throw new Exception('$measurementUnit must be one of the valid options in the self::DATE_* list');

        if(!is_int($quantity))
            throw new Exception('$quantity must be an int');

        $this->_options['dateRestrict'] = $measurementUnit .'[' . $quantity. ']';
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getDateRestriction(){
        return $this->_getValueFromQuery('dateRestrict');
    }

    /**
     * Specifies the starting value for a search range.
     * Use lowRange and highRange to append an inclusive search range of lowRange...highRange to the query.
     *
     * @param string $lowRange
     * @return $this
     */
    public function setLowRange($lowRange){
        $this->_options['lowRange'] = $lowRange;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLowRange(){
        return $this->_getValueFromQuery('dateRestrict');
    }

    /**
     * Specifies the starting value for a search range.
     * Use lowRange and highRange to append an inclusive search range of lowRange...highRange to the query.
     *
     * @param string $lowRange
     * @return $this
     */
    public function setHighRange($highRange){
        $this->_options['highRange'] = $highRange;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHighRange(){
        return $this->_getValueFromQuery('highRange');
    }

    /**
     * Specifies the search type: self::SEACH_TYPE_IMAGE.  If unspecified, results are limited to webpages.
     *
     * Acceptable values are:
     * self::SEACH_TYPE_IMAGE: custom image search.
     *
     * @param $type
     * @return $this
     * @throws Exception
     */
    public function setSearchType($type){
        if(!in_array($type, [self::SEACH_TYPE_IMAGE]))
            throw new Exception('$type must be one of the valid options in the self::SEACH_TYPE_* list');

        $this->_options['searchType'] = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSearchType(){
        return $this->_getValueFromQuery('searchType');
    }

    /**
     * Restricts results to files of a specified extension. Filetypes supported by Google include:
     * - Adobe Portable Document Format (self::FILETYPE_PDF)
     * - Adobe PostScript (self::FILETYPE_PSD)
     * - Lotus 1-2-3 (self::FILETYPE_WK1, self::FILETYPE_WK2, self::FILETYPE_WK3, self::FILETYPE_WK4, self::FILETYPE_WK5, self::FILETYPE_WKI, self::FILETYPE_WKS, self::FILETYPE_WKU)
     * - Lotus WordPro (self::FILETYPE_LWP)
     * - Macwrite (self::FILETYPE_MW)
     * - Microsoft Excel (self::FILETYPE_XLS)
     * - Microsoft PowerPoint (self::FILETYPE_PPT)
     * - Microsoft Word (self::FILETYPE_DOC)
     * - Microsoft Works (self::FILETYPE_WKS, self::FILETYPE_WPS, self::FILETYPE_WDB)
     * - Microsoft Write (self::FILETYPE_WRI)
     * - Rich Text Format (self::FILETYPE_RTF)
     * - Shockwave Flash (self::FILETYPE_SWF)
     * - Text (self::FILETYPE_ANS, self::FILETYPE_TXT).
     *
     * @param $type
     * @return $this
     * @throws Exception
     */
    public function setFileType($type){
        if(!in_array($type, [self::FILETYPE_PDF, self::FILETYPE_PSD, self::FILETYPE_WK1, self::FILETYPE_WK2,
            self::FILETYPE_WK3, self::FILETYPE_WK4, self::FILETYPE_WK5, self::FILETYPE_WKI, self::FILETYPE_WKS,
            self::FILETYPE_WKU. self::FILETYPE_LWP, self::FILETYPE_NW, self::FILETYPE_XLS, self::FILETYPE_PPT,
            self::FILETYPE_DOC, self::FILETYPE_WKS, self::FILETYPE_WPS, self::FILETYPE_WDB, self::FILETYPE_WRI,
            self::FILETYPE_RTF, self::FILETYPE_SWF, self::FILETYPE_ANS, self::FILETYPE_TXT]))
                throw new Exception('$type must be one of the valid options in the self::FILETYPE_* list');

        $this->_options['fileType'] = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFileType(){
        return $this->_getValueFromQuery('fileType');
    }

    /**
     * Filters based on licensing. Supported values include: self::RIGHTS_PUBLIC_DOMAIN, self::RIGHTS_ATTRIBUTE,
     * self::RIGHTS_SHARELIKE, self::RIGHTS_NONCOMMERCIAL, self::RIGHTS_NONDERIVED, and combinations of these.
     *
     * @param string $rights
     * @return $this
     * @throws Exception
     */
    public function setRights($rights){
        $rightsSplit = [];
        if(strpos($rights, ',')){
            $rightsSplit = explode(',', $rights);
        } else {
            $rightsSplit[] = $rights;
        }
        foreach($rightsSplit as $right){
            if(!in_array($right, [self::RIGHTS_ATTRIBUTE, self::RIGHTS_NONCOMMERCIAL, self::RIGHTS_NONDERIVED,
                self::RIGHTS_PUBLIC_DOMAIN, self::RIGHTS_SHARELIKE]))
                    throw new Exception('$rights values must be one or multiple of the valid options in the self::RIGHTS_* list');

            $this->_options['rights'] = $rights;
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRights(){
        return $this->_getValueFromQuery('rights');
    }


    /**
     * @todo: implement
     *
     * @param string $size
     * @return $this
     */
    public function setImageSize($size){
        $this->_options['imgSize'] = $size;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageSize(){
        return $this->_getValueFromQuery('imgSize');
    }

    /**
     * @todo: implement
     *
     * @param string $type
     * @return $this
     */
    public function setImageType($type){
        $this->_options['imgType'] = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageType(){
        return $this->_getValueFromQuery('imgType');
    }

    /**
     * @todo: implement
     *
     * @param string $color
     * @return $this
     */
    public function setImageDominantColor($color){
        $this->_options['imgDominantColor'] = $color;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageDominantColor(){
        return $this->_getValueFromQuery('imgDominantColor');
    }

    /**
     * Get all the set options
     *
     * @param bool $raw
     * @return array
     */
    public function getQueryStructure($raw = false){
        if($raw === true)
            return $this->_options;
        return array_merge($this->_options, ['alt' => 'json']);
    }

    public function getQueryEndpoint(){
        return self::API_ENDPOINT;
    }

    /**
     * Return the value from the options array. If not set
     * return a null value.
     *
     * @param string $variableName
     * @return mixed|null
     */
    protected function _getValueFromQuery($variableName){
        if(isset($this->_options[$variableName]))
            return $this->_options[$variableName];

        return null;
    }


}