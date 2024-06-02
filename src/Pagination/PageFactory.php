<?php

namespace NetsuiteRestApi\Pagination;

use NetsuiteRestApi\Client\HttpClient;

class PageFactory
{
    public function __construct(
        private readonly HttpClient $httpClient
    ) {}

    public function createPage(
        array $data,
        string $httpMethod = 'GET',
        array $headers = [],
        array $body = []
    ): Page {
        $links = $this->parseLinks($data['links']);

        $firstLink = $links['first'] ?? $links['self'];
        $previousLink = $links['previous'] ?? null;
        $nextLink = $links['next'] ?? null;

        $totalResults = $data['totalResults'];

        $items = $data['items'];

        return new Page(
            new PageFactory($this->httpClient),
            $this->httpClient,
            $firstLink,
            $previousLink,
            $nextLink,
            $totalResults,
            $items,
            $httpMethod,
            $headers,
            $body
        );
    }

    private function parseLinks(array $links): array
    {
        $parsedLinks = [];

        foreach ($links as $link) {
            $parsedLinks[$link['rel']] = $link['href'];
        }

        return $parsedLinks;
    }
}
