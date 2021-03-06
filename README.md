curlwrapper
===========

Object oriented wrapper for curl. Require PHP 5.3+. May be installed by Composer.

Usage:
    
```php
<?php

use Voronkovich\Curlwrapper\Curl;
use Voronkovich\Curlwrapper\Exceptions as CurlExceptions;

$curl = new Curl();
$curl->setOption(CURL_SOME_OPTION, "value");

try {
    $result = $curl->execute();
} catch (CurlExceptions\CouldntResolveHostException $e) {
    // Host not found
    echo $e->getMessage();
} catch (CurlExceptions\CouldntConnectException $e) {
    // Connection failed
    echo $e->getMessage();
} catch (CurlExceptions\CurlException $e) {
    // Base exception
    echo $e->getMessage();
}
```
