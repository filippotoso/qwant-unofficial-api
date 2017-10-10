# Qwant Unofficial API Client

A simple client for qwant.com unofficial API.

## Requirements

- PHP 5.6+
- guzzlehttp/guzzle 6.2+

## Installing

Use Composer to install it:

```
composer require filippo-toso/qwant-unofficial-api
```

## Using It

```
use FilippoToso\QwantUnofficialAPI\Client as QwantClient;

// Create the client
$client = new QwantClient('en_US');

// Get a list of suggested searches
$results = $client->suggest('market');
var_dump($results);

// Execute a generic search (default is for the web)
$results = $client->search('marketing');
var_dump($results);

// Get all the web results about the provided query
$results = $client->web('marketing');
var_dump($results);

// Get all the social results about the provided query
$results = $client->social('marketing');
var_dump($results);

// Get all the images about the provided query
$results = $client->images('marketing');
var_dump($results);

// Get all the news about the provided query
$results = $client->news('marketing');
var_dump($results);

```
