<?php

namespace NetsuiteRestApi\Oauth\Credentials;

class Credentials implements CredentialsInterface
{
    public function __construct(
        private readonly string $identifier,
        private readonly string $secret
    ) {}

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }
}
