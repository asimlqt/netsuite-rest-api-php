<?php

namespace NetsuiteRestApi\Api;

use NetsuiteRestApi\Client\ApiException;
use NetsuiteRestApi\Client\HttpClient;

class QueryApi
{
    const QUERY_URI = "/services/rest/query/v1/suiteql";

    public function __construct(
        private readonly HttpClient $httpClient
    ) {}

    /**
     * @throws ApiException
     */
    public function query(string $query): array
    {
        $response = $this->httpClient->sendRequest(
            'POST',
            static::QUERY_URI,
            ['prefer' => 'transient'],
            ['q' => $query]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

}