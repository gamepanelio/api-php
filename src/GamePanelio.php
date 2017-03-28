<?php

namespace GamePanelio;

use GamePanelio\AccessToken\AccessToken;
use GamePanelio\Exception\ApiCommunicationException;
use Http\Client\Exception\TransferException;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class GamePanelio
{
    const API_BASE = "/api/v1";

    /**
     * @var string
     */
    private $panelHostname;

    /**
     * @var UriInterface
     */
    private $uri;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var AccessToken
     */
    private $accessToken;

    /**
     * GamePanelio constructor.
     * @param string $panelHostname
     * @param AccessToken $accessToken
     */
    public function __construct($panelHostname, AccessToken $accessToken)
    {
        $this->panelHostname = $panelHostname;
        $this->uri = UriFactoryDiscovery::find()->createUri($this->panelHostname)
            ->withHost($this->panelHostname)
            ->withScheme("https")
            ->withPath(self::API_BASE);
        $this->accessToken = $accessToken;
        $this->httpClient = HttpClientDiscovery::find();
    }

    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    private function createRequest()
    {
        return MessageFactoryDiscovery::find()
            ->createRequest(
                "GET",
                $this->uri,
                [
                    'Authorization' => 'Bearer ' . $this->accessToken->getBearerToken()
                ]
            );
    }

    /**
     * @param RequestInterface $request
     * @return array
     */
    private function sendRequest(RequestInterface $request)
    {
        try {
            $response = $this->httpClient->sendRequest($request);

            return json_decode($response->getBody(), true);
        } catch (TransferException $e) {
            throw ApiCommunicationException::wrap($e);
        }
    }

    /**
     * @param $body
     * @return StreamInterface
     */
    private function createStreamFor($body)
    {
        return StreamFactoryDiscovery::find()->createStream($body);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getUser($id)
    {
        $request = $this->createRequest()
            ->withMethod("GET")
            ->withUri($this->uri->withPath(self::API_BASE . '/users/' . urlencode($id)));

        return $this->sendRequest($request);
    }

    /**
     * @param $username
     * @return array
     */
    public function getUserByUsername($username)
    {
        $request = $this->createRequest()
            ->withMethod("GET")
            ->withUri($this->uri->withPath(self::API_BASE . '/users/username/' . urlencode($username)));

        return $this->sendRequest($request);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function createUser($parameters)
    {
        $request = $this->createRequest()
            ->withMethod("POST")
            ->withUri($this->uri->withPath(self::API_BASE . '/users'))
            ->withBody($this->createStreamFor(json_encode($parameters)));

        return $this->sendRequest($request);
    }

    /**
     * @param int $id
     * @param array $parameters
     * @param bool $replaceAll
     * @return array
     */
    public function updateUser($id, $parameters, $replaceAll = false)
    {
        $request = $this->createRequest()
            ->withMethod($replaceAll ? "PUT" : "PATCH")
            ->withUri($this->uri->withPath(self::API_BASE . '/users/' . urlencode($id)))
            ->withBody($this->createStreamFor(json_encode($parameters)));

        return $this->sendRequest($request);
    }

    /**
     * @param int $id
     * @return array
     */
    public function deleteUser($id)
    {
        $request = $this->createRequest()
            ->withMethod("DELETE")
            ->withUri($this->uri->withPath(self::API_BASE . '/users/' . urlencode($id)));

        return $this->sendRequest($request);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getServer($id)
    {
        $request = $this->createRequest()
            ->withMethod("GET")
            ->withUri($this->uri->withPath(self::API_BASE . '/servers/' . urlencode($id)));

        return $this->sendRequest($request);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function createServer($parameters)
    {
        $request = $this->createRequest()
            ->withMethod("POST")
            ->withUri($this->uri->withPath(self::API_BASE . '/servers'))
            ->withBody($this->createStreamFor(json_encode($parameters)));

        return $this->sendRequest($request);
    }

    /**
     * @param int $id
     * @param array $parameters
     * @param bool $replaceAll
     * @return array
     */
    public function updateServer($id, $parameters, $replaceAll = false)
    {
        $request = $this->createRequest()
            ->withMethod($replaceAll ? "PUT" : "PATCH")
            ->withUri($this->uri->withPath(self::API_BASE . '/servers/' . urlencode($id)))
            ->withBody($this->createStreamFor(json_encode($parameters)));

        return $this->sendRequest($request);
    }

    /**
     * @param int $id
     * @return array
     */
    public function deleteServer($id)
    {
        $request = $this->createRequest()
            ->withMethod("DELETE")
            ->withUri($this->uri->withPath(self::API_BASE . '/servers/' . urlencode($id)));

        return $this->sendRequest($request);
    }
}
