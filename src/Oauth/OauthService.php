<?php

namespace NetsuiteRestApi\Oauth;

use NetsuiteRestApi\Oauth\Credentials\Credentials;
use NetsuiteRestApi\Oauth\Credentials\ClientCredentialsInterface;
use NetsuiteRestApi\Oauth\Credentials\CredentialsInterface;
use NetsuiteRestApi\Oauth\Signature\HmacSha256Signature;
use NetsuiteRestApi\Oauth\Signature\SignatureInterface;

class OauthService
{
    protected CredentialsInterface $clientCredentials;
    protected CredentialsInterface $tokenCredentials;
    protected SignatureInterface $signature;

    public function __construct(
        private readonly string $companyUrl,
        private readonly string $accountId,
        private readonly string $consumerKey,
        private readonly string $consumerSecret,
        private readonly string $tokenId,
        private readonly string $tokenSecret,
    ) {
        $consumerCredentials = new Credentials($this->consumerKey, $this->consumerSecret);
        $this->clientCredentials = $consumerCredentials;

        $tokenCredentials = new Credentials($this->tokenId, $this->tokenSecret);
        $this->tokenCredentials = $tokenCredentials;

        $this->signature = new HmacSha256Signature($consumerCredentials);
    }

    public function getAuthorizationHeader(string $method, string $path, array $bodyParameters = []): string
    {
        $header = $this->protocolHeader(
            strtoupper($method),
            sprintf('%s%s', $this->companyUrl, $path),
            $this->tokenCredentials,
            $bodyParameters
        );

        return sprintf('OAuth realm="%s", %s', $this->accountId, substr($header, 6));
    }

    protected function baseProtocolParameters(): array
    {
        $dateTime = new \DateTime();

        return [
            'oauth_consumer_key' => $this->clientCredentials->getIdentifier(),
            'oauth_nonce' => $this->nonce(),
            'oauth_signature_method' => $this->signature->method(),
            'oauth_timestamp' => $dateTime->format('U'),
            'oauth_version' => '1.0',
        ];
    }

    protected function additionalProtocolParameters(): array
    {
        return [];
    }

    protected function protocolHeader(
        string $method,
        string $uri,
        CredentialsInterface $credentials,
        array $bodyParameters = []
    ): string {
        $parameters = array_merge(
            $this->baseProtocolParameters(),
            $this->additionalProtocolParameters(),
            [
                'oauth_token' => $credentials->getIdentifier(),
            ]
        );

        $this->signature->setCredentials($credentials);

        $parameters['oauth_signature'] = $this->signature->sign(
            $uri,
            array_merge($parameters, $bodyParameters),
            $method
        );

        return $this->normalizeProtocolParameters($parameters);
    }

    protected function normalizeProtocolParameters(array $parameters): string
    {
        array_walk($parameters, function (&$value, $key) {
            $value = rawurlencode($key) . '="' . rawurlencode($value) . '"';
        });

        return 'OAuth ' . implode(', ', $parameters);
    }

    protected function nonce(int $length = 11): string
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

}
