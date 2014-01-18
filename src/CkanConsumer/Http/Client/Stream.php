<?php
/**
 * HTTP client based on file_get_contents()
 *
 * PHP version 5.4
 *
 * @category   CkanConsumer
 * @package    Http
 * @subpackage Client
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace CkanConsumer\Http\Client;

use CkanConsumer\Http\Client;

/**
 * HTTP client based on file_get_contents()
 *
 * @category   CkanConsumer
 * @package    Http
 * @subpackage Client
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Stream implements Client
{
    /**
     * @var string The user agent string
     */
    protected $userAgent;

    /**
     * @var int The maximum number of redirects
     */
    protected $maxRedirects = 5;

    /**
     * @var int The maximum timeout
     */
    protected $timeout = 15;

    /**
     * Creates instance
     *
     * @param string $userAgent The UA string the client will use
     */
    public function __construct($userAgent = 'CkanConsumerLib')
    {
        $this->userAgent = $userAgent;
    }

    /**
     * Sets the maximum number of allowed redirects before giving up
     *
     * @param int $maxRedirects Maximum redirects for client
     *
     * @return \CkanConsumer\Http\Client The HTTP client
     */
    public function setMaxRedirects($redirects)
    {
        $this->maxRedirects = $redirects;

        return $this;
    }

    /**
     * Set the timeout for the requests
     *
     * @param int $timeout Request timeout time for client in seconds
     *
     * @return \CkanConsumer\Http\Client The HTTP client
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Makes a POST request
     *
     * @param string $uri     The URI to make the request to
     * @param array  $body    The request body
     * @param array  $headers The headers of the request
     *
     * @return string The response
     */
    public function post($uri, array $body = [], array $headers = [])
    {
        if (!empty($body) && !array_key_exists('Content-Type', $headers)) {
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        }

        return $this->request($uri, 'POST', http_build_query($body, '', '&'), $headers);
    }

    /**
     * Makes a GET request
     *
     * @param string $uri     The URI to make the request to
     * @param array  $headers The headers of the request
     *
     * @return string The response
     */
    public function get($uri, array $headers = [])
    {
        return $this->request($uri, 'GET', null, $headers);
    }

    /**
     * Makes a request
     *
     * @param string $uri     The URI to make the request to
     * @param string $body    The request body
     * @param array  $headers The headers of the request
     * @param string $method  The method of the request
     *
     * @return string The response
     */
    private function request($uri, $method, $body, array $headers = [])
    {
        $headers[] = 'Content-Length: ' . strlen($body);
        $headers[] = 'Connection: close';

        $response = file_get_contents(
            $uri,
            false,
            $this->generateStreamContext($body, $headers, $method)
        );

        return $response;
    }

    /**
     * Creates the stream's context
     *
     * @param string $body    The body of the request
     * @param array  $headers The headers of the request
     * @param string $method  The method of the request
     *
     * @return resource The stream's context
     */
    private function generateStreamContext($body, $headers, $method)
    {
        return stream_context_create([
            'http' => [
                'method'           => $method,
                'header'           => implode("\r\n", $headers),
                'content'          => $body,
                'protocol_version' => '1.1',
                'user_agent'       => $this->userAgent,
                'max_redirects'    => $this->maxRedirects,
                'timeout'          => $this->timeout,
            ],
        ]);
    }
}
