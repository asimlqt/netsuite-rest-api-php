<?php

namespace NetsuiteRestApi\Api;

use NetsuiteRestApi\Client\ApiException;
use NetsuiteRestApi\Client\HttpClient;

class CustomerApi
{
    const CUSTOMERS_URI = "/services/rest/record/v1/customer";
    const CUSTOMER_URI = "/services/rest/record/v1/customer/%s";

    public function __construct(
        private readonly HttpClient $httpClient
    ) {}

    /**
     * @throws ApiException
     */
    public function list(): array
    {
        $response = $this->httpClient->sendRequest(
            'GET',
            static::CUSTOMERS_URI
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws ApiException
     */
    public function get(string $customerId): array
    {
        $response = $this->httpClient->sendRequest(
            'GET',
            sprintf(static::CUSTOMER_URI, $customerId)
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws ApiException
     */
    public function insert(array $record): void
    {
        $response = $this->httpClient->sendRequest(
            'POST',
            static::CUSTOMERS_URI,
            body: $record
        );
    }
}