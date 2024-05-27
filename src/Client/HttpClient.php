<?php

namespace NetsuiteRestApi\Client;

use Http\Discovery\Psr18Client;
use NetsuiteRestApi\Oauth\OauthService;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\Utils;

class HttpClient
{
    public function __construct(
        private readonly string $baeUrl,
        private readonly Psr18Client $client,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly OauthService $oauthService
    ) {}

    /**
     * @throws ApiException
     */
    public function sendRequest(
        string $httpMethod,
        string $path,
        array $headers = [],
        array $queryParams = [],
        array $body = []
    ): ResponseInterface {
        $uri = new Uri(sprintf('%s%s', $this->baeUrl, $path));
        if (!empty($queryParams)) {
            $uri = Uri::withQueryValues($uri, $queryParams);
        }

        $request = $this->requestFactory->createRequest($httpMethod, $uri->jsonSerialize());

        $headers['Authorization'] = $this->oauthService->getAuthorizationHeader($httpMethod, $uri->jsonSerialize());
        $headers['Content-Type'] = 'application/json';

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        if (!empty($body)) {
            $request = $request->withBody(Utils::streamFor(json_encode($body)));
        }

        $response = $this->client->sendRequest($request);

        if ($response->getStatusCode() >= 400) {
            throw new ApiException($httpMethod, $uri, $response);
        }

        return $response;
    }
}
