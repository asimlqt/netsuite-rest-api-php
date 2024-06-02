<?php

namespace NetsuiteRestApi\Api;

use NetsuiteRestApi\Client\ApiException;
use NetsuiteRestApi\Client\HttpClient;
use NetsuiteRestApi\Pagination\Cursor;
use NetsuiteRestApi\Pagination\PageFactory;

class QueryApi
{
    const QUERY_URI = "/services/rest/query/v1/suiteql";

    public function __construct(
        private readonly HttpClient $httpClient,
        private readonly PageFactory $pageFactory
    ) {}

    /**
     * @throws ApiException
     */
    public function query(string $query, array $queryParams = []): Cursor
    {
        $response = $this->httpClient->sendRequest(
            'POST',
            static::QUERY_URI,
            ['prefer' => 'transient'],
            $queryParams,
            ['q' => $query]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        return new Cursor($this->pageFactory->createPage(
            $data,
            'POST',
            ['prefer' => 'transient'],
            ['q' => $query]
        ));
    }

}