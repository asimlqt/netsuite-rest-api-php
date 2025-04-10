<?php

namespace NetsuiteRestApi\Oauth\Signature;

use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

trait EncodesUrl
{
    protected function createUrl(string $uri): UriInterface
    {
        return Psr7\Utils::uriFor($uri);
    }

    protected function baseString(UriInterface $url, string $method = 'POST', array $parameters = []): string
    {
        $baseString = rawurlencode($method) . '&';

        $schemeHostPath = Uri::fromParts([
            'scheme' => $url->getScheme(),
            'host' => $url->getHost(),
            'port' => $url->getPort(),
            'path' => $url->getPath(),
        ]);

        $baseString .= rawurlencode($schemeHostPath) . '&';

        parse_str($url->getQuery(), $query);
        $data = array_merge($query, $parameters);

        // normalize data key/values
        $data = $this->normalizeArray($data);
        ksort($data);

        $baseString .= $this->queryStringFromData($data);

        return $baseString;
    }

    protected function normalizeArray(array $array = []): array
    {
        $normalizedArray = [];

        foreach ($array as $key => $value) {
            $key = rawurlencode(rawurldecode($key));

            if (is_array($value)) {
                $normalizedArray[$key] = $this->normalizeArray($value);
            } else {
                $normalizedArray[$key] = rawurlencode(rawurldecode($value));
            }
        }

        return $normalizedArray;
    }

    protected function queryStringFromData(array $data, ?array $queryParams = null, string $prevKey = ''): string
    {
        if ($initial = (null === $queryParams)) {
            $queryParams = [];
        }

        foreach ($data as $key => $value) {
            if ($prevKey) {
                $key = $prevKey . '[' . $key . ']'; // Handle multi-dimensional array
            }
            if (is_array($value)) {
                $queryParams = $this->queryStringFromData($value, $queryParams, $key);
            } else {
                $queryParams[] = rawurlencode($key . '=' . $value); // join with equals sign
            }
        }

        if ($initial) {
            return implode('%26', $queryParams); // join with ampersand
        }

        return $queryParams;
    }
}
