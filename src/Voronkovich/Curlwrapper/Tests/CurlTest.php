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

    /**
    * @test
    */
    public function setValidCurlOption_shouldReturnTrue()
    {
        $curl = new Curl();
        $result = $curl->setOption(CURLOPT_AUTOREFERER, true);
        $this->assertTrue($result);
    }
}
