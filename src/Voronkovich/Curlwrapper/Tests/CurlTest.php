<?php
namespace Voronkovich\Curlwrapper\Tests;

use Voronkovich\Curlwrapper\Curl;
use Voronkovich\Curlwrapper\Exceptions;

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
    * @expectedException Voronkovich\Curlwrapper\Exceptions\UnsupportedProtocolException
    */
    public function execute_invalidProtocol_shouldThrowException()
    {
        $this->curl->setOption(CURLOPT_URL, "xxx://localhost");
        $this->curl->execute();
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\CouldntResolveHostException
    */
    public function execute_invalidHost_shouldThrowException()
    {
        $this->curl->setOption(CURLOPT_URL, "http://unknownhost");
        $this->curl->execute();
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\CouldntResolveHostException
    */
    public function throwException_passCouldntResolveHostErrorCode_shouldThrowException()
    {
        $this->callThrowExceptionMethod(CURLE_COULDNT_RESOLVE_HOST);
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\CouldntResolveProxyException
    */
    public function throwException_passCouldntResolveProxyErrorCode_shouldThrowException()
    {
        $this->callThrowExceptionMethod(CURLE_COULDNT_RESOLVE_PROXY);
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\CouldntConnectException
    */
    public function throwException_passCouldntConnectErrorCode_shouldThrowException()
    {
        $this->callThrowExceptionMethod(CURLE_COULDNT_CONNECT);
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\OperationTimeoutedException
    */
    public function throwException_passOperationTimeoutedErrorCode_shouldThrowException()
    {
        $this->callThrowExceptionMethod(CURLE_OPERATION_TIMEOUTED);
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\TooManyRedirectsException
    */
    public function throwException_passTooManyRedirectsErrorCode_shouldThrowException()
    {
        $this->callThrowExceptionMethod(CURLE_TOO_MANY_REDIRECTS);
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\UnsupportedProtocolException
    */
    public function throwException_passUnsupportedProtocolErrorCode_shouldThrowException()
    {
        $this->callThrowExceptionMethod(CURLE_UNSUPPORTED_PROTOCOL);
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\Ftp\AccessDeniedException
    */
    public function throwException_passAccessDeniedErrorCode_shouldThrowException()
    {
        $this->callThrowExceptionMethod(CURLE_FTP_ACCESS_DENIED);
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\Ftp\FtpException
    */
    public function throwException_passAnyFtpErrorCode_shouldThrowException()
    {
        $this->callThrowExceptionMethod(CURLE_FTP_CANT_RECONNECT);
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\Http\PageNotFoundException
    */
    public function throwException_passHttpNotFoundErrorCode_shouldThrowException()
    {
        $this->callThrowExceptionMethod(CURLE_HTTP_NOT_FOUND);
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\Http\HttpException
    */
    public function throwException_passAnyHttpErrorCode_shouldThrowException()
    {
        $this->callThrowExceptionMethod(CURLE_HTTP_POST_ERROR);
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\Ssl\ConnectException
    */
    public function throwException_passSslConnectErrorCode_shouldThrowException()
    {
        $this->callThrowExceptionMethod(CURLE_SSL_CONNECT_ERROR);
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\Ssl\UnverifiedCertificateException
    */
    public function throwException_passSslPeerSertificateErrorCode_shouldThrowException()
    {
        $this->callThrowExceptionMethod(CURLE_SSL_PEER_CERTIFICATE);
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\Ssl\SslException
    */
    public function throwException_passAnySslErrorCode_shouldThrowException()
    {
        $this->callThrowExceptionMethod(CURLE_SSL_ENGINE_SETFAILED);
    }

    /**
    * @test
    * @expectedException Voronkovich\Curlwrapper\Exceptions\CurlException
    */
    public function throwException_passUnknownErrorCode_shouldThrowDefaultException()
    {
        $this->callThrowExceptionMethod(-1);
    }

    private function callThrowExceptionMethod($errorCode, $errorMessage = "")
    {
        $throwException = new \ReflectionMethod($this->curl, 'throwException');
        $throwException->setAccessible(true);
        $throwException->invoke($this->curl, $errorCode, $errorMessage);
    }
}
