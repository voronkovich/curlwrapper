<?php
namespace Voronkovich\Curlwrapper;

/**
 * Object oriented wrapper for curl. 
 * 
 * @package Curlwrapper
 * @version $id$
 * @copyright Oleg Voronkovich
 * @author Oleg Voronkovich <oleg-voronkovich@yandex.ru> 
 * @license BSD-3-Clause
 */
class Curl
{
    private $curl;

    public function __construct($url = null)
    {
        $this->curl = curl_init($url);
    }

    public function setOption($option, $value)
    {
        return curl_setopt($this->curl, $option, $value);
    }

    public function execute()
    {
        if ($result = curl_exec($this->curl))
            return $result;

        $this->handleError();
    }

    protected function handleError()
    {
        $errorCode = curl_errno($this->curl);

        if ($errorCode !== CURLE_OK) {
            $errorMessage = curl_error($this->curl);

            switch ($errorCode) {
                case CURLE_UNSUPPORTED_PROTOCOL:
                    throw new Exceptions\UnsupportedProtocolException($errorMessage, $errorCode);
                    break;
                case CURLE_COULDNT_RESOLVE_HOST:
                    throw new Exceptions\CouldntResolveHostException($errorMessage, $errorCode);
                    break;
                default:
                    throw new Exceptions\CurlException($errorMessage, $errorCode);
            }
        }
    }
}
