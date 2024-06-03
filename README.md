# netsuite-rest-api-php

## Requirements
- PHP >= 8.1
- PSR-7, PSR-17 and PSR-18 implementations

## Installation

```shell
composer require asimlqt/netsuite-rest-api-php
```

## Usage

The first step is to create a factory instance passing in the netsuite API settings.
All the params are required.

```php
$factory = new NetsuiteRestApi\NetsuiteClientFactory(
    $companyUrl,
    $accountId,
    $consumerKey,
    $consumerSecret,
    $tokenId,
    $tokenSecret
);
```
After that call the create method which will return an instance of the REST API client. 
```php
$client = $factory->create();
```
You can now call any endpoint you want on the client e.g.
```php
try {
    $response = $client->customer->get('1234');
} catch (ApiException $e) {
    echo $e->getMessage();
}
```

### Error Handling
Make sure to wrap all API calls in a `try/catch`. There is only one exception that
will be thrown when an API call fails `NetsuiteRestApi\Client\ApiException`

To get the actual response object simply call the `getResponse()` method of the exception instance.
This will return a `Psr\Http\Message\ResponseInterface`.

### API methods available
Every endpoint has the following 6 methods:
* list
* get
* insert
* delete
* update
* upsert

Note: not all of these are available for every endpoint in Netsuite. For the time being
this client does not prevent you from calling unavailable methods, however, you will receive an error from Netsuite.

### Pagination

The only endpoint that supports pagination is `list`. This will return a cursor that implements `Iterator` so you can iterate over it as you would normally.

```php
try {
    $cursor = $client->currency->list();
    foreach ($cursor as $item) {
        echo $item['id'];
    }
} catch (ApiException $e) {
    echo $e->getMessage();
}
```
The cursor will iterate over individual entities. When all entities have been iterated over it will
automatically fetch the next page if available.

Note: Even if you supply a limit query parameter, the cursor will still iterate
over all available entities in Netsuite.

```php
$cursor = $client->currency->list(['limit' => 3]);
```

The `limit` query parameter only provides the ability to set how many entities to fetch on each API call.

If you want to only iterate over a set number of entities even though there is more available then wrap the cursor in a `LimitIterator`.

```php
 $cursor = $client->customer->list(['limit' => 10]);
 foreach (new LimitIterator($cursor, 0, 10) as $item) {
    ...
 }
```
