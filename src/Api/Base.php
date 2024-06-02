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
    public function list(array $queryParams = []): Cursor
    {
        $response = $this->httpClient->sendRequest(
            'GET',
            $this->createPath(),
            queryParams: $queryParams
        );

        $data = json_decode($response->getBody()->getContents(), true);

        return new Cursor($this->pageFactory->createPage($data));
    }

    /**
     * @throws ApiException
     */
    public function get(string $id, array $queryParams = []): array
    {
        $response = $this->httpClient->sendRequest(
            'GET',
            sprintf($this->createPath(true), $id),
            queryParams: $queryParams
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws ApiException
     */
    public function insert(array $record): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            'POST',
            $this->createPath(),
            body: $record
        );
    }

    /**
     * @throws ApiException
     */
    public function delete(string $id): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            'DELETE',
            sprintf($this->createPath(true), $id)
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
