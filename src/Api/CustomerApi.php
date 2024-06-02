<?php

namespace NetsuiteRestApi\Api;

use NetsuiteRestApi\Client\ApiException;
use NetsuiteRestApi\Client\HttpClient;
use NetsuiteRestApi\Pagination\Cursor;
use NetsuiteRestApi\Pagination\PageFactory;

class CustomerApi
{
    const CUSTOMERS_URI = "/services/rest/record/v1/customer";
    const CUSTOMER_URI = "/services/rest/record/v1/customer/%s";

    public function __construct(
        private readonly HttpClient $httpClient,
        private readonly PageFactory $pageFactory
    ) {}

    /**
     * @throws ApiException
     */
    public function list(array $queryParams = []): Cursor
    {
        $response = $this->httpClient->sendRequest(
            'GET',
            static::CUSTOMERS_URI,
            queryParams: $queryParams
        );

        $data = json_decode($response->getBody()->getContents(), true);

        return new Cursor($this->pageFactory->createPage($data));
    }

    /**
     * @throws ApiException
     */
    public function get(string $customerId, array $queryParams = []): array
    {
        $response = $this->httpClient->sendRequest(
            'GET',
            sprintf(static::CUSTOMER_URI, $customerId),
            queryParams: $queryParams
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
            static::CUSTOMERS_URI,
            body: $record
        );
    }

    /**
     * @throws ApiException
     */
    public function delete(string $customerId): void
    {
        $this->httpClient->sendRequest(
            'DELETE',
            sprintf(static::CUSTOMER_URI, $customerId)
        );
    }
}
