<?php

namespace FilippoToso\QwantUnofficialAPI;

use GuzzleHttp\Client as HTTPClient;
use GuzzleHttp\Exception\BadResponseException;

class Client
{

    protected $language = null;

    /**
     * Create an instance of the client.
     * @param String $language        The default language to be used in the queries
     */
    public function __construct($language = 'en_US') {
        $this->language = $language;
    }

    /**
     * Execute an HTTP GET request to Qwant API
     * @param  String $url The url of the API endpoint
     * @return Array|FALSE  The result of the request
     */
    protected function get($url) {

        $client = new HTTPClient();

        try {
            $res = $client->request('GET', $url, [
                'headers' => [
                    'Accept'     => 'application/json',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:56.0) Gecko/20100101 Firefox/56.0',
                ],
            ]);
        }
        catch (BadResponseException $e) {
            return FALSE;
        }

        $data = json_decode($res->getBody(), TRUE);

        return $data;

    }

    /**
     * Execute an HTTP POST request to Qwant API
     * @param  String $url The url of the API endpoint
     * @param  Array $data The parameters of the request
     * @return Array|FALSE  The result of the request
     */
    protected function post($url, $data) {

        $client = new HTTPClient();

        try {
            $res = $client->request('POST', $url, [
                'json' => $data,
                'headers' => [
                    'Accept'     => 'application/json',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:56.0) Gecko/20100101 Firefox/56.0',
                ],
            ]);
        }
        catch (BadResponseException $e) {
            return FALSE;
        }

        $data = json_decode($res->getBody(), TRUE);

        return $data;

    }

    /**
     * Get list of available OS and browsers
     * @param String $query          The query you want to get suggestions for
     * @param String $language       The language to be used in the query
     * @return Array The list of suggested queries
     */
    public function suggest($query, $language = null) {
        $language = is_null($language) ? $this->language : $language;
        return $this->get(sprintf('https://api.qwant.com/api/suggest?q=%s&lang=%s', urlencode($query), urlencode($language)));
    }

    /**
     * Get list of available OS and browsers
     * @param String $query          The query you want to get results for
     * @param String $language       The language to be used in the query
     * @return Array The list of available OS and browsers
     */
    public function search($query, $type = 'web', $count = 10, $offset = 0, $safesearch = TRUE, $language = null) {
        $language = is_null($language) ? $this->language : $language;

        $params = [
            'count' => $count,
            'offset' => $offset,
            'q' => $query,
            't' => 'all',
            'device' => 'desktop',
            'safesearch' => $safesearch ? 1 : 0,
            'locale' => $language,
        ];
        $url = sprintf('https://api.qwant.com/api/search/%s?%s', urlencode($type), http_build_query($params));
        return $this->get($url);
    }

    public function web($keyword, $count = 10, $offset = 0, $safesearch = TRUE, $language = null) {
        return $this->search($keyword, 'web', $count, $offset, $safesearch, $language);
    }

    public function news($keyword, $count = 10, $offset = 0, $safesearch = TRUE, $language = null) {
        return $this->search($keyword, 'news', $count, $offset, $safesearch, $language);
    }

    public function images($keyword, $count = 10, $offset = 0, $safesearch = TRUE, $language = null) {
        return $this->search($keyword, 'ia', $count, $offset, $safesearch, $language);
    }

    public function social($keyword, $count = 10, $offset = 0, $safesearch = TRUE, $language = null) {
        return $this->search($keyword, 'social', $count, $offset, $safesearch, $language);
    }

}
