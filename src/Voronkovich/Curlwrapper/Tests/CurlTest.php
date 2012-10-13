<?php
namespace Voronkovich\Curlwrapper\Tests;

use Voronkovich\Curlwrapper\Curl;

class CurlTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @test
    */
    public function createCurl()
    {
        $curl = new Curl();
        $this->assertInstanceOf('\Voronkovich\Curlwrapper\Curl', $curl);
    }
}
