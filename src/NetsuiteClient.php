<?php

namespace NetsuiteRestApi;

use NetsuiteRestApi\Api\CustomerApi;
use NetsuiteRestApi\Api\QueryApi;

class NetsuiteClient
{
    public function __construct(
        public readonly CustomerApi $customerApi,
        public readonly QueryApi $queryApi
    ) {}
}