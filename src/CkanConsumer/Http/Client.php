<?php
/**
 * Interface for HTTP clients
 *
 * PHP version 5.4
 *
 * @category   CkanConsumer
 * @package    Http
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace CkanConsumer\Http;

/**
 * Interface for HTTP clients
 *
 * @category   CkanConsumer
 * @package    Http
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Client
{
    /**
     * Sets the maximum number of allowed redirects before giving up
     *
     * @param int $maxRedirects Maximum redirects for client
     *
     * @return \CkanConsumer\Http\Client The HTTP client
     */
    public function setMaxRedirects($redirects);

    /**
     * Set the timeout for the requests
     *
     * @param int $timeout Request timeout time for client in seconds
     *
     * @return \CkanConsumer\Http\Client The HTTP client
     */
    public function setTimeout($timeout);

    /**
     * Makes a POST request
     *
     * @param string $uri     The URI to make the request to
     * @param array  $body    The request body
     * @param array  $headers The headers of the request
     *
     * @return string The response
     */
    public function post($uri, array $body = [], array $headers = []);

    /**
     * Makes a GET request
     *
     * @param string $uri     The URI to make the request to
     * @param array  $headers The headers of the request
     *
     * @return string The response
     */
    public function get($uri, array $headers = []);
}
