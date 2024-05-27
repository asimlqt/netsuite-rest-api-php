<?php

namespace NetsuiteRestApi\Oauth\Signature;

use NetsuiteRestApi\Oauth\Credentials\ClientCredentialsInterface;
use NetsuiteRestApi\Oauth\Credentials\CredentialsInterface;

abstract class Signature implements SignatureInterface
{
    protected CredentialsInterface $clientCredentials;

    protected CredentialsInterface $credentials;

    public function __construct(CredentialsInterface $clientCredentials)
    {
        $this->clientCredentials = $clientCredentials;
    }

    public function setCredentials(CredentialsInterface $credentials): void
    {
        $this->credentials = $credentials;
    }

    protected function key(): string
    {
        $key = rawurlencode($this->clientCredentials->getSecret()) . '&';

        if ($this->credentials !== null) {
            $key .= rawurlencode($this->credentials->getSecret());
        }

        return $key;
    }
}
