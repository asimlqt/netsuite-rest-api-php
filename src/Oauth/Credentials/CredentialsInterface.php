<?php

namespace NetsuiteRestApi\Oauth\Credentials;

interface CredentialsInterface
{
    public function getIdentifier(): string;
    public function getSecret(): string;
}
