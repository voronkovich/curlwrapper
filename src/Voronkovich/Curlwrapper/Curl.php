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
}
