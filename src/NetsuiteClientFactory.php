<?php

namespace NetsuiteRestApi;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18Client;
use NetsuiteRestApi\Api\CreditMemoApi;
use NetsuiteRestApi\Api\CustomerApi;
use NetsuiteRestApi\Api\QueryApi;
use NetsuiteRestApi\Api\SalesOrderApi;
use NetsuiteRestApi\Client\HttpClient;
use NetsuiteRestApi\Oauth\OauthService;
use NetsuiteRestApi\Pagination\PageFactory;

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
            $oauthService
        );

        $pageFactory = new PageFactory($httpClient);

        return new NetsuiteClient(
            new CreditMemoApi($httpClient, $pageFactory),
            new CustomerApi($httpClient, $pageFactory),
            new QueryApi($httpClient, $pageFactory),
            new SalesOrderApi($httpClient, $pageFactory)
        );
    }
}