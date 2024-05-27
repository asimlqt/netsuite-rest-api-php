<?php

namespace NetsuiteRestApi;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18Client;
use NetsuiteRestApi\Api\CustomerApi;
use NetsuiteRestApi\Api\QueryApi;
use NetsuiteRestApi\Client\HttpClient;
use NetsuiteRestApi\Client\UriGenerator;
use NetsuiteRestApi\Oauth\OauthService;

class NetsuiteClientFactory
{
    public function __construct(
        public readonly string $companyUrl,
        public readonly string $accountId,
        public readonly string $consumerKey,
        public readonly string $consumerSecret,
        public readonly string $tokenId,
        public readonly string $tokenSecret,
    ) {}

    public function create(): NetsuiteClient
    {
        $oauthService = new OauthService(
            $this->companyUrl,
            $this->accountId,
            $this->consumerKey,
            $this->consumerSecret,
            $this->tokenId,
            $this->tokenSecret
        );

        $client = new Psr18Client();
        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();

        $httpClient = new HttpClient(
            $this->companyUrl,
            $client,
            $requestFactory,
            new UriGenerator($this->companyUrl),
            $oauthService
        );

        return new NetsuiteClient(
            new CustomerApi($httpClient),
            new QueryApi($httpClient)
        );
    }
}