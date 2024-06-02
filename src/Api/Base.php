<?php

namespace NetsuiteRestApi\Api;

use NetsuiteRestApi\Client\ApiException;
use NetsuiteRestApi\Client\HttpClient;
use NetsuiteRestApi\Pagination\Cursor;
use NetsuiteRestApi\Pagination\PageFactory;
use Psr\Http\Message\ResponseInterface;

class Base
{
    const BASE_PATH = '/services/rest/record/v1';

    public function __construct(
        private readonly HttpClient $httpClient,
        private readonly PageFactory $pageFactory
    ) {}

    /**
     * @throws ApiException
     */
    public function list(array $headers = [], array $queryParams = []): Cursor
    {
        $response = $this->httpClient->sendRequest(
            'GET',
            $this->createPath(),
            headers: $headers,
            queryParams: $queryParams
        );

        $data = json_decode($response->getBody()->getContents(), true);

        return new Cursor($this->pageFactory->createPage($data));
    }

    /**
     * @throws ApiException
     */
    public function get(string $id, array $headers = [], array $queryParams = []): array
    {
        $response = $this->httpClient->sendRequest(
            'GET',
            sprintf($this->createPath(true), $id),
            headers: $headers,
            queryParams: $queryParams
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws ApiException
     */
    public function insert(array $record, array $headers = [], array $queryParams = []): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            'POST',
            $this->createPath(),
            headers: $headers,
            queryParams: $queryParams,
            body: $record
        );
    }

    /**
     * @throws ApiException
     */
    public function delete(string $id, array $headers = []): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            'DELETE',
            sprintf($this->createPath(true), $id),
            headers: $headers
        );
    }

    /**
     * @throws ApiException
     */
    public function update(string $id, array $record, array $headers = [], array $queryParams = []): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            'PATCH',
            sprintf($this->createPath(true), $id),
            headers: $headers,
            queryParams: $queryParams,
            body: $record
        );
    }

    /**
     * @throws ApiException
     */
    public function upsert(string $id, array $record, array $headers = [], array $queryParams = []): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            'PUT',
            sprintf($this->createPath(true), $id),
            headers: $headers,
            queryParams: $queryParams,
            body: $record
        );
    }

    private function createPath(bool $singleRecord = false): string
    {
        $path = static::BASE_PATH . static::PATH;

        if ($singleRecord) {
            $path .= '/%s';
        }

        return $path;
    }
}
