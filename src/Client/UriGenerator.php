<?php

namespace NetsuiteRestApi\Client;

class UriGenerator
{

    private string $baseUri;

    public function __construct(string $baseUri)
    {
        $this->baseUri = rtrim($baseUri, '/');
    }

    public function generate($path, array $uriParameters = [], array $queryParameters = []): string
    {
        $uriParameters = $this->encodeUriParameters($uriParameters);

        $uri = $this->baseUri . '/' . vsprintf(ltrim($path, '/'), $uriParameters);

        if (!empty($queryParameters)) {
            $uri .= '?' . http_build_query($queryParameters, "", '&', PHP_QUERY_RFC3986);
        }

        return $uri;
    }

    protected function encodeUriParameters(array $uriParameters): array
    {
        return array_map(function ($uriParameter) {
            $uriParameter = rawurlencode($uriParameter);

            return preg_replace('~\%2F~', '/', $uriParameter);
        }, $uriParameters);
    }
}
