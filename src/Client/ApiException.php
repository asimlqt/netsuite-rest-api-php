<?php

namespace NetsuiteRestApi\Client;

use Psr\Http\Message\ResponseInterface;

class ApiException extends \Exception
{
    public function __construct(
        private readonly string $httpMethod,
        private readonly string $uri,
        private readonly ResponseInterface $response
    ) {
        $message = sprintf('Error in request "%s %s"', $this->httpMethod, $this->uri);
        parent::__construct($message, $this->response->getStatusCode());
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}