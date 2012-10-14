<?php
namespace Voronkovich\Curlwrapper\Tests;

use Voronkovich\Curlwrapper\Curl;

class CurlTest extends \PHPUnit_Framework_TestCase
{
    private $curl;

    protected function setUp()
    {
        $this->curl = new Curl();
    }

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
    public function setOption_setValidCurlOption_shouldReturnTrue()
    {
        $result = $this->curl->setOption(CURLOPT_AUTOREFERER, true);
        $this->assertTrue($result);
    }

    /**
    * @test
    */
    public function execute_validData_shouldReturnTrue()
    {
        $this->curl->setOption(CURLOPT_URL, "http://localhost");
        $result = $this->curl->execute();
        $this->assertTrue($result);
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\CurlException
    */
    public function execute_invalidProtocol_shouldThrowException()
    {
        $this->curl->setOption(CURLOPT_URL, "xxx://localhost");
        $this->curl->execute();
    }
}
