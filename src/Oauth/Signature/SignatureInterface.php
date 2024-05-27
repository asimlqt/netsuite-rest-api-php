<?php

namespace NetsuiteRestApi\Oauth\Signature;

use NetsuiteRestApi\Oauth\Credentials\CredentialsInterface;

interface SignatureInterface
{
    public function __construct(CredentialsInterface $clientCredentials);

    public function setCredentials(CredentialsInterface $credentials): void;

    public function method(): string;

    public function sign(string $uri, array $parameters = [], string $method = 'POST'): string;
}
