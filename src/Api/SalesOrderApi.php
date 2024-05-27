<?php

namespace NetsuiteRestApi\Api;

use NetsuiteRestApi\Client\ApiException;
use NetsuiteRestApi\Client\HttpClient;

class SalesOrderApi
{
    const SALES_ORDERS_URI = "/services/rest/record/v1/salesOrder";
    const SALES_ORDER_URI = "/services/rest/record/v1/salesOrder/%s";

    public function __construct(
        private readonly HttpClient $httpClient
    ) {}

    /**
     * @throws ApiException
     */
    public function list(array $queryParams = []): array
    {
        $response = $this->httpClient->sendRequest(
            'GET',
            static::SALES_ORDERS_URI,
            queryParams: $queryParams
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws ApiException
     */
    public function get(string $id): array
    {
        $response = $this->httpClient->sendRequest(
            'GET',
            sprintf(static::SALES_ORDER_URI, $id)
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws ApiException
     */
    public function insert(array $record): void
    {
        $this->httpClient->sendRequest(
            'POST',
            static::SALES_ORDERS_URI,
            body: $record
        );
    }

    /**
     * @throws ApiException
     */
    public function delete(string $id): void
    {
        $this->httpClient->sendRequest(
            'DELETE',
            sprintf(static::SALES_ORDER_URI, $id)
        );
    }

    /**
     * @throws ApiException
     */
    public function update(string $id, array $record): void
    {
        $this->httpClient->sendRequest(
            'PATCH',
            sprintf(static::SALES_ORDER_URI, $id),
            body: $record
        );
    }

    /**
     * @throws ApiException
     */
    public function upsert(string $id, array $record): void
    {
        $this->httpClient->sendRequest(
            'PUT',
            sprintf(static::SALES_ORDER_URI, $id),
            body: $record
        );
    }
}
