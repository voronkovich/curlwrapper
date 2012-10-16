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

    private function handleError()
    {
        $errorCode = curl_errno($this->curl);

        if ($errorCode !== CURLE_OK) {
            $errorMessage = curl_error($this->curl);
            $this->throwException($errorCode, $errorMessage);
        }
    }

    protected function throwException($errorCode, $errorMessage)
    {
        switch ($errorCode) {
            // Common errors
            case CURLE_COULDNT_RESOLVE_HOST:
                throw new Exceptions\CouldntResolveHostException($errorMessage, $errorCode);
                break;
            case CURLE_COULDNT_RESOLVE_PROXY:
                throw new Exceptions\CouldntResolveProxyException($errorMessage, $errorCode);
                break;
            case CURLE_COULDNT_CONNECT:
                throw new Exceptions\CouldntConnectException($errorMessage, $errorCode);
                break;
            case CURLE_OPERATION_TIMEOUTED:
                throw new Exceptions\OperationTimeoutedException($errorMessage, $errorCode);
                break;
            case CURLE_TOO_MANY_REDIRECTS:
                throw new Exceptions\TooManyRedirectsException($errorMessage, $errorCode);
                break;
            case CURLE_UNSUPPORTED_PROTOCOL:
                throw new Exceptions\UnsupportedProtocolException($errorMessage, $errorCode);
                break;

            // FTP errors
            case CURLE_FTP_ACCESS_DENIED:
                throw new Exceptions\Ftp\AccessDeniedException($errorMessage, $errorCode);
                break;
            case CURLE_FTP_WEIRD_SERVER_REPLY:
            case CURLE_FTP_WEIRD_PASS_REPLY:
            case CURLE_FTP_WEIRD_USER_REPLY:
            case CURLE_FTP_WEIRD_PASV_REPLY:
            case CURLE_FTP_WEIRD_227_FORMAT:
            case CURLE_FTP_CANT_GET_HOST:
            case CURLE_FTP_CANT_RECONNECT:
            case CURLE_FTP_COULDNT_SET_BINARY:
            case CURLE_FTP_COULDNT_RETR_FILE:
            case CURLE_FTP_WRITE_ERROR:
            case CURLE_FTP_QUOTE_ERROR:
            case CURLE_FTP_COULDNT_STOR_FILE:
            case CURLE_FTP_COULDNT_SET_ASCII:
            case CURLE_FTP_PORT_FAILED:
            case CURLE_FTP_COULDNT_USE_REST:
            case CURLE_FTP_COULDNT_GET_SIZE:
            case CURLE_FTP_BAD_DOWNLOAD_RESUME:
            case CURLE_FTP_SSL_FAILED:
                throw new Exceptions\Ftp\FtpException($errorMessage, $errorCode);
                break;

            // HTTP errors
            case CURLE_HTTP_NOT_FOUND:
                throw new Exceptions\Http\PageNotFoundException($errorMessage, $errorCode);
                break;
            case CURLE_HTTP_POST_ERROR:
            case CURLE_HTTP_PORT_FAILED:
            case CURLE_HTTP_RANGE_ERROR:
                throw new Exceptions\Http\HttpException($errorMessage, $errorCode);
                break;
                
            // SSL errors
            case CURLE_SSL_CONNECT_ERROR:
                throw new Exceptions\Ssl\ConnectException($errorMessage, $errorCode);
                break;
            case CURLE_SSL_PEER_CERTIFICATE:
                throw new Exceptions\Ssl\UnverifiedCertificateException($errorMessage, $errorCode);
                break;
            case CURLE_SSL_CIPHER:
            case CURLE_SSL_ENGINE_NOTFOUND:
            case CURLE_SSL_ENGINE_SETFAILED:
            case CURLE_SSL_CERTPROBLEM:
                throw new Exceptions\Ssl\SslException($errorMessage, $errorCode);
                break;

            default:
                throw new Exceptions\CurlException($errorMessage, $errorCode);
        }
    }
}
