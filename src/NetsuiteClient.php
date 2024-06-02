<?php

namespace NetsuiteRestApi;

use NetsuiteRestApi\Api\CreditMemoApi;
use NetsuiteRestApi\Api\CustomerApi;
use NetsuiteRestApi\Api\QueryApi;
use NetsuiteRestApi\Api\SalesOrderApi;

class NetsuiteClient
{
    public function __construct(
        public readonly CreditMemoApi $creditMemo,
        public readonly CustomerApi $customer,
        public readonly QueryApi $query,
        public readonly SalesOrderApi $salesOrder
    ) {}
}