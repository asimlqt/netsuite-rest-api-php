# netsuite-rest-api-php

## Requirements
- PHP >= 8.1
- PSR-7, PSR-17 and PSR-18 implementations

## Usage

```php
$factory = new NetsuiteRestApi\NetsuiteClientFactory(
    $companyUrl,
    $accountId,
    $consumerKey,
    $consumerSecret,
    $tokenId,
    $tokenSecret
);

$client = $factory->create();

try {
    $response = $client->customerApi->get('1234');
} catch (ApiException $e) {
    echo $e->getMessage();
}
```