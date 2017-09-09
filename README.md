# CPA Integration
[![codecov](https://codecov.io/gh/wearesho-team/cpa-integration/branch/master/graph/badge.svg)](https://codecov.io/gh/wearesho-team/cpa-integration)
[![Build Status](https://travis-ci.org/wearesho-team/cpa-integration.svg?branch=master)](https://travis-ci.org/wearesho-team/cpa-integration)
[![License](https://poser.pugx.org/wearesho-team/cpa-integration/license)](https://packagist.org/packages/wearesho-team/cpa-integration)
[![Latest Stable Version](https://poser.pugx.org/wearesho-team/cpa-integration/version)](https://packagist.org/packages/wearesho-team/cpa-integration)


**PHP7 is required**

*This package created for commercial products of [Wearesho Team](https://wearesho.com)*

This class includes postback integration to following services:
1. [SalesDoubler](https://www.salesdoubler.com.ua) #Supported
3. [PrimeLead](http://primelead.com.ua) #Supported
2. [admitad](https://www.admitad.com/ru/) #Future
4. [Loangate](http://loangate.com.ua) #Future

Other services may be integrated in future. Pull requests is welcome.

## Installation
```bash
composer require wearesho-team/cpa-integration
```

## Usage

### Sending conversion to CPA network
You should put this code on some action in your system
```php
<?php
use Wearesho\Cpa\Postback\PostbackService;
use Wearesho\Cpa\Repository\ConversionMemoryRepository;
use Wearesho\Cpa\Postback\PostbackServiceConfig;
use Wearesho\Cpa\Lead\LeadFactory;
use Wearesho\Cpa\Exceptions\DuplicatedConversionException;
use Wearesho\Cpa\Exceptions\UnsupportedConversionTypeException;

$servicesConfig = yaml_parse('your_config_file.yml'); // Or another config loader (array must be provided), see Configuration section
$repository = new ConversionMemoryRepository(); // Or use your implementation of interface
$client = new \GuzzleHttp\Client(); // Or another implementation of \GuzzleHttp\ClientInterface
$config = new PostbackServiceConfig($servicesConfig);
$service = new PostbackService(
    $repository,
    $client,
    $config
);

$leadFactory = new LeadFactory(); 
$lead = $leadFactory->fromUrl($_REQUEST['REQUEST_URI']); // Or parse it on each request and load from database on user action
$lead = $leadFactory->fromCookie($_COOKIE['CPA_PROVIDER']); // Or you can store lead between request and load it from cookie

$userOrActionId = 1;
$conversion = $lead->createConversion($userOrActionId);

try {
    $response = $service->send($conversion);   
}
catch(DuplicatedConversionException $duplicationException) {
    // If your code may generate few conversion with same id
}
catch(UnsupportedConversionTypeException $invalidConversion) {
    // If you did not configure conversion for current lead CPA network
}
catch(\GuzzleHttp\Exception\RequestException $connectionException) {
    // If CPA network url is unavailable or your config is not accepted
}
```

### Storing lead between request in cookies
```php
<?php
use Wearesho\Cpa\Lead\LeadFactory;

$cookieKey = "CPA_PROVIDER";

$factory = new LeadFactory();
$lead = $factory->fromUrl($_REQUEST['REQUEST_URI']); // Or use your handling request implementation
$cookie = $factory->toCookie($lead);
setcookie($cookieKey, $cookie); // Or use your library to handle cookies
```

## Configuration
Your documentation should look like 
```php
<?php
function get_config() {
    // This function may load values from file (in your implementation)
    return [
        'SomeCpaNetwork' => false, // Put false (or just not add config) if you want to switch off postback to network
        
        'SalesDoubler' => [
            'baseUrl' => 'http://rdr.salesdoubler.com.ua/', // optional
            'token' => 'YourToken',
            'id' => 'YourId',        
        ],
        
        'PrimeLead' => [
            'baseUrl' => 'https://primeadv.go2cloud.org/', // optional
            'id' => 'YourId',
        ],
    ];
}
```

## Contributors
1. [Alexander <horat1us> Letnikow](https://github.com/Horat1us)

## License
[MIT](./LICENSE)
