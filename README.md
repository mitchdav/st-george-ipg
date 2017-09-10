# St.George IPG Client

[![Build Status](https://travis-ci.org/mitchdav/st-george-ipg.svg?branch=master)](https://travis-ci.org/mitchdav/st-george-ipg)
[![Latest Stable Version](https://poser.pugx.org/mitchdav/st-george-ipg/v/stable.svg)](https://packagist.org/packages/mitchdav/st-george-ipg)
[![Total Downloads](https://poser.pugx.org/mitchdav/st-george-ipg/downloads.svg)](https://packagist.org/packages/mitchdav/st-george-ipg)
[![License](https://poser.pugx.org/mitchdav/st-george-ipg/license.svg)](https://packagist.org/packages/mitchdav/st-george-ipg)
[![Coverage Status](https://coveralls.io/repos/github/mitchdav/st-george-ipg/badge.svg?branch=master)](https://coveralls.io/github/mitchdav/st-george-ipg?branch=master)

A PHP client implementation of the St.George Internet Payment Gateway using the WebService or Webpay extension.

Using this library, you can provide your St.George-issued credentials and begin charging cards instantly.

The library supports all features of the gateway, including:
- Purchases and refunds
- Pre-authorisations and completions
- Status checks on existing transactions
- Setting a client reference on the transaction
- Setting a comment on the transaction
- Setting the merchant description on the transaction (which will appear on the customer's bank statement)

The library has 2 providers to connect to St.George:
- WebService
- Extension

## WebService

The WebService is **by far** the easiest to integrate with, and just uses a simple HTTP client to connect to an API exposed by St.George.

### Requirements

- PHP >= 5.6
- [Composer](https://getcomposer.org/)

If you run into SSL connection issues using the WebService provider on OS X, please check this [support thread](https://stackoverflow.com/a/26538127/7503569).

### Installation

You can install the library in your project with Composer:

    composer require mitchdav/st-george-ipg

### Initialising The Client

The WebService requires 2 credentials, which are your St.George-issued client ID, and an authentication token.

Copy your client ID into the ```IPG_CLIENT_ID``` environment variable, or modify the code below.

You can find the authentication token by logging into the [Merchant Administraction Console](https://www.ipg.stgeorge.com.au/StgWeb/merchants/), clicking on *Merchant Details* and then under *IPG Accounts* on the right, click your client ID and then go to the *authentication* tab.

In the list on the left, click on *configure* next to *Security Token*, and generate a token. Copy that value into the ```IPG_AUTHENTICATION_TOKEN``` environment variable, or modify the code below.

You can then initialise the client with the following:

```php
<?php

use StGeorgeIPG\Client;
use StGeorgeIPG\Providers\WebService;

$clientId            = getenv('IPG_CLIENT_ID');
$authenticationToken = getenv('IPG_AUTHENTICATION_TOKEN');

$webService = new WebService();

$webService->setClientId($clientId)
           ->setAuthenticationToken($authenticationToken);

$client = new Client($webService);
```

## Extension

The extension is **significantly harder** to integrate with, and requires you to compile and install a PHP extension.

### Requirements

- PHP 5.6 (unfortunately the Webpay extension does not currently support PHP 7.0+, so this provider is constrained to the same requirements)
- [Composer](https://getcomposer.org/)
- Linux OS ([constrained by Webpay](https://www.ipg.stgeorge.com.au/downloads/Linux_API_Developer_Guide_v3.3.pdf))
- [Webpay library compiled and installed](#installing-webpay) (see the [Docker section below](#installing-with-docker) for how to mostly automate this)

### Installation

You can install the library in your project with Composer:

    composer require mitchdav/st-george-ipg

You'll then need to compile and install the Webpay PHP extension, which is [explained below](#installing-webpay).

### Initialising The Client

The Extension requires 2 credentials, which are your St.George-issued client ID, your certificate password, and optionally an authentication token.

Copy your client ID into the ```IPG_CLIENT_ID``` environment variable, or modify the code below.

Copy your certificate password into the ```IPG_CERTIFICATE_PASSWORD``` environment variable, or modify the code below.

If you have previously set an authentication token, you can find it by logging into the [Merchant Administraction Console](https://www.ipg.stgeorge.com.au/StgWeb/merchants/), clicking on *Merchant Details* and then under *IPG Accounts* on the right, click your client ID and then go to the *authentication* tab.

In the list on the left, click on *configure* next to *Security Token*, and generate a token. Copy that value into the ```IPG_AUTHENTICATION_TOKEN``` environment variable, or modify the code below.

If you have never set an authentication token, this step is optional and the transactions will complete successfully without it. If you have one set (perhaps if you were testing the WebService provider), you must set it on the Extension.

If your certificate is installed to a separate location, you can set the path into the ```IPG_CERTIFICATE_PATH``` environment variable, or modify the code below.

You can then initialise the client with the following:

```php
<?php

use StGeorgeIPG\Client;
use StGeorgeIPG\Providers\Extension;

$clientId            = getenv('IPG_CLIENT_ID');
$authenticationToken = getenv('IPG_AUTHENTICATION_TOKEN');
$certificatePassword = getenv('IPG_CERTIFICATE_PASSWORD');
$certificatePath     = getenv('IPG_CERTIFICATE_PATH');

if (!$certificatePath) {
    $certificatePath = 'cert.cert';
}

$extension = new Extension();

$extension->setClientId($clientId)
          ->setAuthenticationToken($authenticationToken)
          ->setCertificatePassword($certificatePassword)
          ->setCertificatePath($certificatePath);

$client = new Client($extension);
```

## Usage

The client provides helper methods to construct a valid request. More options are available for each request type than shown below, so check the [Client](https://github.com/mitchdav/st-george-ipg/blob/master/src/Client.php) to see how to optionally set the CVC2 (for example), or the merchant description.

After a request has been created, you need to call ```$client->execute($request)``` on the request to obtain the response. If the transaction is unsuccessful, the response code is mapped to different exceptions as shown [below](#handling-errors). If no exception is thrown, then the transaction was successful.

### Charging the Customer (Purchase)

With an initialised client you can charge the customer, like so:

```php
use Carbon\Carbon;
use StGeorgeIPG\Exceptions\ResponseCodes\Exception;

$oneYearAhead = (new Carbon())->addYear();

$amount     = 10.00; // In dollars
$cardNumber = '4111111111111111';
$month      = $oneYearAhead->month;
$year       = $oneYearAhead->year;

$purchaseRequest = $client->purchase($amount, $cardNumber, $month, $year);

try {
    $purchaseResponse = $client->execute($purchaseRequest);

    echo 'The charge was successful.' . "\n";
} catch (Exception $ex) {
    echo 'The charge was unsuccessful.' . "\n";
    echo $ex->getMessage() . "\n";

    var_dump($purchaseRequest);
    var_dump($ex->getResponse());
}
```

### Refunding a Charge

You can refund the customer after charging them, like so:

```php
use Carbon\Carbon;
use StGeorgeIPG\Exceptions\ResponseCodes\Exception;

$oneYearAhead = (new Carbon())->addYear();

$amount     = 10.00; // In dollars
$cardNumber = '4111111111111111';
$month      = $oneYearAhead->month;
$year       = $oneYearAhead->year;

$purchaseRequest = $client->purchase($amount, $cardNumber, $month, $year);

try {
    $purchaseResponse = $client->execute($purchaseRequest);

    echo 'The charge was successful.' . "\n";

    $refundRequest = $client->refund(5.00, $purchaseResponse->getTransactionReference()); // In dollars

    try {
        $refundResponse = $client->execute($refundRequest);

        echo 'The refund was successful.' . "\n";
    } catch (Exception $ex) {
        echo 'The refund was unsuccessful.' . "\n";
        echo $ex->getMessage() . "\n";

        var_dump($refundRequest);
        var_dump($ex->getResponse());
    }
} catch (Exception $ex) {
    echo 'The charge was unsuccessful.' . "\n";
    echo $ex->getMessage() . "\n";

    var_dump($purchaseRequest);
    var_dump($ex->getResponse());
}
```

### Pre-Authorisation

You can also pre-authorise a charge (if enabled for your account), effectively putting a hold on a customer's card, like so:

```php
use Carbon\Carbon;
use StGeorgeIPG\Exceptions\ResponseCodes\Exception;

$oneYearAhead = (new Carbon())->addYear();

$amount     = 10.00; // In dollars
$cardNumber = '4111111111111111';
$month      = $oneYearAhead->month;
$year       = $oneYearAhead->year;

$preAuthRequest = $client->preAuth($amount, $cardNumber, $month, $year);

try {
    $preAuthResponse = $client->execute($preAuthRequest);

    echo 'The pre-authorisation was successful.' . "\n";
} catch (Exception $ex) {
    echo 'The pre-authorisation was unsuccessful.' . "\n";
    echo $ex->getMessage() . "\n";

    var_dump($preAuthRequest);
    var_dump($ex->getResponse());
}
```

### Completion

After a successful pre-authorisation, you can complete the transaction, like so:

```php
use Carbon\Carbon;
use StGeorgeIPG\Exceptions\ResponseCodes\Exception;

$oneYearAhead = (new Carbon())->addYear();

$amount     = 10.00; // In dollars
$cardNumber = '4111111111111111';
$month      = $oneYearAhead->month;
$year       = $oneYearAhead->year;

$preAuthRequest = $client->preAuth($amount, $cardNumber, $month, $year);

try {
    $preAuthResponse = $client->execute($preAuthRequest);

    echo 'The pre-authorisation was successful.' . "\n";

    $completionRequest = $client->completion($amount, $preAuthResponse->getTransactionReference(), $preAuthResponse->getAuthorisationNumber()); // In dollars

    try {
        $completionResponse = $client->execute($completionRequest);

        echo 'The completion was successful.' . "\n";
    } catch (Exception $ex) {
        echo 'The completion was unsuccessful.' . "\n";
        echo $ex->getMessage() . "\n";

        var_dump($completionRequest);
        var_dump($ex->getResponse());
    }
} catch (Exception $ex) {
    echo 'The pre-authorisation was unsuccessful.' . "\n";
    echo $ex->getMessage() . "\n";

    var_dump($preAuthRequest);
    var_dump($ex->getResponse());
}
```

### Handling Errors

The library will throw an exception if the request was not successful, which makes it easy to determine the outcome of a transaction.

Common error codes, such as when the customer has insufficient funds, or has used an invalid card number, have been mapped to [special exceptions](https://github.com/mitchdav/st-george-ipg/tree/master/src/Exceptions/ResponseCodes) for you to use at your leisure. These special exceptions are instances of ```\StGeorge\Exceptions\ResponseCodes\Exception```, which lets you call ```$ex->getResponse()``` to retrieve the response. By catching this you can catch all errors where a response was obtained.

For errors where a response wasn't obtained, such as when a transaction fails, or remains in progress after 3 status checks, other exceptions are called, so check the [Client](https://github.com/mitchdav/st-george-ipg/blob/master/src/Client.php) class for more details (in the ```getResponse()``` method). You can catch these using the generic ```\Exception``` class.

If there is a local error, indicated by a response code of ```-1```, the exception will map to an instance of ```\StGeorge\Exceptions\ResponseCodes\LocalErrors\Exception```, with specific exceptions in the [local errors](https://github.com/mitchdav/st-george-ipg/tree/master/src/Exceptions/ResponseCodes/LocalErrors) folder. These exceptions typically indicate a connection issue, or a problem with the client ID or certificate password.

## Testing

Now that you have a working installation, you can run the below testing commands:

- ```composer test``` to run all of the available testsuites
- ```composer test:unit``` to run the unit testsuite
- ```composer test:integration``` to run the integration testsuite
- ```composer test:end-to-end``` to run the end-to-end testsuite

The end-to-end testsuite connects to St.George's test server to run test transactions for all response codes from 00 - 99, so for this testsuite to run, you will need to have installed Webpay and setup your ```IPG_CLIENT_ID``` and ```IPG_AUTHENTICATION_TOKEN``` (for the WebService) or ```IPG_CERTIFICATE_PASSWORD``` (for the Extension) environment variables.

## Installing Webpay

**Note:** *As of July 2017 these instructions (both Docker and manual installation) were working correctly to connect to St.George. Unfortunately, when run after that period they will still compile and install correctly, but upon connecting to the St.George IPG server, **it will give an SSL connection error which I haven't been able to resolve**. If you find a solution please [let me know](https://github.com/mitchdav/st-george-ipg/issues).*

### Installing with Docker

The Webpay library is painful to install manually, so a Dockerfile has been provided for you which will get you **mostly** setup.

You can build it using the Dockerfile in this repository:

    docker build -t mitchdav/st-george-ipg .

Once you have the built container, you can run it using the following:

    docker run -e IPG_CLIENT_ID='10000000' -e IPG_CERTIFICATE_PASSWORD='password' -i -t mitchdav/st-george-ipg /bin/bash

Where you substitute in your own St.George-provided client ID and certificate password.

### Installing Manually

If you are unable to use Docker, you can follow the below guideline of commands to run on a fresh AWS EC2 install of Ubuntu 16.04 (currently AMI ami-96666ff5). For all other installations, you will need to read the [Linux API Developer Guide](https://www.ipg.stgeorge.com.au/downloads/Linux_API_Developer_Guide_v3.3.pdf) and resolve any issues for yourself.

    sudo apt-get update -y
    sudo apt-get install -y python-software-properties
    sudo add-apt-repository -y ppa:ondrej/php
    sudo apt-get update -y
    sudo apt-get install -y swig gcc unzip php5.6 php5.6-cli php5.6-common php5.6-mbstring php5.6-gd php5.6-intl php5.6-xml php5.6-mysql php5.6-mcrypt php5.6-zip php5.6-dev composer
    sudo ln -s /lib/x86_64-linux-gnu/libcrypto.so.1.0.0 /lib/libcrypto.so.6
    sudo ln -s /lib/x86_64-linux-gnu/libssl.so.1.0.0 /lib/libssl.so.6
    wget https://www.ipg.stgeorge.com.au/downloads/StGeorgeLinuxAPI-3.3.tar.gz
    tar -xzvf StGeorgeLinuxAPI-3.3.tar.gz
    cd webpaySWIG-3.3/
    sed -i 's\PHP_EXTENSIONS  = /usr/lib64/php/modules\PHP_EXTENSIONS  = /usr/lib/php/20131226\g' makefilePhp5
    sed -i 's\PHP_INCLUDE_DIR = /usr/include/php/\PHP_INCLUDE_DIR = /usr/include/php/20131226/\g' makefilePhp5
    sudo make -f makefilePhp5
    sudo echo "extension=webpay_php.so" >> /etc/php/5.6/cli/php.ini
    php -i | grep webpay

You will know that you've successfully installed the library if you see the output of the last command like so:

    webpay
    Client Type => webpayPHP5
    Webpay PHP Library => webpay_php.so
    Webpay Core Library => libwebpayclient.so

You will then need to download the certificate, using these commands in whichever directory you intend to run the project in:

    wget https://www.ipg.stgeorge.com.au/downloads/cert.zip
    unzip cert.zip

Note that this is done automatically for you when installing using Docker.

Finally, export your own St.George-provided client ID and certificate password like so:

    export IPG_CLIENT_ID='10000000'
    export IPG_CERTIFICATE_PASSWORD='password'

Some useful Stack Overflow questions to troubleshoot with are here:
- [wrap_newBundle not available SWIG & webpay](https://stackoverflow.com/q/5728605/7503569)
- [can't install webpay extension with php?](https://stackoverflow.com/q/5699492/7503569)

## Further Information

Further information about the St.George Internet Payment Gateway can be found [here](https://www.ipg.stgeorge.com.au/StgWeb/static/customised/ipgdownload.jsp). The relevant files are:
- [Generic API Developer Guide](https://www.ipg.stgeorge.com.au/downloads/Generic_API_Developer_Guide_20100222.pdf)
- [Linux API Developer Guide](https://www.ipg.stgeorge.com.au/downloads/Linux_API_Developer_Guide_v3.3.pdf)
- [IPG Response Code Table](https://www.ipg.stgeorge.com.au/downloads/Responsecodes_20051223.pdf)