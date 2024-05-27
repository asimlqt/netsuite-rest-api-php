<?php

namespace NetsuiteRestApi\Client;

use Http\Discovery\Psr18Client;
use NetsuiteRestApi\Oauth\OauthService;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Utils;

class HttpClient
{
    public function __construct(
        private readonly string $baeUrl,
        private readonly Psr18Client $client,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly UriGenerator $uriGenerator,
        private readonly OauthService $oauthService
    ) {}

    /**
     * @throws ApiException
     */
    public function sendRequest(string $httpMethod, string $uri, array $headers = [], array $body = []): ResponseInterface
    {
        $headers['Authorization'] = $this->oauthService->getAuthorizationHeader($httpMethod, $uri);
        $headers['Content-Type'] = 'application/json';

        $url = sprintf('%s%s', $this->baeUrl, $uri);
        $request = $this->requestFactory->createRequest($httpMethod, $url);

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
