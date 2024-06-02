<?php

namespace NetsuiteRestApi\Pagination;

use GuzzleHttp\Psr7\Uri;
use NetsuiteRestApi\Client\ApiException;
use NetsuiteRestApi\Client\HttpClient;

class Page
{
    public function __construct(
        private readonly PageFactory $pageFactory,
        private readonly HttpClient $httpClient,
        private readonly string $firstLink,
        private readonly ?string $previousLink,
        private readonly ?string $nextLink,
        private readonly int $totalResults,
        private readonly array $items,
        private readonly string $httpMethod,
        private readonly array $headers,
        private readonly array $body
    ) {}

    /**
     * @throws ApiException
     */
    public function getFirstPage(): Page
    {
        return $this->getPage($this->firstLink);
    }

    /**
     * @throws ApiException
     */
    public function getPreviousPage(): ?Page
    {
        return $this->hasPreviousPage() ? $this->getPage($this->previousLink) : null;
    }

    /**
     * @throws ApiException
     */
    public function getNextPage(): ?Page
    {
        return $this->hasNextPage() ? $this->getPage($this->nextLink) : null;
    }

    public function getTotalResults(): int
    {
        return $this->totalResults;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function hasNextPage(): bool
    {
        return $this->nextLink !== null;
    }

    public function hasPreviousPage(): bool
    {
        return $this->previousLink !== null;
    }

    public function getNextLink(): ?string
    {
        return $this->nextLink;
    }

    public function getPreviousLink(): ?string
    {
        return $this->previousLink;
    }

    /**
     * @throws ApiException
     */
    protected function getPage(string $uri): Page
    {
        $u = new Uri($uri);
        $path = $u->getPath();
        parse_str($u->getQuery(), $queryParams);

        $queryParams = array_merge($queryParams, $this->getInitialQueryParams());

        $response = $this->httpClient->sendRequest(
            $this->httpMethod,
            $path,
            headers: $this->headers,
            queryParams: $queryParams,
            body: $this->body
        );
        $data = json_decode($response->getBody()->getContents(), true);

        return $this->pageFactory->createPage($data, $this->httpMethod, $this->headers, $this->body);
    }

    private function getInitialQueryParams(): array
    {
        $uri = new Uri($this->firstLink);
        parse_str($uri->getQuery(), $queryParams);

        unset($queryParams['limit']);
        unset($queryParams['offset']);

        return $queryParams;
    }

}