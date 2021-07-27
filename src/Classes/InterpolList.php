<?php

namespace Jota\InterpolList\Classes;

use GuzzleHttp\Client;

class InterpolList
{
    /**
     * data to do request
     * @var array
     */
    private array $request_query = [];

    /**
     * client GuzzleHttp\Client
     * @var Client
     */
    private Client $client;

    /**
     * result to search
     * @var array
     */
    private array $result;

    /**
     * init result default and GuzzleHttp\Client
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->result['is_registered'] = true;
        $this->result['total_results'] = 0;
        $this->result['results'] = [];
    }

    /**
     * add data to requests query
     * @param $request_data
     * @return void
     */
    private function setData(array $request_data = null): void
    {
        if (!is_null($request_data)) {
            if (isset($request_data['lastname']) && $request_data['lastname'] !== '')
                $this->request_query['query']['name'] = $request_data['lastname'];
            if (isset($request_data['name']) && $request_data['name'] !== '')
                $this->request_query['query']['forename'] = $request_data['name'];
            if (isset($request_data['nationality']) && $request_data['nationality'] !== '')
                $this->request_query['query']['nationality'] = $request_data['nationality'];
            if (isset($request_data['arrestWarrantCountryId']) && $request_data['arrestWarrantCountryId'] !== '')
                $this->request_query['query']['arrestWarrantCountryId'] = $request_data['arrestWarrantCountryId'];
        }

        $this->request_query['query']['page'] = 1;
        $this->request_query['query']['resultPerPage'] = 1;
    }

    /**
     * search into interpol list whit guzzle
     * @return void
     */
    public function search(array $request_data = null): void
    {
        $this->setData($request_data);
        if ($this->getTotal() > 0) {
            $this->result['is_registered'] = true;
            $list = $this->client->request('GET', config('interpollist.url'), $this->request_query);
            $data = json_decode($list->getBody()->getContents(), true);
            $this->result['results'] = $data['_embedded']['notices'];
        } else {
            $this->result['is_registered'] = false;
            $this->result['results'] = [];
        }
    }

    /**
     * Return the total number of responses
     * @return void
     */
    public function getTotal(): int
    {
        $list = $this->client->request('GET', config('interpollist.url'), $this->request_query);
        $data = json_decode($list->getBody()->getContents(), true);
        $this->result['total_results'] = $data['total'];
        $this->request_query['query']['resultPerPage'] = $data['total'];
        return (int)$data['total'];
    }


    /**
     * Return countries list in json forms
     */
    public function getCountries(): string
    {
        $contries = config('interpollist.countries');
        return json_encode($contries);
    }

    /**
     * Return a search result in json form
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }
}
